<?php declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

$hookTargetPatcher = require __DIR__ . '/scoper-hook-patcher.php';

return [
    'prefix' => 'Odigos',

    'finders' => [
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->name('*.php')
            ->notName('autoload.php')
            ->exclude(['bin', 'composer'])
            ->in('vendor'),
    ],

    // Scope ALL vendor namespaces to prevent version conflicts with customer applications.
    //
    // Exceptions (must remain unscoped):
    //  1. OpenTelemetry\{API,SDK,Context,SemConv} — shared with the C extension / agent runtime
    //  2. Psr — interfaces bridge customer objects and instrumentation callbacks
    //  3. Composer — autoloader internals
    //  4. MongoDB\Driver — PHP extension APIs (subscriber interfaces / monitoring functions)
    //
    // Hook-target libraries (GuzzleHttp, Slim, Illuminate, Symfony, …) ARE scoped. A patcher
    // rewrites auto-instrumentation to use string-literal FQCNs and relaxed typehints so hooks
    // still attach to the customer's unscoped classes without the agent providing those classes.
    //
    // NOTE: We exclude specific OpenTelemetry\* sub-namespaces rather than the root "OpenTelemetry"
    // because PHP namespaces are case-insensitive and PHP-Scoper follows suit. Excluding
    // "OpenTelemetry" would also exclude "Opentelemetry\Proto" (generated protobuf, lowercase 't'),
    // which MUST be scoped. The protobuf descriptor pool lookup is fixed via a patcher below.
    'exclude-namespaces' => [
        'OpenTelemetry\API',
        'OpenTelemetry\SDK',
        'OpenTelemetry\Context',
        'OpenTelemetry\SemConv',

        // PSR interfaces (bridge between customer code and instrumentation).
        // Use a regex anchored to the Psr\ root — a bare 'Psr' string exclusion also
        // matches GuzzleHttp\Psr7 (segment prefix), which breaks scoped Guzzle OTLP export.
        '/^Psr\\\\/',

        // PHP mongodb extension APIs only (userland MongoDB\ library is scoped)
        'MongoDB\Driver',

        // Composer autoloader internals
        'Composer',
    ],

    'exclude-classes' => [],
    'exclude-functions' => [
        'OpenTelemetry\Instrumentation\hook',
    ],
    'exclude-constants' => [],
    'patchers' => [
        // Convert hook(::class) + relax typehints/instanceof for scoped hook-target libraries.
        $hookTargetPatcher,

        // PHP-Scoper generates self-referencing class_alias() calls when a global-scope class has the same name as an excluded namespace (e.g. class OpenAI in global ns vs excluded OpenAI\ namespace).
        // A self-alias is always an error at runtime, so strip them.
        static function (string $filePath, string $prefix, string $content): string {
            return preg_replace(
                '/^\\\\class_alias\(\'([^\']+)\',\s*\'\\1\',\s*\\\\false\);\s*$/m',
                '',
                $content
            ) ?? $content;
        },
        // `exclude-namespaces` keeps classes inside OpenTelemetry\{SDK,API,Context,SemConv} un-prefixed, but PHP-Scoper still prefixes a bare namespace-alias `use` of the namespace itself (e.g. upstream `use OpenTelemetry\SDK;` → `use Odigos\OpenTelemetry\SDK;`). Later references like `SDK\Resource\ResourceInfo` then resolve to non-existent `Odigos\OpenTelemetry\SDK\...`, causing TypeError at runtime. Strip the prefix back off these specific imports.
        static function (string $filePath, string $prefix, string $content): string {
            $pattern = '/^use\s+' . preg_quote($prefix, '/') . '\\\\OpenTelemetry\\\\(SDK|API|Context|SemConv)(\b[^;]*);/m';
            return preg_replace($pattern, 'use OpenTelemetry\\\\$1$2;', $content) ?? $content;
        },
        // Protobuf scoping compatibility: the descriptor pool registers classes by the original PHP names derived from .proto files. After scoping, our classes have the Odigos\ prefix.
        // Rather than patching every downstream lookup and type-check, we prefix class names at the source: the Descriptor/EnumDescriptor setClass methods.
        // This makes the entire protobuf runtime (descriptor pool, RepeatedField, GPBUtil type checks) consistently use scoped class names.
        static function (string $filePath, string $prefix, string $content): string {
            $isDesc = str_ends_with($filePath, 'Google/Protobuf/Internal/Descriptor.php');
            $isEnum = str_ends_with($filePath, 'Google/Protobuf/Internal/EnumDescriptor.php');
            if (!$isDesc && !$isEnum) {
                return $content;
            }
            $fix = "\\strpos(\$klass, '{$prefix}\\\\') === 0 ? \$klass : '{$prefix}\\\\' . \$klass";
            $content = str_replace(
                '$this->klass = $klass;',
                "\$this->klass = {$fix};",
                $content
            );
            $content = str_replace(
                '$this->legacy_klass = $klass;',
                "\$this->legacy_klass = {$fix};",
                $content
            );
            if ($isDesc) {
                $content = str_replace(
                    '$this->previous_klass = $klass;',
                    "\$this->previous_klass = {$fix};",
                    $content
                );
            }
            return $content;
        },
    ],
];

<?php declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

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

    // Scope ALL vendor namespaces to prevent version conflicts with customer applications, EXCEPT namespaces that must remain unscoped because:
    //  1. The C extension provides functions in the OpenTelemetry\Instrumentation namespace
    //  2. Auto-instrumentation registers hooks by class name — the class string must match the customer's actual runtime class
    //  3. PSR interfaces bridge customer code and instrumentation
    //
    // NOTE: We exclude specific OpenTelemetry\* sub-namespaces rather than the root "OpenTelemetry" because PHP namespaces are case-insensitive and PHP-Scoper follows suit. Excluding "OpenTelemetry" would also exclude "Opentelemetry\Proto" (the generated protobuf code, lowercase 't'), which MUST be scoped to prevent version conflicts with customer apps.
    // The protobuf descriptor pool lookup is fixed via a patcher below.
    'exclude-namespaces' => [
        // OTel SDK, API, auto-instrumentation, C extension hooks
        'OpenTelemetry\API',
        'OpenTelemetry\SDK',
        'OpenTelemetry\Context',
        'OpenTelemetry\SemConv',

        // Framework namespaces targeted by auto-instrumentation hooks
        'Illuminate',
        'Laravel',
        'Symfony',
        'Cake',
        'yii',
        'Slim',
        'GuzzleHttp',
        'Doctrine',
        'MongoDB',
        'OpenAI',

        // PSR interfaces (bridge between customer code and instrumentation)
        'Psr',

        // php-http (Http\Client\HttpAsyncClient is a hook target)
        'Http',

        // Composer autoloader internals
        'Composer',
    ],

    'exclude-classes' => [],
    'exclude-functions' => [
        'OpenTelemetry\Instrumentation\hook',
    ],
    'exclude-constants' => [],
    'patchers' => [
        // PHP-Scoper generates self-referencing class_alias() calls when a global-scope class has the same name as an excluded namespace (e.g. class OpenAI in global ns vs excluded OpenAI\ namespace).
        // A self-alias is always an error at runtime, so strip them.
        static function (string $filePath, string $prefix, string $content): string {
            return preg_replace(
                '/^\\\\class_alias\(\'([^\']+)\',\s*\'\\1\',\s*\\\\false\);\s*$/m',
                '',
                $content
            );
        },
        // `exclude-namespaces` keeps classes inside OpenTelemetry\{SDK,API,Context,SemConv} un-prefixed, but PHP-Scoper still prefixes a bare namespace-alias `use` of the namespace itself (e.g. upstream `use OpenTelemetry\SDK;` → `use Odigos\OpenTelemetry\SDK;`). Later references like `SDK\Resource\ResourceInfo` then resolve to non-existent `Odigos\OpenTelemetry\SDK\...`, causing TypeError at runtime. Strip the prefix back off these specific imports.
        static function (string $filePath, string $prefix, string $content): string {
            $pattern = '/^use\s+' . preg_quote($prefix, '/') . '\\\\OpenTelemetry\\\\(SDK|API|Context|SemConv)(\b[^;]*);/m';
            return preg_replace($pattern, 'use OpenTelemetry\\\\$1$2;', $content);
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

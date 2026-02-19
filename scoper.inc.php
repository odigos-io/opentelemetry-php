<?php declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    'prefix' => 'Odigos',

    'finders' => [
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->name('*.php')
            ->notName(['installed.php', 'InstalledVersions.php'])
            ->exclude(['bin'])
            ->in('vendor'),
    ],

    // Scope ALL vendor namespaces to prevent version conflicts with customer applications, EXCEPT namespaces that must remain unscoped because:
    //  1. The C extension provides functions in the OpenTelemetry\Instrumentation namespace
    //  2. Auto-instrumentation registers hooks by class name — the class string must match the customer's actual runtime class
    //  3. PSR interfaces bridge customer code and instrumentation
    'exclude-namespaces' => [
        // Exclude framework/hook-target namespaces from scoping.
        // Uses regex so that Opentelemetry\Proto (lowercase t, protobuf generated code) is correctly SCOPED while OpenTelemetry\ (uppercase T, SDK/API/auto-instrumentation) is excluded.
        '/^(OpenTelemetry|Illuminate|Laravel|Symfony|Cake|yii|Slim|GuzzleHttp|Doctrine|MongoDB|OpenAI|Psr|Http|Composer)($|\\\\)/',
    ],

    'exclude-classes' => [],
    'exclude-functions' => [],
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
    ],
];

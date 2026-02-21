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

    // Scope ALL vendor namespaces to prevent version conflicts with customer
    // applications, EXCEPT namespaces that must remain unscoped because:
    //  1. The C extension provides functions in the OpenTelemetry\Instrumentation namespace
    //  2. Auto-instrumentation registers hooks by class name — the class string
    //     must match the customer's actual runtime class
    //  3. PSR interfaces bridge customer code and instrumentation
    //  4. Protobuf's descriptor pool maps PHP class names to message descriptors;
    //     scoping breaks this lookup (Google\Protobuf, Opentelemetry\Proto, GPBMetadata)
    'exclude-namespaces' => [
        // OTel packages — root exclusion covers API, SDK, Contrib, Context, SemConv,
        // AND Opentelemetry\Proto (lowercase 't') which is the generated protobuf code.
        // PHP namespaces are case-insensitive so this single entry covers both casings.
        'OpenTelemetry',

        // Protobuf runtime and descriptor metadata — the descriptor pool is global and
        // maps PHP class names to protobuf message names at construction time.
        // Scoping these classes adds a prefix that doesn't match registered descriptors.
        'Google',
        'GPBMetadata',

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
        // PHP-Scoper generates self-referencing class_alias() calls when a
        // global-scope class has the same name as an excluded namespace
        // (e.g. class OpenAI in global ns vs excluded OpenAI\ namespace).
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

<?php declare(strict_types=1);

/**
 * PHP-Scoper patcher: after hook-target libraries are scoped under Odigos\, rewrite
 * auto-instrumentation so hooks still attach to the *customer's* unscoped classes.
 *
 * 1. hook(Foo::class, ...) → hook('Foo\\Bar', ...)  (strip Odigos\ prefix)
 * 2. Relax concrete typehints / instanceof against those libraries so app objects
 *    are accepted (duck typing / is_a with the original FQCN).
 */

return static function (string $filePath, string $prefix, string $content): string {
    // Only touch OTel contrib auto-instrumentation packages.
    $normalized = str_replace('\\', '/', $filePath);
    if (!str_contains($normalized, '/opentelemetry-auto-') && !str_contains($normalized, '/open-telemetry/opentelemetry-auto-')) {
        return $content;
    }

    // Libraries we now scope but must still instrument in the customer app.
    // (Psr / OpenTelemetry / Composer / MongoDB\Driver stay excluded from scoping.)
    $targetRoots = [
        'Illuminate',
        'Laravel',
        'Symfony',
        'Cake',
        'yii',
        'Slim',
        'GuzzleHttp',
        'Doctrine',
        'OpenAI',
        'Http',
        'MongoDB', // userland library; MongoDB\Driver stays excluded
    ];

    $isTargetFqcn = static function (string $fqcn) use ($targetRoots, $prefix): ?string {
        $fqcn = ltrim($fqcn, '\\');
        if (str_starts_with($fqcn, $prefix . '\\')) {
            $fqcn = substr($fqcn, strlen($prefix) + 1);
        }
        foreach ($targetRoots as $root) {
            if ($fqcn === $root || str_starts_with($fqcn, $root . '\\')) {
                // Never rewrite extension APIs under MongoDB\Driver.
                if (str_starts_with($fqcn, 'MongoDB\\Driver')) {
                    return null;
                }
                return $fqcn;
            }
        }
        return null;
    };

    // Build alias → FQCN map from use statements (including group uses).
    $uses = [];
    if (preg_match_all('/^use\s+([^;]+);/m', $content, $useMatches)) {
        foreach ($useMatches[1] as $useClause) {
            $useClause = trim($useClause);
            if (str_starts_with($useClause, 'function ') || str_starts_with($useClause, 'const ')) {
                continue;
            }
            // Group use: Foo\Bar\{A, B as C}
            if (preg_match('/^(.+?)\\\\\{(.+)\}$/s', $useClause, $gm)) {
                $base = ltrim(trim($gm[1]), '\\');
                foreach (explode(',', $gm[2]) as $part) {
                    $part = trim($part);
                    if ($part === '') {
                        continue;
                    }
                    if (preg_match('/^(.+?)\s+as\s+(.+)$/i', $part, $am)) {
                        $uses[trim($am[2])] = $base . '\\' . ltrim(trim($am[1]), '\\');
                    } else {
                        $short = ltrim($part, '\\');
                        $uses[$short] = $base . '\\' . $short;
                    }
                }
                continue;
            }
            if (preg_match('/^(.+?)\s+as\s+(.+)$/i', $useClause, $am)) {
                $uses[trim($am[2])] = ltrim(trim($am[1]), '\\');
            } else {
                $fq = ltrim($useClause, '\\');
                $uses[substr(strrchr('\\' . $fq, '\\'), 1)] = $fq;
            }
        }
    }

    $resolve = static function (string $expr) use ($uses, $prefix): string {
        $expr = ltrim($expr, '\\');
        if (str_contains($expr, '\\')) {
            return $expr;
        }
        return $uses[$expr] ?? $expr;
    };

    $toStringLiteral = static function (string $fqcn): string {
        return "'" . str_replace('\\', '\\\\', $fqcn) . "'";
    };

    // --- 1) hook( ... ::class → string -----------------------------------
    // Match OpenTelemetry\Instrumentation\hook calls, not Foo::hook() / $this->hook().
    $content = preg_replace_callback(
        '/(?<!::)(?<!->)\bhook\(\s*(class:\s*)?((?:\\\\?[A-Za-z_][\w\\\\]*)::class)/',
        static function (array $m) use ($resolve, $isTargetFqcn, $toStringLiteral): string {
            $named = $m[1] ?? '';
            $expr = $m[2];
            $name = substr($expr, 0, -7); // strip ::class
            $fqcn = $resolve($name);
            $original = $isTargetFqcn($fqcn);
            if ($original === null) {
                return $m[0];
            }
            return 'hook(' . $named . $toStringLiteral($original);
        },
        $content
    ) ?? $content;

    // OpenAI passes Contract::class into hookApi() which forwards to hook($class, ...).
    $content = preg_replace_callback(
        '/hookApi\(\s*([^,]+),\s*((?:\\\\?[A-Za-z_][\w\\\\]*)::class)/',
        static function (array $m) use ($resolve, $isTargetFqcn, $toStringLiteral): string {
            $expr = $m[2];
            $name = substr($expr, 0, -7);
            $fqcn = $resolve($name);
            $original = $isTargetFqcn($fqcn);
            if ($original === null) {
                return $m[0];
            }
            return 'hookApi(' . $m[1] . ', ' . $toStringLiteral($original);
        },
        $content
    ) ?? $content;

    // --- 2) Relax parameter typehints for target FQCNs -------------------
    // Only rewrite "Type $var" / "?Type $var" forms (parameter positions).
    $builtins = ['null', 'true', 'false', 'array', 'string', 'int', 'float', 'bool', 'callable', 'iterable', 'object', 'mixed', 'void', 'never', 'self', 'static', 'parent'];
    $content = preg_replace_callback(
        '/(?<![A-Za-z0-9_\\\\])(\?)?((?:\\\\?[A-Za-z_][\w\\\\]*)(?:\s*\|\s*(?:\\\\?[A-Za-z_][\w\\\\]*))*)\s+(\$[A-Za-z_][\w]*)/',
        static function (array $m) use ($resolve, $isTargetFqcn, $builtins): string {
            $nullablePrefix = $m[1] ?? '';
            $typeExpr = $m[2];
            $var = $m[3];
            $parts = preg_split('/\s*\|\s*/', $typeExpr) ?: [];
            $replaced = false;
            $newParts = [];
            foreach ($parts as $part) {
                $part = trim($part);
                if ($part === '' || in_array(strtolower($part), $builtins, true)) {
                    $newParts[] = $part;
                    continue;
                }
                $fqcn = $resolve($part);
                $original = $isTargetFqcn($fqcn);
                if ($original !== null) {
                    $newParts[] = 'object';
                    $replaced = true;
                } else {
                    $newParts[] = $part;
                }
            }
            if (!$replaced) {
                return $m[0];
            }
            return $nullablePrefix . implode('|', $newParts) . ' ' . $var;
        },
        $content
    ) ?? $content;

    // --- 3) instanceof Target → is_a(..., 'Original\\FQCN') --------------
    $content = preg_replace_callback(
        '/\$([A-Za-z_][\w]*)\s+instanceof\s+(\??\\\\?[A-Za-z_][\w\\\\]*)/',
        static function (array $m) use ($resolve, $isTargetFqcn, $toStringLiteral): string {
            $var = '$' . $m[1];
            $type = ltrim($m[2], '?');
            $fqcn = $resolve($type);
            $original = $isTargetFqcn($fqcn);
            if ($original === null) {
                return $m[0];
            }
            return 'is_a(' . $var . ', ' . $toStringLiteral($original) . ')';
        },
        $content
    ) ?? $content;

    // --- 4) Guzzle Is::settled(appPromise) would TypeError on scoped Is --
    // Duck-type against PromiseInterface::PENDING ('pending').
    $content = preg_replace(
        '/\\\\?' . preg_quote($prefix, '/') . '\\\\GuzzleHttp\\\\Promise\\\\Is::settled\((\$[A-Za-z_][\w]*)\)/',
        '($1->getState() !== \'pending\')',
        $content
    ) ?? $content;
    $content = preg_replace(
        '/\bIs::settled\((\$[A-Za-z_][\w]*)\)/',
        '($1->getState() !== \'pending\')',
        $content
    ) ?? $content;

    return $content;
};

<?php

declare(strict_types=1);

namespace Odigos\CustomInstrumentation;

use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\Context;
use function OpenTelemetry\Instrumentation\hook;
use OpenTelemetry\SemConv\Attributes\CodeAttributes;
use Throwable;

/**
 * Registers OpenTelemetry hooks for user-configured PHP custom instrumentation probes.
 *
 * Probe configuration is delivered by Odigos via the ODIGOS_AGENT_CUSTOM_INSTRUMENTATIONS
 * environment variable (JSON matching the CustomInstrumentations API shape).
 */
final class Registrar
{
    public const NAME = 'odigos-custom';

    private const ENV_VAR = 'ODIGOS_AGENT_CUSTOM_INSTRUMENTATIONS';

    public static function register(): void
    {
        if (\extension_loaded('opentelemetry') === false) {
            return;
        }

        $probes = self::loadProbes();
        if ($probes === []) {
            return;
        }

        $instrumentation = new CachedInstrumentation(
            'io.odigos.php.custom',
            null,
            'https://opentelemetry.io/schemas/1.32.0',
        );

        foreach ($probes as $probe) {
            self::registerProbe($instrumentation, $probe);
        }
    }

    /**
     * @return list<array{className: string, functionName: string}>
     */
    private static function loadProbes(): array
    {
        $raw = \getenv(self::ENV_VAR);
        if ($raw === false || $raw === '') {
            return [];
        }

        try {
            $decoded = \json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            \trigger_error('Failed to decode ' . self::ENV_VAR . ' as JSON', E_USER_WARNING);
            return [];
        }

        if (!\is_array($decoded)) {
            return [];
        }

        // Accept either the full CustomInstrumentations object {"php":[...]} or a bare probe list.
        $phpProbes = $decoded['php'] ?? $decoded;
        if (!\is_array($phpProbes)) {
            return [];
        }

        $result = [];
        foreach ($phpProbes as $probe) {
            if (!\is_array($probe)) {
                continue;
            }
            $functionName = $probe['functionName'] ?? '';
            if (!\is_string($functionName) || $functionName === '') {
                continue;
            }
            $className = $probe['className'] ?? '';
            if (!\is_string($className)) {
                $className = '';
            }
            $result[] = [
                'className' => $className,
                'functionName' => $functionName,
            ];
        }

        return $result;
    }

    /**
     * @param array{className: string, functionName: string} $probe
     */
    private static function registerProbe(CachedInstrumentation $instrumentation, array $probe): void
    {
        $className = $probe['className'] !== '' ? $probe['className'] : null;
        $functionName = $probe['functionName'];
        $spanName = $className !== null ? $className . '::' . $functionName : $functionName;

        hook(
            $className,
            $functionName,
            pre: static function (
                mixed $object,
                array $params,
                string $class,
                string $function,
                ?string $filename,
                ?int $lineno,
            ) use ($instrumentation, $spanName): void {
                $parent = Context::getCurrent();
                $span = $instrumentation->tracer()
                    ->spanBuilder($spanName)
                    ->setSpanKind(SpanKind::KIND_INTERNAL)
                    ->setParent($parent)
                    ->setAttribute(CodeAttributes::CODE_FUNCTION_NAME, $class !== '' ? $class . '::' . $function : $function)
                    ->setAttribute(CodeAttributes::CODE_FILE_PATH, $filename)
                    ->setAttribute(CodeAttributes::CODE_LINE_NUMBER, $lineno)
                    ->startSpan();

                Context::storage()->attach($span->storeInContext($parent));
            },
            post: static function (
                mixed $object,
                array $params,
                mixed $return,
                ?Throwable $exception,
            ): void {
                $scope = Context::storage()->scope();
                if ($scope === null) {
                    return;
                }

                $scope->detach();
                $span = Span::fromContext($scope->context());

                if ($exception !== null) {
                    $span->recordException($exception);
                    $span->setStatus(StatusCode::STATUS_ERROR, $exception->getMessage());
                }

                $span->end();
            },
        );
    }
}

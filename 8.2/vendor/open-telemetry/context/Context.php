<?php

declare (strict_types=1);
namespace OpenTelemetry\Context;

use function assert;
use const FILTER_VALIDATE_BOOLEAN;
use function filter_var;
use function spl_object_id;
/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/context/README.md#context
 */
final class Context implements \OpenTelemetry\Context\ContextInterface
{
    private const OTEL_PHP_DEBUG_SCOPES_DISABLED = 'OTEL_PHP_DEBUG_SCOPES_DISABLED';
    private static \OpenTelemetry\Context\ContextStorageInterface&\OpenTelemetry\Context\ExecutionContextAwareInterface $storage;
    // Optimization for spans to avoid copying the context array.
    private static \OpenTelemetry\Context\ContextKeyInterface $spanContextKey;
    private ?object $span = null;
    /** @var array<int, mixed> */
    private array $context = [];
    /** @var array<int, ContextKeyInterface> */
    private array $contextKeys = [];
    private function __construct()
    {
        self::$spanContextKey = \OpenTelemetry\Context\ContextKeys::span();
    }
    #[\Override]
    public static function createKey(string $key): \OpenTelemetry\Context\ContextKeyInterface
    {
        return new \OpenTelemetry\Context\ContextKey($key);
    }
    public static function setStorage(\OpenTelemetry\Context\ContextStorageInterface&\OpenTelemetry\Context\ExecutionContextAwareInterface $storage): void
    {
        self::$storage = $storage;
    }
    public static function storage(): \OpenTelemetry\Context\ContextStorageInterface&\OpenTelemetry\Context\ExecutionContextAwareInterface
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        return self::$storage ??= new \OpenTelemetry\Context\FiberBoundContextStorageExecutionAwareBC();
    }
    /**
     * @internal OpenTelemetry
     */
    public static function resolve(\OpenTelemetry\Context\ContextInterface|false|null $context, ?\OpenTelemetry\Context\ContextStorageInterface $contextStorage = null): \OpenTelemetry\Context\ContextInterface
    {
        return $context ?? ($contextStorage ?? self::storage())->current() ?: self::getRoot();
    }
    /**
     * @internal
     */
    public static function getRoot(): \OpenTelemetry\Context\ContextInterface
    {
        static $empty;
        return $empty ??= new self();
    }
    #[\Override]
    public static function getCurrent(): \OpenTelemetry\Context\ContextInterface
    {
        return self::storage()->current();
    }
    #[\Override]
    public function activate(): \OpenTelemetry\Context\ScopeInterface
    {
        $scope = self::storage()->attach($this);
        /** @psalm-suppress RedundantCondition @phpstan-ignore-next-line */
        assert(self::debugScopesDisabled() || $scope = new \OpenTelemetry\Context\DebugScope($scope));
        return $scope;
    }
    private static function debugScopesDisabled(): bool
    {
        return filter_var($_SERVER[self::OTEL_PHP_DEBUG_SCOPES_DISABLED] ?? \getenv(self::OTEL_PHP_DEBUG_SCOPES_DISABLED) ?: \ini_get(self::OTEL_PHP_DEBUG_SCOPES_DISABLED), FILTER_VALIDATE_BOOLEAN);
    }
    #[\Override]
    public function withContextValue(\OpenTelemetry\Context\ImplicitContextKeyedInterface $value): \OpenTelemetry\Context\ContextInterface
    {
        return $value->storeInContext($this);
    }
    #[\Override]
    public function with(\OpenTelemetry\Context\ContextKeyInterface $key, $value): self
    {
        if ($this->get($key) === $value) {
            return $this;
        }
        $self = clone $this;
        if ($key === self::$spanContextKey) {
            $self->span = $value;
            // @phan-suppress-current-line PhanTypeMismatchPropertyReal
            return $self;
        }
        $id = spl_object_id($key);
        if ($value !== null) {
            $self->context[$id] = $value;
            $self->contextKeys[$id] ??= $key;
        } else {
            unset($self->context[$id], $self->contextKeys[$id]);
        }
        return $self;
    }
    #[\Override]
    public function get(\OpenTelemetry\Context\ContextKeyInterface $key)
    {
        if ($key === self::$spanContextKey) {
            /** @psalm-suppress InvalidReturnStatement */
            return $this->span;
        }
        return $this->context[spl_object_id($key)] ?? null;
    }
}

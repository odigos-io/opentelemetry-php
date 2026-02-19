<?php

declare (strict_types=1);
namespace OpenTelemetry\Context;

/**
 * @internal
 */
final class FiberBoundContextStorageExecutionAwareBC implements \OpenTelemetry\Context\ContextStorageInterface, \OpenTelemetry\Context\ExecutionContextAwareInterface
{
    private readonly \OpenTelemetry\Context\FiberBoundContextStorage $storage;
    private ?\OpenTelemetry\Context\ContextStorage $bc = null;
    public function __construct()
    {
        $this->storage = new \OpenTelemetry\Context\FiberBoundContextStorage();
    }
    #[\Override]
    public function fork(int|string $id): void
    {
        $this->bcStorage()->fork($id);
    }
    #[\Override]
    public function switch(int|string $id): void
    {
        $this->bcStorage()->switch($id);
    }
    #[\Override]
    public function destroy(int|string $id): void
    {
        $this->bcStorage()->destroy($id);
    }
    private function bcStorage(): \OpenTelemetry\Context\ContextStorage
    {
        if ($this->bc === null) {
            $this->bc = new \OpenTelemetry\Context\ContextStorage();
            // Copy head into $this->bc storage to preserve already attached scopes
            /** @psalm-suppress PossiblyNullFunctionCall */
            $head = (static fn($storage) => $storage->heads[$storage])->bindTo(null, \OpenTelemetry\Context\FiberBoundContextStorage::class)($this->storage);
            $head->storage = $this->bc;
            /** @psalm-suppress PossiblyNullFunctionCall */
            (static fn($storage) => $storage->current = $storage->main = $head)->bindTo(null, \OpenTelemetry\Context\ContextStorage::class)($this->bc);
        }
        return $this->bc;
    }
    #[\Override]
    public function scope(): ?\OpenTelemetry\Context\ContextStorageScopeInterface
    {
        return $this->bc ? $this->bc->scope() : $this->storage->scope();
    }
    #[\Override]
    public function current(): \OpenTelemetry\Context\ContextInterface
    {
        return $this->bc ? $this->bc->current() : $this->storage->current();
    }
    #[\Override]
    public function attach(\OpenTelemetry\Context\ContextInterface $context): \OpenTelemetry\Context\ContextStorageScopeInterface
    {
        return $this->bc ? $this->bc->attach($context) : $this->storage->attach($context);
    }
}

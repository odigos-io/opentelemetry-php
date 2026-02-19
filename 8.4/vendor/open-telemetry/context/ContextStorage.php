<?php

declare (strict_types=1);
namespace OpenTelemetry\Context;

/**
 * @internal
 */
final class ContextStorage implements \OpenTelemetry\Context\ContextStorageInterface, \OpenTelemetry\Context\ContextStorageHeadAware, \OpenTelemetry\Context\ExecutionContextAwareInterface
{
    private \OpenTelemetry\Context\ContextStorageHead $current;
    private \OpenTelemetry\Context\ContextStorageHead $main;
    /** @var array<int|string, ContextStorageHead> */
    private array $forks = [];
    public function __construct()
    {
        $this->current = $this->main = new \OpenTelemetry\Context\ContextStorageHead($this);
    }
    #[\Override]
    public function fork(int|string $id): void
    {
        $this->forks[$id] = clone $this->current;
    }
    #[\Override]
    public function switch(int|string $id): void
    {
        $this->current = $this->forks[$id] ?? $this->main;
    }
    #[\Override]
    public function destroy(int|string $id): void
    {
        unset($this->forks[$id]);
    }
    #[\Override]
    public function head(): \OpenTelemetry\Context\ContextStorageHead
    {
        return $this->current;
    }
    #[\Override]
    public function scope(): ?\OpenTelemetry\Context\ContextStorageScopeInterface
    {
        return ($this->current->node->head ?? null) === $this->current ? $this->current->node : null;
    }
    #[\Override]
    public function current(): \OpenTelemetry\Context\ContextInterface
    {
        return $this->current->node->context ?? \OpenTelemetry\Context\Context::getRoot();
    }
    #[\Override]
    public function attach(\OpenTelemetry\Context\ContextInterface $context): \OpenTelemetry\Context\ContextStorageScopeInterface
    {
        return $this->current->node = new \OpenTelemetry\Context\ContextStorageNode($context, $this->current, $this->current->node);
    }
    private function __clone()
    {
    }
}

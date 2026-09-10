<?php

declare (strict_types=1);
namespace Odigos\League\Container\Event;

use Odigos\League\Container\Definition\DefinitionInterface;
final class OnDefineEvent extends ContainerEvent
{
    public function __construct(string $id, DefinitionInterface $definition, array $tags = [])
    {
        parent::__construct($id, $definition, $tags);
    }
    public function getDefinition(): DefinitionInterface
    {
        return $this->definition;
    }
    public function setDefinition(DefinitionInterface $definition): void
    {
        $this->definition = $definition;
    }
}

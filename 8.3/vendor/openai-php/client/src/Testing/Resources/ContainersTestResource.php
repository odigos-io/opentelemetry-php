<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\ContainerFileContract;
use Odigos\OpenAI\Contracts\Resources\ContainersContract;
use Odigos\OpenAI\Resources\Containers;
use Odigos\OpenAI\Responses\Containers\CreateContainer;
use Odigos\OpenAI\Responses\Containers\DeleteContainer;
use Odigos\OpenAI\Responses\Containers\ListContainers;
use Odigos\OpenAI\Responses\Containers\RetrieveContainer;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class ContainersTestResource implements ContainersContract
{
    use Testable;
    public function resource(): string
    {
        return Containers::class;
    }
    public function create(array $parameters): CreateContainer
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function retrieve(string $id): RetrieveContainer
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function list(array $parameters = []): ListContainers
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function delete(string $id): DeleteContainer
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function files(): ContainerFileContract
    {
        return new ContainerFileTestResource($this->fake);
    }
}

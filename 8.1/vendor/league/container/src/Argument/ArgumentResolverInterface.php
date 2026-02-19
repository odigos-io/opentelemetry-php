<?php

declare (strict_types=1);
namespace Odigos\League\Container\Argument;

use Odigos\League\Container\ContainerAwareInterface;
use ReflectionFunctionAbstract;
interface ArgumentResolverInterface extends ContainerAwareInterface
{
    public function resolveArguments(array $arguments): array;
    public function reflectArguments(ReflectionFunctionAbstract $method, array $args = []): array;
}

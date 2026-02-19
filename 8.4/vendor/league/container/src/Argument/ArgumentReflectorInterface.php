<?php

declare (strict_types=1);
namespace Odigos\League\Container\Argument;

use Odigos\League\Container\ContainerAwareInterface;
use ReflectionFunctionAbstract;
interface ArgumentReflectorInterface extends ContainerAwareInterface
{
    public function reflectArguments(ReflectionFunctionAbstract $method, array $args = []): array;
}

<?php

declare (strict_types=1);
namespace Odigos\League\Container\Attribute;

interface AttributeInterface
{
    public function resolve(): mixed;
}

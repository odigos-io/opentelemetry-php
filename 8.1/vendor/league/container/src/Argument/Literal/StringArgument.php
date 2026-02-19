<?php

declare (strict_types=1);
namespace Odigos\League\Container\Argument\Literal;

use Odigos\League\Container\Argument\LiteralArgument;
class StringArgument extends LiteralArgument
{
    public function __construct(string $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_STRING);
    }
}

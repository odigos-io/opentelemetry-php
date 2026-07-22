<?php

declare (strict_types=1);
namespace Odigos\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word): string;
}

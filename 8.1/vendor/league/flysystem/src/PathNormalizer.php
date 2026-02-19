<?php

declare (strict_types=1);
namespace Odigos\League\Flysystem;

interface PathNormalizer
{
    public function normalizePath(string $path): string;
}

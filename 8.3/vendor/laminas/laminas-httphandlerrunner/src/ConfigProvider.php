<?php

declare (strict_types=1);
namespace Odigos\Laminas\HttpHandlerRunner;

/** @final */
class ConfigProvider
{
    public function __invoke(): array
    {
        return ['dependencies' => $this->getDependencies()];
    }
    public function getDependencies(): array
    {
        return [];
    }
}

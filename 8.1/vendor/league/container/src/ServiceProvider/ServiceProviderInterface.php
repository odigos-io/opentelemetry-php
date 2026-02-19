<?php

declare (strict_types=1);
namespace Odigos\League\Container\ServiceProvider;

use Odigos\League\Container\ContainerAwareInterface;
interface ServiceProviderInterface extends ContainerAwareInterface
{
    public function getIdentifier(): string;
    public function provides(string $id): bool;
    public function register(): void;
    public function setIdentifier(string $id): ServiceProviderInterface;
}

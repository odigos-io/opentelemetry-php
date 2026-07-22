<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Odigos\Symfony\Component\HttpKernel\DependencyInjection;

use Odigos\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use Odigos\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Odigos\Symfony\Component\DependencyInjection\ContainerBuilder;
use Odigos\Symfony\Component\DependencyInjection\Reference;
/**
 * Register all services that have the "kernel.locale_aware" tag into the listener.
 *
 * @author Pierre Bobiet <pierrebobiet@gmail.com>
 */
class RegisterLocaleAwareServicesPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('locale_aware_listener')) {
            return;
        }
        $services = [];
        foreach ($container->findTaggedServiceIds('kernel.locale_aware') as $id => $tags) {
            $services[] = new Reference($id);
        }
        if (!$services) {
            $container->removeDefinition('locale_aware_listener');
            return;
        }
        $container->getDefinition('locale_aware_listener')->setArgument(0, new IteratorArgument($services));
    }
}

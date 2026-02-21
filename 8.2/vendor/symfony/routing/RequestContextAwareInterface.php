<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\Routing;

interface RequestContextAwareInterface
{
    /**
     * Sets the request context.
     */
    public function setContext(\Symfony\Component\Routing\RequestContext $context): void;
    /**
     * Gets the request context.
     */
    public function getContext(): \Symfony\Component\Routing\RequestContext;
}

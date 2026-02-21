<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\EventDispatcher;

/**
 * A read-only proxy for an event dispatcher.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class ImmutableEventDispatcher implements \Symfony\Component\EventDispatcher\EventDispatcherInterface
{
    public function __construct(private \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher)
    {
    }
    public function dispatch(object $event, ?string $eventName = null): object
    {
        return $this->dispatcher->dispatch($event, $eventName);
    }
    public function addListener(string $eventName, callable|array $listener, int $priority = 0): never
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }
    public function addSubscriber(\Symfony\Component\EventDispatcher\EventSubscriberInterface $subscriber): never
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }
    public function removeListener(string $eventName, callable|array $listener): never
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }
    public function removeSubscriber(\Symfony\Component\EventDispatcher\EventSubscriberInterface $subscriber): never
    {
        throw new \BadMethodCallException('Unmodifiable event dispatchers must not be modified.');
    }
    public function getListeners(?string $eventName = null): array
    {
        return $this->dispatcher->getListeners($eventName);
    }
    public function getListenerPriority(string $eventName, callable|array $listener): ?int
    {
        return $this->dispatcher->getListenerPriority($eventName, $listener);
    }
    public function hasListeners(?string $eventName = null): bool
    {
        return $this->dispatcher->hasListeners($eventName);
    }
}

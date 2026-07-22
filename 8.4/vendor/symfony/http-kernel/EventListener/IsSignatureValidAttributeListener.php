<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Odigos\Symfony\Component\HttpKernel\EventListener;

use Odigos\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Odigos\Symfony\Component\HttpFoundation\UriSigner;
use Odigos\Symfony\Component\HttpKernel\Attribute\IsSignatureValid;
use Odigos\Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Odigos\Symfony\Component\HttpKernel\KernelEvents;
/**
 * Handles the IsSignatureValid attribute.
 *
 * @author Santiago San Martin <sanmartindev@gmail.com>
 */
class IsSignatureValidAttributeListener implements EventSubscriberInterface
{
    public function __construct(private readonly UriSigner $uriSigner)
    {
    }
    public function onKernelControllerArguments(ControllerArgumentsEvent $event): void
    {
        if (!$attributes = $event->getAttributes(IsSignatureValid::class)) {
            return;
        }
        $request = $event->getRequest();
        foreach ($attributes as $attribute) {
            if ($attribute->methods && !\in_array($request->getMethod(), $attribute->methods, \true)) {
                continue;
            }
            $this->uriSigner->verify($request);
        }
    }
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER_ARGUMENTS => ['onKernelControllerArguments', 30]];
    }
}

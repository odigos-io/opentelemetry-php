<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Odigos\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use Odigos\Symfony\Component\HttpFoundation\Request;
use Odigos\Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Odigos\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Odigos\Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Odigos\Symfony\Component\Uid\AbstractUid;
final class UidValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        if ($argument->isVariadic() || !\is_string($value = $request->attributes->get($argument->getName())) || null === ($uidClass = $argument->getType()) || !is_subclass_of($uidClass, AbstractUid::class, \true)) {
            return [];
        }
        try {
            return [$uidClass::fromString($value)];
        } catch (\InvalidArgumentException $e) {
            throw new NotFoundHttpException(\sprintf('The uid for the "%s" parameter is invalid.', $argument->getName()), $e);
        }
    }
}

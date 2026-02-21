<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\HttpFoundation\Session\Storage;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;
// Help opcache.preload discover always-needed symbols
class_exists(\Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage::class);
/**
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class PhpBridgeSessionStorageFactory implements \Symfony\Component\HttpFoundation\Session\Storage\SessionStorageFactoryInterface
{
    public function __construct(private AbstractProxy|\SessionHandlerInterface|null $handler = null, private ?\Symfony\Component\HttpFoundation\Session\Storage\MetadataBag $metaBag = null, private bool $secure = \false)
    {
    }
    public function createStorage(?Request $request): \Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface
    {
        $storage = new \Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage($this->handler, $this->metaBag);
        if ($this->secure && $request?->isSecure()) {
            $storage->setOptions(['cookie_secure' => \true]);
        }
        return $storage;
    }
}

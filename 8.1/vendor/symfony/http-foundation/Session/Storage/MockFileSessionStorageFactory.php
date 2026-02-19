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
// Help opcache.preload discover always-needed symbols
class_exists(\Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage::class);
/**
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class MockFileSessionStorageFactory implements \Symfony\Component\HttpFoundation\Session\Storage\SessionStorageFactoryInterface
{
    private ?string $savePath;
    private string $name;
    private ?\Symfony\Component\HttpFoundation\Session\Storage\MetadataBag $metaBag;
    /**
     * @see MockFileSessionStorage constructor.
     */
    public function __construct(?string $savePath = null, string $name = 'MOCKSESSID', ?\Symfony\Component\HttpFoundation\Session\Storage\MetadataBag $metaBag = null)
    {
        $this->savePath = $savePath;
        $this->name = $name;
        $this->metaBag = $metaBag;
    }
    public function createStorage(?Request $request): \Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface
    {
        return new \Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage($this->savePath, $this->name, $this->metaBag);
    }
}

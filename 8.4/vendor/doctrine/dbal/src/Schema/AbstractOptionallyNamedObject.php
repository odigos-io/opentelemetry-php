<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Schema\Exception\InvalidState;
/**
 * An abstract {@see OptionallyNamedObject}.
 *
 * @template N of Name
 * @extends AbstractAsset<N>
 * @implements OptionallyNamedObject<N>
 */
abstract class AbstractOptionallyNamedObject extends \Doctrine\DBAL\Schema\AbstractAsset implements \Doctrine\DBAL\Schema\OptionallyNamedObject
{
    /**
     * The name of the database object.
     *
     * Until the validity of the name is enforced, this property isn't guaranteed to be always initialized. The property
     * can be accessed only if {@see $isNameInitialized} is set to true.
     *
     * @var ?N
     */
    protected ?\Doctrine\DBAL\Schema\Name $name;
    public function __construct(?string $name)
    {
        parent::__construct($name ?? '');
    }
    public function getObjectName(): ?\Doctrine\DBAL\Schema\Name
    {
        if (!$this->isNameInitialized) {
            throw InvalidState::objectNameNotInitialized();
        }
        return $this->name;
    }
    protected function setName(?\Doctrine\DBAL\Schema\Name $name): void
    {
        $this->name = $name;
    }
}

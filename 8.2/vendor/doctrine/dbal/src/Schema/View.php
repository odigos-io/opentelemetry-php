<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Schema\Name\OptionallyQualifiedName;
use Doctrine\DBAL\Schema\Name\Parser\OptionallyQualifiedNameParser;
use Doctrine\DBAL\Schema\Name\Parsers;
/**
 * Representation of a Database View.
 *
 * @final
 * @extends AbstractNamedObject<OptionallyQualifiedName>
 */
class View extends \Doctrine\DBAL\Schema\AbstractNamedObject
{
    /** @internal Use {@link View::editor()} to instantiate an editor and {@link ViewEditor::create()} to create a view. */
    public function __construct(string $name, private readonly string $sql)
    {
        parent::__construct($name);
    }
    protected function getNameParser(): OptionallyQualifiedNameParser
    {
        return Parsers::getOptionallyQualifiedNameParser();
    }
    public function getSql(): string
    {
        return $this->sql;
    }
    /**
     * Instantiates a new view editor.
     */
    public static function editor(): \Doctrine\DBAL\Schema\ViewEditor
    {
        return new \Doctrine\DBAL\Schema\ViewEditor();
    }
    /**
     * Instantiates a new view editor and initializes it with the view's properties.
     */
    public function edit(): \Doctrine\DBAL\Schema\ViewEditor
    {
        return self::editor()->setName($this->getObjectName())->setSQL($this->sql);
    }
}

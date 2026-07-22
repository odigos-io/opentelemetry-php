<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Introspection\MetadataProcessor;

use Odigos\Doctrine\DBAL\Schema\Index;
use Odigos\Doctrine\DBAL\Schema\Index\IndexedColumn;
use Odigos\Doctrine\DBAL\Schema\IndexEditor;
use Odigos\Doctrine\DBAL\Schema\Metadata\IndexColumnMetadataRow;
use Odigos\Doctrine\DBAL\Schema\Name\UnqualifiedName;
/**
 * Combines multiple {@see IndexColumnMetadataRow}s into an {@see Index}.
 *
 * @internal Should be used only by {@link IntrospectingSchemaProvider}.
 */
final readonly class IndexColumnMetadataProcessor
{
    public function initializeEditor(IndexColumnMetadataRow $row): IndexEditor
    {
        return Index::editor()->setName(UnqualifiedName::quoted($row->getIndexName()))->setType($row->getType())->setIsClustered($row->isClustered())->setPredicate($row->getPredicate());
    }
    public function applyRow(IndexEditor $editor, IndexColumnMetadataRow $row): void
    {
        $editor->addColumn(new IndexedColumn(UnqualifiedName::quoted($row->getColumnName()), $row->getColumnLength()));
    }
}

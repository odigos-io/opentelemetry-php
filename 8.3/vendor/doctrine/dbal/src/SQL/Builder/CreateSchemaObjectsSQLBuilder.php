<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\SQL\Builder;

use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
use Odigos\Doctrine\DBAL\Schema\Schema;
use Odigos\Doctrine\DBAL\Schema\Sequence;
use Odigos\Doctrine\DBAL\Schema\Table;
use function array_merge;
final class CreateSchemaObjectsSQLBuilder
{
    public function __construct(private readonly AbstractPlatform $platform)
    {
    }
    /** @return list<string> */
    public function buildSQL(Schema $schema): array
    {
        return array_merge($this->buildNamespaceStatements($schema->getNamespaces()), $this->buildSequenceStatements($schema->getSequences()), $this->buildTableStatements($schema->getTables()));
    }
    /**
     * @param string[] $namespaces
     *
     * @return list<string>
     */
    private function buildNamespaceStatements(array $namespaces): array
    {
        $statements = [];
        if ($this->platform->supportsSchemas()) {
            foreach ($namespaces as $namespace) {
                $statements[] = $this->platform->getCreateSchemaSQL($namespace);
            }
        }
        return $statements;
    }
    /**
     * @param Table[] $tables
     *
     * @return list<string>
     */
    private function buildTableStatements(array $tables): array
    {
        return $this->platform->getCreateTablesSQL($tables);
    }
    /**
     * @param Sequence[] $sequences
     *
     * @return list<string>
     */
    private function buildSequenceStatements(array $sequences): array
    {
        $statements = [];
        foreach ($sequences as $sequence) {
            $statements[] = $this->platform->getCreateSequenceSQL($sequence);
        }
        return $statements;
    }
}

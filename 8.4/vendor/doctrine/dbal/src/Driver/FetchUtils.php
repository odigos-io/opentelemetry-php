<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Driver;

/** @internal */
final class FetchUtils
{
    /** @throws Exception */
    public static function fetchOne(\Doctrine\DBAL\Driver\Result $result): mixed
    {
        $row = $result->fetchNumeric();
        if ($row === \false) {
            return \false;
        }
        return $row[0];
    }
    /**
     * @return list<list<mixed>>
     *
     * @throws Exception
     */
    public static function fetchAllNumeric(\Doctrine\DBAL\Driver\Result $result): array
    {
        $rows = [];
        while (($row = $result->fetchNumeric()) !== \false) {
            $rows[] = $row;
        }
        return $rows;
    }
    /**
     * @return list<array<string,mixed>>
     *
     * @throws Exception
     */
    public static function fetchAllAssociative(\Doctrine\DBAL\Driver\Result $result): array
    {
        $rows = [];
        while (($row = $result->fetchAssociative()) !== \false) {
            $rows[] = $row;
        }
        return $rows;
    }
    /**
     * @return list<mixed>
     *
     * @throws Exception
     */
    public static function fetchFirstColumn(\Doctrine\DBAL\Driver\Result $result): array
    {
        $rows = [];
        while (($row = $result->fetchOne()) !== \false) {
            $rows[] = $row;
        }
        return $rows;
    }
}

<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Query;

use Odigos\Doctrine\DBAL\Query\ForUpdate\ConflictResolutionMode;
/** @internal */
final readonly class ForUpdate
{
    public function __construct(private ConflictResolutionMode $conflictResolutionMode)
    {
    }
    public function getConflictResolutionMode(): ConflictResolutionMode
    {
        return $this->conflictResolutionMode;
    }
}

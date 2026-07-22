<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Doctrine;

use Odigos\Doctrine\DBAL\Driver\Statement;
use OpenTelemetry\API\Trace\SpanContextInterface;
use WeakMap;
/**
 * @internal
 */
class DoctrineTracker
{
    public function __construct(private WeakMap $statementToSpanContextMap = new WeakMap())
    {
    }
    public function trackStatement(object $statement, SpanContextInterface $context): void
    {
        $this->statementToSpanContextMap[$statement] = $context;
    }
    public function getSpanContextForStatement(object $statement): ?SpanContextInterface
    {
        return $this->statementToSpanContextMap[$statement] ?? null;
    }
}

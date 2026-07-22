<?php

declare (strict_types=1);
namespace Odigos\MongoDB\Builder;

use ArrayIterator;
use IteratorAggregate;
use Odigos\MongoDB\Builder\Type\StageInterface;
use Odigos\MongoDB\Exception\InvalidArgumentException;
use stdClass;
use function array_is_list;
use function array_merge;
use function is_array;
/**
 * An aggregation pipeline consists of one or more stages that process documents.
 *
 * @see https://www.mongodb.com/docs/manual/core/aggregation-pipeline/
 *
 * @psalm-immutable
 * @psalm-type stage = StageInterface|array<string,mixed>|stdClass
 * @implements IteratorAggregate<stage>
 */
final class Pipeline implements IteratorAggregate
{
    private readonly array $stages;
    /**
     * @psalm-param stage|list<stage> ...$stagesOrPipelines
     *
     * @no-named-arguments
     */
    public function __construct(StageInterface|Pipeline|array|stdClass ...$stagesOrPipelines)
    {
        if (!array_is_list($stagesOrPipelines)) {
            throw new InvalidArgumentException('Named arguments are not supported for pipelines');
        }
        $stages = [];
        foreach ($stagesOrPipelines as $stageOrPipeline) {
            if (is_array($stageOrPipeline) && array_is_list($stageOrPipeline)) {
                $stages = array_merge($stages, $stageOrPipeline);
            } elseif ($stageOrPipeline instanceof Pipeline) {
                $stages = array_merge($stages, $stageOrPipeline->stages);
            } else {
                $stages[] = $stageOrPipeline;
            }
        }
        $this->stages = $stages;
    }
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->stages);
    }
}

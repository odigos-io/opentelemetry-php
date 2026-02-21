<?php

declare (strict_types=1);
namespace OpenAI\Responses\Responses\Tool;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-import-type RankingOptionType from FileSearchRankingOption
 * @phpstan-import-type ComparisonFilterType from FileSearchComparisonFilter
 * @phpstan-import-type CompoundFilterType from FileSearchCompoundFilter
 *
 * @phpstan-type FileSearchToolType array{type: 'file_search', vector_store_ids: array<int, string>, filters: ComparisonFilterType|CompoundFilterType|null, max_num_results: int, ranking_options: RankingOptionType}
 *
 * @implements ResponseContract<FileSearchToolType>
 */
final class FileSearchTool implements ResponseContract
{
    /**
     * @use ArrayAccessible<FileSearchToolType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  array<int, string>  $vectorStoreIds
     * @param  'file_search'  $type
     */
    private function __construct(public readonly string $type, public readonly array $vectorStoreIds, public readonly \OpenAI\Responses\Responses\Tool\FileSearchComparisonFilter|\OpenAI\Responses\Responses\Tool\FileSearchCompoundFilter|null $filters, public readonly int $maxNumResults, public readonly \OpenAI\Responses\Responses\Tool\FileSearchRankingOption $rankingOptions)
    {
    }
    /**
     * @param  FileSearchToolType  $attributes
     */
    public static function from(array $attributes): self
    {
        $filters = null;
        if (isset($attributes['filters']['type'])) {
            $filters = match ($attributes['filters']['type']) {
                'eq', 'ne', 'gt', 'gte', 'lt', 'lte' => \OpenAI\Responses\Responses\Tool\FileSearchComparisonFilter::from($attributes['filters']),
                'and', 'or' => \OpenAI\Responses\Responses\Tool\FileSearchCompoundFilter::from($attributes['filters']),
            };
        }
        return new self(type: $attributes['type'], vectorStoreIds: $attributes['vector_store_ids'], filters: $filters, maxNumResults: $attributes['max_num_results'], rankingOptions: \OpenAI\Responses\Responses\Tool\FileSearchRankingOption::from($attributes['ranking_options']));
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type, 'vector_store_ids' => $this->vectorStoreIds, 'filters' => $this->filters?->toArray(), 'max_num_results' => $this->maxNumResults, 'ranking_options' => $this->rankingOptions->toArray()];
    }
}

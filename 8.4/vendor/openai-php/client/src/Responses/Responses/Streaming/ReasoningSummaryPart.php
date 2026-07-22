<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Streaming;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Responses\Responses\Output\OutputReasoningSummary;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-import-type ReasoningSummaryType from OutputReasoningSummary
 *
 * @phpstan-type ReasoningSummaryPartType array{item_id: string, output_index: int, part: ReasoningSummaryType, summary_index: int}
 *
 * @implements ResponseContract<ReasoningSummaryPartType>
 */
final class ReasoningSummaryPart implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ReasoningSummaryPartType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly string $itemId, public readonly int $outputIndex, public readonly OutputReasoningSummary $part, public readonly int $summaryIndex, private readonly MetaInformation $meta)
    {
    }
    /**
     * @param  ReasoningSummaryPartType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(itemId: $attributes['item_id'], outputIndex: $attributes['output_index'], part: OutputReasoningSummary::from($attributes['part']), summaryIndex: $attributes['summary_index'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['item_id' => $this->itemId, 'output_index' => $this->outputIndex, 'part' => $this->part->toArray(), 'summary_index' => $this->summaryIndex];
    }
}

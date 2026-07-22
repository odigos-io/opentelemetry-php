<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Streaming;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ReasoningSummaryTextDoneType array{item_id: string, output_index: int, summary_index: int, text: string}
 *
 * @implements ResponseContract<ReasoningSummaryTextDoneType>
 */
final class ReasoningSummaryTextDone implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ReasoningSummaryTextDoneType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly string $itemId, public readonly int $outputIndex, public readonly int $summaryIndex, public readonly string $text, private readonly MetaInformation $meta)
    {
    }
    /**
     * @param  ReasoningSummaryTextDoneType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(itemId: $attributes['item_id'], outputIndex: $attributes['output_index'], summaryIndex: $attributes['summary_index'], text: $attributes['text'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['item_id' => $this->itemId, 'output_index' => $this->outputIndex, 'summary_index' => $this->summaryIndex, 'text' => $this->text];
    }
}

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
 * @phpstan-type RefusalDeltaType array{content_index: int, delta: string, item_id: string, output_index: int}
 *
 * @implements ResponseContract<RefusalDeltaType>
 */
final class RefusalDelta implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<RefusalDeltaType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly int $contentIndex, public readonly string $delta, public readonly string $itemId, public readonly int $outputIndex, private readonly MetaInformation $meta)
    {
    }
    /**
     * @param  RefusalDeltaType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(contentIndex: $attributes['content_index'], delta: $attributes['delta'], itemId: $attributes['item_id'], outputIndex: $attributes['output_index'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['content_index' => $this->contentIndex, 'delta' => $this->delta, 'item_id' => $this->itemId, 'output_index' => $this->outputIndex];
    }
}

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
 * @phpstan-type FunctionCallArgumentsDeltaType array{delta: string, item_id: string, output_index: int}
 *
 * @implements ResponseContract<FunctionCallArgumentsDeltaType>
 */
final class FunctionCallArgumentsDelta implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<FunctionCallArgumentsDeltaType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly string $delta, public readonly string $itemId, public readonly int $outputIndex, private readonly MetaInformation $meta)
    {
    }
    /**
     * @param  FunctionCallArgumentsDeltaType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(delta: $attributes['delta'], itemId: $attributes['item_id'], outputIndex: $attributes['output_index'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['delta' => $this->delta, 'item_id' => $this->itemId, 'output_index' => $this->outputIndex];
    }
}

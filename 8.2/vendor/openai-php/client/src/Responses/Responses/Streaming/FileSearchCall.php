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
 * @phpstan-type FileSearchCallType array{item_id: string, output_index: int}
 *
 * @implements ResponseContract<FileSearchCallType>
 */
final class FileSearchCall implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<FileSearchCallType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly string $itemId, public readonly int $outputIndex, private readonly MetaInformation $meta)
    {
    }
    /**
     * @param  FileSearchCallType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(itemId: $attributes['item_id'], outputIndex: $attributes['output_index'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['item_id' => $this->itemId, 'output_index' => $this->outputIndex];
    }
}

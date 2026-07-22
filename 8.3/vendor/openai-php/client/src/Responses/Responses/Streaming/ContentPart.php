<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Streaming;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Responses\Responses\Output\OutputMessageContentOutputText;
use Odigos\OpenAI\Responses\Responses\Output\OutputMessageContentRefusal;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-import-type OutputTextType from OutputMessageContentOutputText
 * @phpstan-import-type ContentRefusalType from OutputMessageContentRefusal
 *
 * @phpstan-type ContentPartType array{content_index: int, item_id: string, output_index: int, part: OutputTextType|ContentRefusalType}
 *
 * @implements ResponseContract<ContentPartType>
 */
final class ContentPart implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ContentPartType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly int $contentIndex, public readonly string $itemId, public readonly int $outputIndex, public readonly OutputMessageContentOutputText|OutputMessageContentRefusal $part, private readonly MetaInformation $meta)
    {
    }
    /**
     * @param  ContentPartType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $part = match ($attributes['part']['type']) {
            'output_text' => OutputMessageContentOutputText::from($attributes['part']),
            'refusal' => OutputMessageContentRefusal::from($attributes['part']),
        };
        return new self(contentIndex: $attributes['content_index'], itemId: $attributes['item_id'], outputIndex: $attributes['output_index'], part: $part, meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['content_index' => $this->contentIndex, 'item_id' => $this->itemId, 'output_index' => $this->outputIndex, 'part' => $this->part->toArray()];
    }
}

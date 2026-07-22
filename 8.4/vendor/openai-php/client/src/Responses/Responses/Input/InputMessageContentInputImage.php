<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Input;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ContentInputImageType array{type: 'input_image', detail: string, file_id: string|null, image_url: string|null}
 *
 * @implements ResponseContract<ContentInputImageType>
 */
final class InputMessageContentInputImage implements ResponseContract
{
    /**
     * @use ArrayAccessible<ContentInputImageType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'input_image'  $type
     */
    private function __construct(public readonly string $type, public readonly string $detail, public readonly ?string $fileId, public readonly ?string $imageUrl)
    {
    }
    /**
     * @param  ContentInputImageType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(type: $attributes['type'], detail: $attributes['detail'], fileId: $attributes['file_id'], imageUrl: $attributes['image_url']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type, 'detail' => $this->detail, 'file_id' => $this->fileId, 'image_url' => $this->imageUrl];
    }
}

<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Input;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ComputerToolCallOutputScreenshotType array{type: 'computer_screenshot', file_id: string, image_url: string}
 *
 * @implements ResponseContract<ComputerToolCallOutputScreenshotType>
 */
final class ComputerToolCallOutputScreenshot implements ResponseContract
{
    /**
     * @use ArrayAccessible<ComputerToolCallOutputScreenshotType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'computer_screenshot'  $type
     */
    private function __construct(public readonly string $type, public readonly string $fileId, public readonly string $imageUrl)
    {
    }
    /**
     * @param  ComputerToolCallOutputScreenshotType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(type: $attributes['type'], fileId: $attributes['file_id'], imageUrl: $attributes['image_url']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type, 'file_id' => $this->fileId, 'image_url' => $this->imageUrl];
    }
}

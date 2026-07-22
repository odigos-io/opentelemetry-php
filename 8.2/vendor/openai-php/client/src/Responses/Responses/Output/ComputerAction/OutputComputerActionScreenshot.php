<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Output\ComputerAction;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ScreenshotType array{type: 'screenshot'}
 *
 * @implements ResponseContract<ScreenshotType>
 */
final class OutputComputerActionScreenshot implements ResponseContract
{
    /**
     * @use ArrayAccessible<ScreenshotType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'screenshot'  $type
     */
    private function __construct(public readonly string $type)
    {
    }
    /**
     * @param  ScreenshotType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(type: $attributes['type']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type];
    }
}

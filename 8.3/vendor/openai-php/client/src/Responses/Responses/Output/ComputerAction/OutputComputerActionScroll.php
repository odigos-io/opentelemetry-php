<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Output\ComputerAction;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ScrollType array{scroll_x: int, scroll_y: int, type: 'scroll', x: int, y: int}
 *
 * @implements ResponseContract<ScrollType>
 */
final class OutputComputerActionScroll implements ResponseContract
{
    /**
     * @use ArrayAccessible<ScrollType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'scroll'  $type
     */
    private function __construct(public readonly int $scrollX, public readonly int $scrollY, public readonly string $type, public readonly int $x, public readonly int $y)
    {
    }
    /**
     * @param  ScrollType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(scrollX: $attributes['scroll_x'], scrollY: $attributes['scroll_y'], type: $attributes['type'], x: $attributes['x'], y: $attributes['y']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['scroll_x' => $this->scrollX, 'scroll_y' => $this->scrollY, 'type' => $this->type, 'x' => $this->x, 'y' => $this->y];
    }
}

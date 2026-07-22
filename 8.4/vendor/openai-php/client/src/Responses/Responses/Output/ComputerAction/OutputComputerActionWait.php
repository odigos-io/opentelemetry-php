<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Output\ComputerAction;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type WaitType array{type: 'wait'}
 *
 * @implements ResponseContract<WaitType>
 */
final class OutputComputerActionWait implements ResponseContract
{
    /**
     * @use ArrayAccessible<WaitType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'wait'  $type
     */
    private function __construct(public readonly string $type)
    {
    }
    /**
     * @param  WaitType  $attributes
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

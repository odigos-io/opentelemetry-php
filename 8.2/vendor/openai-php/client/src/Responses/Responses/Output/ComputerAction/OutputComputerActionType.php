<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Output\ComputerAction;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type TypeType array{text: string, type: 'type'}
 *
 * @implements ResponseContract<TypeType>
 */
final class OutputComputerActionType implements ResponseContract
{
    /**
     * @use ArrayAccessible<TypeType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'type'  $type
     */
    private function __construct(public readonly string $text, public readonly string $type)
    {
    }
    /**
     * @param  TypeType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(text: $attributes['text'], type: $attributes['type']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['text' => $this->text, 'type' => $this->type];
    }
}

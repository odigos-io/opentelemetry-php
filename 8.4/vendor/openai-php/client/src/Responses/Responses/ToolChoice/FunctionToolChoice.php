<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\ToolChoice;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type FunctionToolChoiceType array{name: string, type: 'function'}
 *
 * @implements ResponseContract<FunctionToolChoiceType>
 */
final class FunctionToolChoice implements ResponseContract
{
    /**
     * @use ArrayAccessible<FunctionToolChoiceType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'function'  $type
     */
    private function __construct(public readonly string $name, public readonly string $type)
    {
    }
    /**
     * @param  FunctionToolChoiceType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(name: $attributes['name'], type: $attributes['type']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['name' => $this->name, 'type' => $this->type];
    }
}

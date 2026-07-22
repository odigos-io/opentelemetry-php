<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Threads\Runs;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{type: string}>
 */
final class ThreadRunResponseFileSearch implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{type: string}>
     */
    use ArrayAccessible;
    use Fakeable;
    private function __construct(public string $type)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{type: 'file_search'}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self($attributes['type']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type];
    }
}

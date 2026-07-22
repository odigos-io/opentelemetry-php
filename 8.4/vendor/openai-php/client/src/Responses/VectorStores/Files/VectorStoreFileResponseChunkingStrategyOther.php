<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\VectorStores\Files;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{type: 'other'}>
 */
final class VectorStoreFileResponseChunkingStrategyOther implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{type: 'other'}>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'other'  $type
     */
    private function __construct(public readonly string $type)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{type: 'other'}  $attributes
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

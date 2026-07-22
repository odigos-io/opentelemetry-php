<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\VectorStores\Search;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{type: string, text: string}>
 */
final class VectorStoreSearchResponseContent implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{type: string, text: string}>
     */
    use ArrayAccessible;
    use Fakeable;
    private function __construct(public readonly string $type, public readonly string $text)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{type: string, text: string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self($attributes['type'], $attributes['text']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type, 'text' => $this->text];
    }
}

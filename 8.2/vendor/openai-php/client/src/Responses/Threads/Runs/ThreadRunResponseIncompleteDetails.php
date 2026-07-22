<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Threads\Runs;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{reason: string}>
 */
final class ThreadRunResponseIncompleteDetails implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{reason: string}>
     */
    use ArrayAccessible;
    use Fakeable;
    private function __construct(public string $reason)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{reason: string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self($attributes['reason']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['reason' => $this->reason];
    }
}

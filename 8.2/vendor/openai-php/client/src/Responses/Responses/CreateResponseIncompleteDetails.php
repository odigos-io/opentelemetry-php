<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type IncompleteDetailsType array{reason: string}
 *
 * @implements ResponseContract<IncompleteDetailsType>
 */
final class CreateResponseIncompleteDetails implements ResponseContract
{
    /**
     * @use ArrayAccessible<IncompleteDetailsType>
     */
    use ArrayAccessible;
    use Fakeable;
    private function __construct(public readonly string $reason)
    {
    }
    /**
     * @param  IncompleteDetailsType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(reason: $attributes['reason']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['reason' => $this->reason];
    }
}

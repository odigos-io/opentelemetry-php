<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Realtime\Session;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ClientSecretType array{expires_at: int, value: string}
 *
 * @implements ResponseContract<ClientSecretType>
 */
final class ClientSecret implements ResponseContract
{
    /**
     * @use ArrayAccessible<ClientSecretType>
     */
    use ArrayAccessible;
    use Fakeable;
    private function __construct(public readonly int $expiresAt, public readonly string $value)
    {
    }
    /**
     * @param  ClientSecretType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(expiresAt: $attributes['expires_at'], value: $attributes['value']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['expires_at' => $this->expiresAt, 'value' => $this->value];
    }
}

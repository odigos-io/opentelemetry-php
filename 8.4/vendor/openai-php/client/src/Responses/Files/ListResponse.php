<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Files;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: ?int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>, first_id: ?string, last_id: ?string, has_more: ?bool}>
 */
final class ListResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: ?int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>, first_id: ?string, last_id: ?string, has_more: bool}>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    /**
     * @param  array<int, RetrieveResponse>  $data
     */
    private function __construct(public readonly string $object, public readonly array $data, public readonly ?string $firstId, public readonly ?string $lastId, public readonly bool $hasMore, private readonly MetaInformation $meta)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: ?int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>, first_id: ?string, last_id: ?string, has_more: ?bool}  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $data = array_map(fn(array $result): RetrieveResponse => RetrieveResponse::from($result, $meta), $attributes['data']);
        return new self(object: $attributes['object'], data: $data, firstId: $attributes['first_id'] ?? null, lastId: $attributes['last_id'] ?? null, hasMore: $attributes['has_more'] ?? \false, meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['object' => $this->object, 'data' => array_map(static fn(RetrieveResponse $response): array => $response->toArray(), $this->data), 'first_id' => $this->firstId, 'last_id' => $this->lastId, 'has_more' => $this->hasMore];
    }
}

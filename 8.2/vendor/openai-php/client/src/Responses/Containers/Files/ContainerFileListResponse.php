<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Containers\Files;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-import-type ContainerFileType from ContainerFileResponse
 *
 * @phpstan-type ContainerFileListType array{object: 'list', data: array<int, ContainerFileType>, first_id: ?string, last_id: ?string, has_more: bool}
 *
 * @implements ResponseContract<ContainerFileListType>
 */
final class ContainerFileListResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ContainerFileListType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    /**
     * @param  'list'  $object
     * @param  array<int, ContainerFileResponse>  $data
     */
    private function __construct(public readonly string $object, public readonly array $data, public readonly ?string $firstId, public readonly ?string $lastId, public readonly bool $hasMore, private readonly MetaInformation $meta)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  ContainerFileListType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $data = array_map(fn(array $result): ContainerFileResponse => ContainerFileResponse::from($result, $meta), $attributes['data']);
        return new self(object: $attributes['object'], data: $data, firstId: $attributes['first_id'] ?? null, lastId: $attributes['last_id'] ?? null, hasMore: $attributes['has_more'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['object' => $this->object, 'data' => array_map(static fn(ContainerFileResponse $response): array => $response->toArray(), $this->data), 'first_id' => $this->firstId, 'last_id' => $this->lastId, 'has_more' => $this->hasMore];
    }
}

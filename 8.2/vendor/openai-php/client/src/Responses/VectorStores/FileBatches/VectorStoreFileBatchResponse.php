<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\VectorStores\FileBatches;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Responses\VectorStores\VectorStoreResponseFileCounts;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{id: string, object: string, created_at: int, vector_store_id: string, status: string, file_counts: array{in_progress: int, completed: int, failed: int, cancelled: int, total: int}}>
 */
final class VectorStoreFileBatchResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<array{id: string, object: string, created_at: int, vector_store_id: string, status: string, file_counts: array{in_progress: int, completed: int, failed: int, cancelled: int, total: int}}>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly string $id, public readonly string $object, public readonly int $createdAt, public readonly string $vectorStoreId, public readonly string $status, public readonly VectorStoreResponseFileCounts $fileCounts, private readonly MetaInformation $meta)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, object: string, created_at: int, vector_store_id: string, status: string, file_counts: array{in_progress: int, completed: int, failed: int, cancelled: int, total: int}}  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self($attributes['id'], $attributes['object'], $attributes['created_at'], $attributes['vector_store_id'], $attributes['status'], VectorStoreResponseFileCounts::from($attributes['file_counts']), $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['id' => $this->id, 'object' => $this->object, 'created_at' => $this->createdAt, 'vector_store_id' => $this->vectorStoreId, 'status' => $this->status, 'file_counts' => $this->fileCounts->toArray()];
    }
}

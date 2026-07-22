<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\VectorStoresFileBatchesContract;
use Odigos\OpenAI\Resources\VectorStoresFileBatches;
use Odigos\OpenAI\Responses\VectorStores\FileBatches\VectorStoreFileBatchResponse;
use Odigos\OpenAI\Responses\VectorStores\Files\VectorStoreFileListResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class VectorStoresFileBatchesTestResource implements VectorStoresFileBatchesContract
{
    use Testable;
    public function resource(): string
    {
        return VectorStoresFileBatches::class;
    }
    public function retrieve(string $vectorStoreId, string $fileBatchId): VectorStoreFileBatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function cancel(string $vectorStoreId, string $fileBatchId): VectorStoreFileBatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function create(string $vectorStoreId, array $parameters): VectorStoreFileBatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function listFiles(string $vectorStoreId, string $fileBatchId, array $parameters = []): VectorStoreFileListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

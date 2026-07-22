<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\VectorStoresContract;
use Odigos\OpenAI\Contracts\Resources\VectorStoresFileBatchesContract;
use Odigos\OpenAI\Contracts\Resources\VectorStoresFilesContract;
use Odigos\OpenAI\Resources\VectorStores;
use Odigos\OpenAI\Responses\VectorStores\Search\VectorStoreSearchResponse;
use Odigos\OpenAI\Responses\VectorStores\VectorStoreDeleteResponse;
use Odigos\OpenAI\Responses\VectorStores\VectorStoreListResponse;
use Odigos\OpenAI\Responses\VectorStores\VectorStoreResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class VectorStoresTestResource implements VectorStoresContract
{
    use Testable;
    public function resource(): string
    {
        return VectorStores::class;
    }
    public function modify(string $vectorStoreId, array $parameters): VectorStoreResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function retrieve(string $vectorStoreId): VectorStoreResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function delete(string $vectorStoreId): VectorStoreDeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function create(array $parameters): VectorStoreResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function list(array $parameters = []): VectorStoreListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    /**
     * @param  array<string, mixed>  $parameters
     */
    public function search(string $vectorStoreId, array $parameters = []): VectorStoreSearchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function files(): VectorStoresFilesContract
    {
        return new VectorStoresFilesTestResource($this->fake);
    }
    public function batches(): VectorStoresFileBatchesContract
    {
        return new VectorStoresFileBatchesTestResource($this->fake);
    }
}

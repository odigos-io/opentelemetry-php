<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\BatchesContract;
use Odigos\OpenAI\Resources\Batches;
use Odigos\OpenAI\Responses\Batches\BatchListResponse;
use Odigos\OpenAI\Responses\Batches\BatchResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class BatchesTestResource implements BatchesContract
{
    use Testable;
    public function resource(): string
    {
        return Batches::class;
    }
    public function create(array $parameters): BatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function retrieve(string $id): BatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function cancel(string $id): BatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function list(array $parameters = []): BatchListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

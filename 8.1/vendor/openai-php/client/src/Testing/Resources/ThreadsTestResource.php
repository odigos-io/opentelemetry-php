<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\ThreadsContract;
use OpenAI\Resources\Threads;
use OpenAI\Responses\StreamResponse;
use OpenAI\Responses\Threads\Runs\ThreadRunResponse;
use OpenAI\Responses\Threads\ThreadDeleteResponse;
use OpenAI\Responses\Threads\ThreadResponse;
use OpenAI\Testing\Resources\Concerns\Testable;
final class ThreadsTestResource implements ThreadsContract
{
    use Testable;
    public function resource(): string
    {
        return Threads::class;
    }
    public function create(array $parameters): ThreadResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function createAndRun(array $parameters): ThreadRunResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function createAndRunStreamed(array $parameters): StreamResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function retrieve(string $id): ThreadResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function modify(string $id, array $parameters): ThreadResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function delete(string $id): ThreadDeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function messages(): \OpenAI\Testing\Resources\ThreadsMessagesTestResource
    {
        return new \OpenAI\Testing\Resources\ThreadsMessagesTestResource($this->fake);
    }
    public function runs(): \OpenAI\Testing\Resources\ThreadsRunsTestResource
    {
        return new \OpenAI\Testing\Resources\ThreadsRunsTestResource($this->fake);
    }
}

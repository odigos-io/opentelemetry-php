<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\CompletionsContract;
use Odigos\OpenAI\Resources\Completions;
use Odigos\OpenAI\Responses\Completions\CreateResponse;
use Odigos\OpenAI\Responses\StreamResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class CompletionsTestResource implements CompletionsContract
{
    use Testable;
    protected function resource(): string
    {
        return Completions::class;
    }
    public function create(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function createStreamed(array $parameters): StreamResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

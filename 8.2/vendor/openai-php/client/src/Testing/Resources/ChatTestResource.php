<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\ChatContract;
use Odigos\OpenAI\Resources\Chat;
use Odigos\OpenAI\Responses\Chat\CreateResponse;
use Odigos\OpenAI\Responses\StreamResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class ChatTestResource implements ChatContract
{
    use Testable;
    protected function resource(): string
    {
        return Chat::class;
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

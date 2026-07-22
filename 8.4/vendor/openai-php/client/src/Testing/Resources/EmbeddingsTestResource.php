<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\EmbeddingsContract;
use Odigos\OpenAI\Resources\Embeddings;
use Odigos\OpenAI\Responses\Embeddings\CreateResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class EmbeddingsTestResource implements EmbeddingsContract
{
    use Testable;
    protected function resource(): string
    {
        return Embeddings::class;
    }
    public function create(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

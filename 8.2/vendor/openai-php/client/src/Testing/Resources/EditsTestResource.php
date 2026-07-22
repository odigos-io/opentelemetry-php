<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\EditsContract;
use Odigos\OpenAI\Resources\Edits;
use Odigos\OpenAI\Responses\Edits\CreateResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class EditsTestResource implements EditsContract
{
    use Testable;
    protected function resource(): string
    {
        return Edits::class;
    }
    public function create(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

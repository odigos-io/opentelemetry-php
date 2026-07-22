<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\ModerationsContract;
use Odigos\OpenAI\Resources\Moderations;
use Odigos\OpenAI\Responses\Moderations\CreateResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class ModerationsTestResource implements ModerationsContract
{
    use Testable;
    protected function resource(): string
    {
        return Moderations::class;
    }
    public function create(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

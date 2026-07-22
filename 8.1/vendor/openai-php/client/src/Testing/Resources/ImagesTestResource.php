<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\ImagesContract;
use Odigos\OpenAI\Resources\Images;
use Odigos\OpenAI\Responses\Images\CreateResponse;
use Odigos\OpenAI\Responses\Images\EditResponse;
use Odigos\OpenAI\Responses\Images\VariationResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class ImagesTestResource implements ImagesContract
{
    use Testable;
    protected function resource(): string
    {
        return Images::class;
    }
    public function create(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function edit(array $parameters): EditResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function variation(array $parameters): VariationResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

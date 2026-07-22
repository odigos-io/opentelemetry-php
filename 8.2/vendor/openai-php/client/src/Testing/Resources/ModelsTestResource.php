<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\ModelsContract;
use Odigos\OpenAI\Resources\Models;
use Odigos\OpenAI\Responses\Models\DeleteResponse;
use Odigos\OpenAI\Responses\Models\ListResponse;
use Odigos\OpenAI\Responses\Models\RetrieveResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class ModelsTestResource implements ModelsContract
{
    use Testable;
    protected function resource(): string
    {
        return Models::class;
    }
    public function list(): ListResponse
    {
        return $this->record(__FUNCTION__);
    }
    public function retrieve(string $model): RetrieveResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function delete(string $model): DeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

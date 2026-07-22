<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\FilesContract;
use Odigos\OpenAI\Resources\Files;
use Odigos\OpenAI\Responses\Files\CreateResponse;
use Odigos\OpenAI\Responses\Files\DeleteResponse;
use Odigos\OpenAI\Responses\Files\ListResponse;
use Odigos\OpenAI\Responses\Files\RetrieveResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class FilesTestResource implements FilesContract
{
    use Testable;
    protected function resource(): string
    {
        return Files::class;
    }
    public function list(array $parameters = []): ListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function retrieve(string $file): RetrieveResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function download(string $file): string
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function upload(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function delete(string $file): DeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

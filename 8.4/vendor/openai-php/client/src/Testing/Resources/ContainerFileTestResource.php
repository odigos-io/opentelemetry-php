<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\ContainerFileContract;
use Odigos\OpenAI\Resources\ContainerFile;
use Odigos\OpenAI\Responses\Containers\Files\ContainerFileDeleteResponse;
use Odigos\OpenAI\Responses\Containers\Files\ContainerFileListResponse;
use Odigos\OpenAI\Responses\Containers\Files\ContainerFileResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class ContainerFileTestResource implements ContainerFileContract
{
    use Testable;
    public function resource(): string
    {
        return ContainerFile::class;
    }
    public function create(string $containerId, array $parameters = []): ContainerFileResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function list(string $containerId, array $parameters = []): ContainerFileListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function retrieve(string $containerId, string $fileId): ContainerFileResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function content(string $containerId, string $fileId): string
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function delete(string $containerId, string $fileId): ContainerFileDeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

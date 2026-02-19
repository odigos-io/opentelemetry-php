<?php

declare (strict_types=1);
namespace Odigos\League\Flysystem;

class UnableToCheckDirectoryExistence extends UnableToCheckExistence
{
    public function operation(): string
    {
        return FilesystemOperationFailed::OPERATION_DIRECTORY_EXISTS;
    }
}

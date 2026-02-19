<?php

declare (strict_types=1);
namespace Odigos\League\Flysystem\UrlGeneration;

use DateTimeInterface;
use Odigos\League\Flysystem\Config;
use Odigos\League\Flysystem\UnableToGenerateTemporaryUrl;
interface TemporaryUrlGenerator
{
    /**
     * @throws UnableToGenerateTemporaryUrl
     */
    public function temporaryUrl(string $path, DateTimeInterface $expiresAt, Config $config): string;
}

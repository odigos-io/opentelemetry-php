<?php

declare (strict_types=1);
namespace Odigos\League\Flysystem\UrlGeneration;

use Odigos\League\Flysystem\Config;
use Odigos\League\Flysystem\UnableToGeneratePublicUrl;
interface PublicUrlGenerator
{
    /**
     * @throws UnableToGeneratePublicUrl
     */
    public function publicUrl(string $path, Config $config): string;
}

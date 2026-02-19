<?php

declare (strict_types=1);
namespace Odigos\League\Flysystem\UrlGeneration;

use Odigos\League\Flysystem\Config;
use Odigos\League\Flysystem\UnableToGeneratePublicUrl;
final class ChainedPublicUrlGenerator implements PublicUrlGenerator
{
    /**
     * @param PublicUrlGenerator[] $generators
     */
    public function __construct(private iterable $generators)
    {
    }
    public function publicUrl(string $path, Config $config): string
    {
        foreach ($this->generators as $generator) {
            try {
                return $generator->publicUrl($path, $config);
            } catch (UnableToGeneratePublicUrl) {
            }
        }
        throw new UnableToGeneratePublicUrl('No supported public url generator found.', $path);
    }
}

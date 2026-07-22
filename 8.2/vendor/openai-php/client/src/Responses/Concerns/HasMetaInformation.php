<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Concerns;

use Odigos\OpenAI\Responses\Meta\MetaInformation;
trait HasMetaInformation
{
    public function meta(): MetaInformation
    {
        return $this->meta;
    }
}

<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Contracts;

use Odigos\OpenAI\Responses\Meta\MetaInformation;
interface ResponseHasMetaInformationContract
{
    public function meta(): MetaInformation;
}

<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Testing\Enums;

enum OverrideStrategy : string
{
    case Merge = 'merge';
    case Replace = 'replace';
}

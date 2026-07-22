<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Resources\Concerns;

use Odigos\OpenAI\Contracts\TransporterContract;
trait Transportable
{
    public function __construct(private readonly TransporterContract $transporter)
    {
        // ..
    }
}

<?php

namespace Odigos\Cron;

interface FieldFactoryInterface
{
    public function getField(int $position): FieldInterface;
}

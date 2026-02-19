<?php

namespace Odigos\FastRoute\Dispatcher;

class CharCountBasedTest extends DispatcherTest
{
    protected function getDispatcherClass()
    {
        return 'Odigos\FastRoute\Dispatcher\CharCountBased';
    }
    protected function getDataGeneratorClass()
    {
        return 'Odigos\FastRoute\DataGenerator\CharCountBased';
    }
}

<?php

namespace Odigos\FastRoute\Dispatcher;

class GroupCountBasedTest extends DispatcherTest
{
    protected function getDispatcherClass()
    {
        return 'Odigos\FastRoute\Dispatcher\GroupCountBased';
    }
    protected function getDataGeneratorClass()
    {
        return 'Odigos\FastRoute\DataGenerator\GroupCountBased';
    }
}

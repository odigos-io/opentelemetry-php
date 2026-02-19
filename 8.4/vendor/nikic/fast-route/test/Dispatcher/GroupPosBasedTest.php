<?php

namespace Odigos\FastRoute\Dispatcher;

class GroupPosBasedTest extends DispatcherTest
{
    protected function getDispatcherClass()
    {
        return 'Odigos\FastRoute\Dispatcher\GroupPosBased';
    }
    protected function getDataGeneratorClass()
    {
        return 'Odigos\FastRoute\DataGenerator\GroupPosBased';
    }
}

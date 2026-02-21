<?php

namespace Odigos\cebe\markdown\tests;

use Odigos\cebe\markdown\MarkdownExtra;
/**
 * @author Carsten Brandt <mail@cebe.cc>
 * @group extra
 */
class MarkdownExtraTest extends BaseMarkdownTest
{
    public function createMarkdown()
    {
        return new MarkdownExtra();
    }
    public function getDataPaths()
    {
        return ['markdown-data' => __DIR__ . '/markdown-data', 'extra-data' => __DIR__ . '/extra-data'];
    }
}

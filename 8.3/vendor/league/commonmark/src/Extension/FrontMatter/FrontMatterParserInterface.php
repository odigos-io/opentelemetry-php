<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace Odigos\League\CommonMark\Extension\FrontMatter;

use Odigos\League\CommonMark\Extension\FrontMatter\Input\MarkdownInputWithFrontMatter;
interface FrontMatterParserInterface
{
    public function parse(string $markdownContent): MarkdownInputWithFrontMatter;
}

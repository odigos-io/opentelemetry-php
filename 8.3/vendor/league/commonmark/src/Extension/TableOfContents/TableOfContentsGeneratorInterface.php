<?php

declare (strict_types=1);
/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Odigos\League\CommonMark\Extension\TableOfContents;

use Odigos\League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
use Odigos\League\CommonMark\Node\Block\Document;
interface TableOfContentsGeneratorInterface
{
    public function generate(Document $document): ?TableOfContents;
}

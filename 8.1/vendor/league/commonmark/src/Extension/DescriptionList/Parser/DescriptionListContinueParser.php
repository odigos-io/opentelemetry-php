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
namespace Odigos\League\CommonMark\Extension\DescriptionList\Parser;

use Odigos\League\CommonMark\Extension\DescriptionList\Node\Description;
use Odigos\League\CommonMark\Extension\DescriptionList\Node\DescriptionList;
use Odigos\League\CommonMark\Extension\DescriptionList\Node\DescriptionTerm;
use Odigos\League\CommonMark\Node\Block\AbstractBlock;
use Odigos\League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use Odigos\League\CommonMark\Parser\Block\BlockContinue;
use Odigos\League\CommonMark\Parser\Block\BlockContinueParserInterface;
use Odigos\League\CommonMark\Parser\Cursor;
final class DescriptionListContinueParser extends AbstractBlockContinueParser
{
    private DescriptionList $block;
    public function __construct()
    {
        $this->block = new DescriptionList();
    }
    public function getBlock(): DescriptionList
    {
        return $this->block;
    }
    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        return BlockContinue::at($cursor);
    }
    public function isContainer(): bool
    {
        return \true;
    }
    public function canContain(AbstractBlock $childBlock): bool
    {
        return $childBlock instanceof DescriptionTerm || $childBlock instanceof Description;
    }
}

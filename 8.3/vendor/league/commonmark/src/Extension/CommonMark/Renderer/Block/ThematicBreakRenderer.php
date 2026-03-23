<?php

declare (strict_types=1);
/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Odigos\League\CommonMark\Extension\CommonMark\Renderer\Block;

use Odigos\League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use Odigos\League\CommonMark\Node\Node;
use Odigos\League\CommonMark\Renderer\ChildNodeRendererInterface;
use Odigos\League\CommonMark\Renderer\NodeRendererInterface;
use Odigos\League\CommonMark\Util\HtmlElement;
use Odigos\League\CommonMark\Xml\XmlNodeRendererInterface;
final class ThematicBreakRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    /**
     * @param ThematicBreak $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        ThematicBreak::assertInstanceOf($node);
        $attrs = $node->data->get('attributes');
        return new HtmlElement('hr', $attrs, '', \true);
    }
    public function getXmlTagName(Node $node): string
    {
        return 'thematic_break';
    }
    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}

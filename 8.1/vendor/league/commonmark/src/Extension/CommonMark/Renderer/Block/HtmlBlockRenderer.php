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

use Odigos\League\CommonMark\Extension\CommonMark\Node\Block\HtmlBlock;
use Odigos\League\CommonMark\Node\Node;
use Odigos\League\CommonMark\Renderer\ChildNodeRendererInterface;
use Odigos\League\CommonMark\Renderer\NodeRendererInterface;
use Odigos\League\CommonMark\Util\HtmlFilter;
use Odigos\League\CommonMark\Xml\XmlNodeRendererInterface;
use Odigos\League\Config\ConfigurationAwareInterface;
use Odigos\League\Config\ConfigurationInterface;
final class HtmlBlockRenderer implements NodeRendererInterface, XmlNodeRendererInterface, ConfigurationAwareInterface
{
    /** @psalm-readonly-allow-private-mutation */
    private ConfigurationInterface $config;
    /**
     * @param HtmlBlock $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        HtmlBlock::assertInstanceOf($node);
        $htmlInput = $this->config->get('html_input');
        return HtmlFilter::filter($node->getLiteral(), $htmlInput);
    }
    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }
    public function getXmlTagName(Node $node): string
    {
        return 'html_block';
    }
    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}

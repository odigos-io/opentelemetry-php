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
namespace Odigos\League\CommonMark\Environment;

use Odigos\League\CommonMark\Delimiter\Processor\DelimiterProcessorCollection;
use Odigos\League\CommonMark\Extension\ExtensionInterface;
use Odigos\League\CommonMark\Node\Node;
use Odigos\League\CommonMark\Normalizer\TextNormalizerInterface;
use Odigos\League\CommonMark\Parser\Block\BlockStartParserInterface;
use Odigos\League\CommonMark\Parser\Inline\InlineParserInterface;
use Odigos\League\CommonMark\Renderer\NodeRendererInterface;
use Odigos\League\Config\ConfigurationProviderInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
interface EnvironmentInterface extends ConfigurationProviderInterface, EventDispatcherInterface
{
    /**
     * Get all registered extensions
     *
     * @return ExtensionInterface[]
     */
    public function getExtensions(): iterable;
    /**
     * @return iterable<BlockStartParserInterface>
     */
    public function getBlockStartParsers(): iterable;
    /**
     * @return iterable<InlineParserInterface>
     */
    public function getInlineParsers(): iterable;
    public function getDelimiterProcessors(): DelimiterProcessorCollection;
    /**
     * @psalm-param class-string<Node> $nodeClass
     *
     * @return iterable<NodeRendererInterface>
     */
    public function getRenderersForClass(string $nodeClass): iterable;
    public function getSlugNormalizer(): TextNormalizerInterface;
}

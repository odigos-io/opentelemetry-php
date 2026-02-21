<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\CssSelector\Node;

/**
 * Represents a combined node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
class CombinedSelectorNode extends \Symfony\Component\CssSelector\Node\AbstractNode
{
    public function __construct(private \Symfony\Component\CssSelector\Node\NodeInterface $selector, private string $combinator, private \Symfony\Component\CssSelector\Node\NodeInterface $subSelector)
    {
    }
    public function getSelector(): \Symfony\Component\CssSelector\Node\NodeInterface
    {
        return $this->selector;
    }
    public function getCombinator(): string
    {
        return $this->combinator;
    }
    public function getSubSelector(): \Symfony\Component\CssSelector\Node\NodeInterface
    {
        return $this->subSelector;
    }
    public function getSpecificity(): \Symfony\Component\CssSelector\Node\Specificity
    {
        return $this->selector->getSpecificity()->plus($this->subSelector->getSpecificity());
    }
    public function __toString(): string
    {
        $combinator = ' ' === $this->combinator ? '<followed>' : $this->combinator;
        return \sprintf('%s[%s %s %s]', $this->getNodeName(), $this->selector, $combinator, $this->subSelector);
    }
}

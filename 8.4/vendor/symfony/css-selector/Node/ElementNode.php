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
 * Represents a "<namespace>|<element>" node.
 *
 * This component is a port of the Python cssselect library,
 * which is copyright Ian Bicking, @see https://github.com/SimonSapin/cssselect.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 *
 * @internal
 */
class ElementNode extends \Symfony\Component\CssSelector\Node\AbstractNode
{
    public function __construct(private ?string $namespace = null, private ?string $element = null)
    {
    }
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }
    public function getElement(): ?string
    {
        return $this->element;
    }
    public function getSpecificity(): \Symfony\Component\CssSelector\Node\Specificity
    {
        return new \Symfony\Component\CssSelector\Node\Specificity(0, 0, $this->element ? 1 : 0);
    }
    public function __toString(): string
    {
        $element = $this->element ?: '*';
        return \sprintf('%s[%s]', $this->getNodeName(), $this->namespace ? $this->namespace . '|' . $element : $element);
    }
}

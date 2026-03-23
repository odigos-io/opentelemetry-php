<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) 2015 Martin Hasoň <martin.hason@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace Odigos\League\CommonMark\Extension\Attributes;

use Odigos\League\CommonMark\Environment\EnvironmentBuilderInterface;
use Odigos\League\CommonMark\Event\DocumentParsedEvent;
use Odigos\League\CommonMark\Extension\Attributes\Event\AttributesListener;
use Odigos\League\CommonMark\Extension\Attributes\Parser\AttributesBlockStartParser;
use Odigos\League\CommonMark\Extension\Attributes\Parser\AttributesInlineParser;
use Odigos\League\CommonMark\Extension\ConfigurableExtensionInterface;
use Odigos\League\Config\ConfigurationBuilderInterface;
use Odigos\Nette\Schema\Expect;
final class AttributesExtension implements ConfigurableExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('attributes', Expect::structure(['allow' => Expect::arrayOf('string')->default([])]));
    }
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $allowList = $environment->getConfiguration()->get('attributes.allow');
        $allowUnsafeLinks = $environment->getConfiguration()->get('allow_unsafe_links');
        $environment->addBlockStartParser(new AttributesBlockStartParser());
        $environment->addInlineParser(new AttributesInlineParser());
        $environment->addEventListener(DocumentParsedEvent::class, [new AttributesListener($allowList, $allowUnsafeLinks), 'processDocument']);
    }
}

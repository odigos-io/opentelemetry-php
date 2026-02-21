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
namespace Odigos\League\CommonMark\Extension;

use Odigos\League\CommonMark\Environment\EnvironmentBuilderInterface;
use Odigos\League\CommonMark\Extension\Autolink\AutolinkExtension;
use Odigos\League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use Odigos\League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use Odigos\League\CommonMark\Extension\Table\TableExtension;
use Odigos\League\CommonMark\Extension\TaskList\TaskListExtension;
final class GithubFlavoredMarkdownExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new DisallowedRawHtmlExtension());
        $environment->addExtension(new StrikethroughExtension());
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new TaskListExtension());
    }
}

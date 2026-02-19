<?php

namespace Illuminate\Console\View\Components;

use Symfony\Component\Console\Output\OutputInterface;
class BulletList extends \Illuminate\Console\View\Components\Component
{
    /**
     * Renders the component using the given arguments.
     *
     * @param  array<int, string>  $elements
     * @param  int  $verbosity
     * @return void
     */
    public function render($elements, $verbosity = OutputInterface::VERBOSITY_NORMAL)
    {
        $elements = $this->mutate($elements, [\Illuminate\Console\View\Components\Mutators\EnsureDynamicContentIsHighlighted::class, \Illuminate\Console\View\Components\Mutators\EnsureNoPunctuation::class, \Illuminate\Console\View\Components\Mutators\EnsureRelativePaths::class]);
        $this->renderView('bullet-list', ['elements' => $elements], $verbosity);
    }
}

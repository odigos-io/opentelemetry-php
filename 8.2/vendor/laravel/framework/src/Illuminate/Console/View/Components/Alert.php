<?php

namespace Illuminate\Console\View\Components;

use Symfony\Component\Console\Output\OutputInterface;
class Alert extends \Illuminate\Console\View\Components\Component
{
    /**
     * Renders the component using the given arguments.
     *
     * @param  string  $string
     * @param  int  $verbosity
     * @return void
     */
    public function render($string, $verbosity = OutputInterface::VERBOSITY_NORMAL)
    {
        $string = $this->mutate($string, [\Illuminate\Console\View\Components\Mutators\EnsureDynamicContentIsHighlighted::class, \Illuminate\Console\View\Components\Mutators\EnsurePunctuation::class, \Illuminate\Console\View\Components\Mutators\EnsureRelativePaths::class]);
        $this->renderView('alert', ['content' => $string], $verbosity);
    }
}

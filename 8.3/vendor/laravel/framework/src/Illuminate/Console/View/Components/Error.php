<?php

namespace Odigos\Illuminate\Console\View\Components;

use Odigos\Symfony\Component\Console\Output\OutputInterface;
class Error extends Component
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
        (new Line($this->output))->render('error', $string, $verbosity);
    }
}

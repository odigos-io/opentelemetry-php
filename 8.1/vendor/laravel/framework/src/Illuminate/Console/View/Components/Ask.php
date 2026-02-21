<?php

namespace Illuminate\Console\View\Components;

class Ask extends \Illuminate\Console\View\Components\Component
{
    /**
     * Renders the component using the given arguments.
     *
     * @param  string  $question
     * @param  string  $default
     * @return mixed
     */
    public function render($question, $default = null)
    {
        return $this->usingQuestionHelper(fn() => $this->output->ask($question, $default));
    }
}

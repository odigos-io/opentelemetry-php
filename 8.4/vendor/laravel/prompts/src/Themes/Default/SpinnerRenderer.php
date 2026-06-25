<?php

namespace Laravel\Prompts\Themes\Default;

use Laravel\Prompts\Concerns\HasSpinner;
use Laravel\Prompts\Spinner;
class SpinnerRenderer extends \Laravel\Prompts\Themes\Default\Renderer
{
    use HasSpinner;
    /**
     * Render the spinner.
     */
    public function __invoke(Spinner $spinner): string
    {
        if ($spinner->static) {
            return $this->line(" {$this->cyan($this->staticFrame)} {$spinner->message}");
        }
        $spinner->interval = $this->interval;
        return $this->line(" {$this->cyan($this->spinnerFrame($spinner->count))} {$spinner->message}");
    }
}

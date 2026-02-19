<?php

namespace Laravel\Prompts\Themes\Default;

use Laravel\Prompts\PausePrompt;
class PausePromptRenderer extends \Laravel\Prompts\Themes\Default\Renderer
{
    use \Laravel\Prompts\Themes\Default\Concerns\DrawsBoxes;
    /**
     * Render the pause prompt.
     */
    public function __invoke(PausePrompt $prompt): string
    {
        $lines = explode(\PHP_EOL, $prompt->message);
        $color = $prompt->state === 'submit' ? 'green' : 'gray';
        foreach ($lines as $line) {
            $this->line(" {$this->{$color}($line)}");
        }
        return $this;
    }
}

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
        match ($prompt->state) {
            'submit' => collect(explode(\PHP_EOL, $prompt->message))->each(fn($line) => $this->line($this->gray(" {$line}"))),
            default => collect(explode(\PHP_EOL, $prompt->message))->each(fn($line) => $this->line($this->green(" {$line}"))),
        };
        return $this;
    }
}

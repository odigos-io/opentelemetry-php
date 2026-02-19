<?php

namespace Laravel\Prompts;

class PausePrompt extends \Laravel\Prompts\Prompt
{
    /**
     * Create a new PausePrompt instance.
     */
    public function __construct(public string $message = 'Press enter to continue...')
    {
        $this->required = \false;
        $this->validate = null;
        $this->on('key', fn($key) => match ($key) {
            \Laravel\Prompts\Key::ENTER => $this->submit(),
            default => null,
        });
    }
    /**
     * Get the value of the prompt.
     */
    public function value(): bool
    {
        return static::$interactive;
    }
}

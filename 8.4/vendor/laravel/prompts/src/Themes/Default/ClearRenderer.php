<?php

namespace Laravel\Prompts\Themes\Default;

class ClearRenderer extends \Laravel\Prompts\Themes\Default\Renderer
{
    /**
     * Clear the terminal.
     */
    public function __invoke(): string
    {
        return "\x1b[H\x1b[J";
    }
}

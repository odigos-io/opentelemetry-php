<?php

namespace Laravel\Prompts\Themes\Default;

use Laravel\Prompts\Title;
class TitleRenderer extends \Laravel\Prompts\Themes\Default\Renderer
{
    /**
     * Render the title.
     */
    public function __invoke(Title $title): string
    {
        return "\x1b]0;{$title->title}\x07";
    }
}

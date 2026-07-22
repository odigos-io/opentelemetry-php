<?php

namespace Odigos\Laravel\Prompts\Themes\Default;

use Odigos\Laravel\Prompts\Title;
class TitleRenderer extends Renderer
{
    /**
     * Render the title.
     */
    public function __invoke(Title $title): string
    {
        return "\x1b]0;{$title->title}\x07";
    }
}

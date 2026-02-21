<?php

namespace Laravel\Prompts\Concerns;

use Laravel\Prompts\Output\BufferedConsoleOutput;
use function Odigos\Termwind\render;
use function Odigos\Termwind\renderUsing;
trait Termwind
{
    protected function termwind(string $html)
    {
        renderUsing($output = new BufferedConsoleOutput());
        render($html);
        return $this->restoreEscapeSequences($output->fetch());
    }
    protected function restoreEscapeSequences(string $string)
    {
        return preg_replace('/\[(\d+)m/', "\x1b[" . '\1m', $string);
    }
}

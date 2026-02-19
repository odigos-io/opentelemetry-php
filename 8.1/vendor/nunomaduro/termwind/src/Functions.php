<?php

declare (strict_types=1);
namespace Odigos\Termwind;

use Closure;
use Symfony\Component\Console\Output\OutputInterface;
use Odigos\Termwind\Repositories\Styles as StyleRepository;
use Odigos\Termwind\ValueObjects\Style;
use Odigos\Termwind\ValueObjects\Styles;
if (!function_exists('Odigos\Termwind\renderUsing')) {
    /**
     * Sets the renderer implementation.
     */
    function renderUsing(?OutputInterface $renderer): void
    {
        Termwind::renderUsing($renderer);
    }
}
if (!function_exists('Odigos\Termwind\style')) {
    /**
     * Creates a new style.
     *
     * @param  (Closure(Styles $renderable, string|int ...$arguments): Styles)|null  $callback
     */
    function style(string $name, ?Closure $callback = null): Style
    {
        return StyleRepository::create($name, $callback);
    }
}
if (!function_exists('Odigos\Termwind\render')) {
    /**
     * Render HTML to a string.
     */
    function render(string $html, int $options = OutputInterface::OUTPUT_NORMAL): void
    {
        (new HtmlRenderer())->render($html, $options);
    }
}
if (!function_exists('Odigos\Termwind\terminal')) {
    /**
     * Returns a Terminal instance.
     */
    function terminal(): Terminal
    {
        return new Terminal();
    }
}
if (!function_exists('Odigos\Termwind\ask')) {
    /**
     * Renders a prompt to the user.
     *
     * @param  iterable<array-key, string>|null  $autocomplete
     */
    function ask(string $question, ?iterable $autocomplete = null): mixed
    {
        return (new Question())->ask($question, $autocomplete);
    }
}

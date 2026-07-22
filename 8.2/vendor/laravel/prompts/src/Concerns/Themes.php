<?php

namespace Odigos\Laravel\Prompts\Concerns;

use InvalidArgumentException;
use Odigos\Laravel\Prompts\AutoCompletePrompt;
use Odigos\Laravel\Prompts\Callout;
use Odigos\Laravel\Prompts\Clear;
use Odigos\Laravel\Prompts\ConfirmPrompt;
use Odigos\Laravel\Prompts\DataTablePrompt;
use Odigos\Laravel\Prompts\Grid;
use Odigos\Laravel\Prompts\MultiSearchPrompt;
use Odigos\Laravel\Prompts\MultiSelectPrompt;
use Odigos\Laravel\Prompts\Note;
use Odigos\Laravel\Prompts\NumberPrompt;
use Odigos\Laravel\Prompts\PasswordPrompt;
use Odigos\Laravel\Prompts\PausePrompt;
use Odigos\Laravel\Prompts\Progress;
use Odigos\Laravel\Prompts\Prompt;
use Odigos\Laravel\Prompts\SearchPrompt;
use Odigos\Laravel\Prompts\SelectPrompt;
use Odigos\Laravel\Prompts\Spinner;
use Odigos\Laravel\Prompts\Stream;
use Odigos\Laravel\Prompts\SuggestPrompt;
use Odigos\Laravel\Prompts\Table;
use Odigos\Laravel\Prompts\Task;
use Odigos\Laravel\Prompts\TextareaPrompt;
use Odigos\Laravel\Prompts\TextPrompt;
use Odigos\Laravel\Prompts\Themes\Default\AutoCompletePromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\CalloutRenderer;
use Odigos\Laravel\Prompts\Themes\Default\ClearRenderer;
use Odigos\Laravel\Prompts\Themes\Default\ConfirmPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\DataTableRenderer;
use Odigos\Laravel\Prompts\Themes\Default\GridRenderer;
use Odigos\Laravel\Prompts\Themes\Default\MultiSearchPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\MultiSelectPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\NoteRenderer;
use Odigos\Laravel\Prompts\Themes\Default\NumberPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\PasswordPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\PausePromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\ProgressRenderer;
use Odigos\Laravel\Prompts\Themes\Default\SearchPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\SelectPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\SpinnerRenderer;
use Odigos\Laravel\Prompts\Themes\Default\StreamRenderer;
use Odigos\Laravel\Prompts\Themes\Default\SuggestPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\TableRenderer;
use Odigos\Laravel\Prompts\Themes\Default\TaskRenderer;
use Odigos\Laravel\Prompts\Themes\Default\TextareaPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\TextPromptRenderer;
use Odigos\Laravel\Prompts\Themes\Default\TitleRenderer;
use Odigos\Laravel\Prompts\Title;
trait Themes
{
    /**
     * The name of the active theme.
     */
    protected static string $theme = 'default';
    /**
     * The available themes.
     *
     * @var array<string, array<class-string<Prompt>, class-string<object&callable>>>
     */
    protected static array $themes = ['default' => [TextPrompt::class => TextPromptRenderer::class, NumberPrompt::class => NumberPromptRenderer::class, TextareaPrompt::class => TextareaPromptRenderer::class, PasswordPrompt::class => PasswordPromptRenderer::class, SelectPrompt::class => SelectPromptRenderer::class, MultiSelectPrompt::class => MultiSelectPromptRenderer::class, ConfirmPrompt::class => ConfirmPromptRenderer::class, PausePrompt::class => PausePromptRenderer::class, SearchPrompt::class => SearchPromptRenderer::class, MultiSearchPrompt::class => MultiSearchPromptRenderer::class, SuggestPrompt::class => SuggestPromptRenderer::class, Spinner::class => SpinnerRenderer::class, Note::class => NoteRenderer::class, Table::class => TableRenderer::class, Progress::class => ProgressRenderer::class, Clear::class => ClearRenderer::class, Grid::class => GridRenderer::class, AutoCompletePrompt::class => AutoCompletePromptRenderer::class, Title::class => TitleRenderer::class, Stream::class => StreamRenderer::class, Task::class => TaskRenderer::class, DataTablePrompt::class => DataTableRenderer::class, Callout::class => CalloutRenderer::class]];
    /**
     * Get or set the active theme.
     *
     * @throws InvalidArgumentException
     */
    public static function theme(?string $name = null): string
    {
        if ($name === null) {
            return static::$theme;
        }
        if (!isset(static::$themes[$name])) {
            throw new InvalidArgumentException("Prompt theme [{$name}] not found.");
        }
        return static::$theme = $name;
    }
    /**
     * Add a new theme.
     *
     * @param  array<class-string<Prompt>, class-string<object&callable>>  $renderers
     */
    public static function addTheme(string $name, array $renderers): void
    {
        if ($name === 'default') {
            throw new InvalidArgumentException('The default theme cannot be overridden.');
        }
        static::$themes[$name] = $renderers;
    }
    /**
     * Get the renderer for the current prompt.
     */
    protected function getRenderer(): callable
    {
        $class = get_class($this);
        return new (static::$themes[static::$theme][$class] ?? static::$themes['default'][$class])($this);
    }
    /**
     * Render the prompt using the active theme.
     */
    protected function renderTheme(): string
    {
        $renderer = $this->getRenderer();
        return $renderer($this);
    }
}

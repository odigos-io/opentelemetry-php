<?php

namespace Laravel\Prompts;

use Closure;
class ConfirmPrompt extends \Laravel\Prompts\Prompt
{
    /**
     * Whether the prompt has been confirmed.
     */
    public bool $confirmed;
    /**
     * Create a new ConfirmPrompt instance.
     */
    public function __construct(public string $label, public bool $default = \true, public string $yes = 'Yes', public string $no = 'No', public bool|string $required = \false, public mixed $validate = null, public string $hint = '', public ?Closure $transform = null)
    {
        $this->confirmed = $default;
        $this->on('key', fn($key) => match ($key) {
            'y' => $this->confirmed = \true,
            'n' => $this->confirmed = \false,
            \Laravel\Prompts\Key::TAB, \Laravel\Prompts\Key::UP, \Laravel\Prompts\Key::UP_ARROW, \Laravel\Prompts\Key::DOWN, \Laravel\Prompts\Key::DOWN_ARROW, \Laravel\Prompts\Key::LEFT, \Laravel\Prompts\Key::LEFT_ARROW, \Laravel\Prompts\Key::RIGHT, \Laravel\Prompts\Key::RIGHT_ARROW, \Laravel\Prompts\Key::CTRL_P, \Laravel\Prompts\Key::CTRL_F, \Laravel\Prompts\Key::CTRL_N, \Laravel\Prompts\Key::CTRL_B, 'h', 'j', 'k', 'l' => $this->confirmed = !$this->confirmed,
            \Laravel\Prompts\Key::ENTER => $this->submit(),
            default => null,
        });
    }
    /**
     * Get the value of the prompt.
     */
    public function value(): bool
    {
        return $this->confirmed;
    }
    /**
     * Get the label of the selected option.
     */
    public function label(): string
    {
        return $this->confirmed ? $this->yes : $this->no;
    }
}

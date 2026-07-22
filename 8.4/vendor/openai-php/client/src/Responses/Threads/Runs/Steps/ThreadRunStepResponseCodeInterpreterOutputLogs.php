<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Threads\Runs\Steps;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{type: 'logs', logs: string}>
 */
final class ThreadRunStepResponseCodeInterpreterOutputLogs implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{type: 'logs', logs: string}>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'logs'  $type
     */
    private function __construct(public string $type, public string $logs)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{type: 'logs', logs: string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self($attributes['type'], $attributes['logs']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type, 'logs' => $this->logs];
    }
}

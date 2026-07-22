<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Input;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type FunctionToolCallOutputType array{call_id: string, id: string, output: string, type: 'function_call_output', status: 'in_progress'|'completed'|'incompleted'}
 *
 * @implements ResponseContract<FunctionToolCallOutputType>
 */
final class FunctionToolCallOutput implements ResponseContract
{
    /**
     * @use ArrayAccessible<FunctionToolCallOutputType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'function_call_output'  $type
     * @param  'in_progress'|'completed'|'incompleted'  $status
     */
    private function __construct(public readonly string $callId, public readonly string $id, public readonly string $output, public readonly string $type, public readonly string $status)
    {
    }
    /**
     * @param  FunctionToolCallOutputType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(callId: $attributes['call_id'], id: $attributes['id'], output: $attributes['output'], type: $attributes['type'], status: $attributes['status']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['call_id' => $this->callId, 'id' => $this->id, 'output' => $this->output, 'type' => $this->type, 'status' => $this->status];
    }
}

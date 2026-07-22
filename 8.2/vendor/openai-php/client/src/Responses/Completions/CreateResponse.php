<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Completions;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{id: string, object: string, created: int, model: string, choices: array<int, array{text: string, index: int, logprobs: array{tokens: array<int, string>, token_logprobs: array<int, float>, top_logprobs: array<int, string>|null, text_offset: array<int, int>}|null, finish_reason: string|null}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}>
 */
final class CreateResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<array{id: string, object: string, created: int, model: string, choices: array<int, array{text: string, index: int, logprobs: array{tokens: array<int, string>, token_logprobs: array<int, float>, top_logprobs: array<int, string>|null, text_offset: array<int, int>}|null, finish_reason: string|null}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    /**
     * @param  array<int, CreateResponseChoice>  $choices
     */
    private function __construct(public readonly string $id, public readonly string $object, public readonly int $created, public readonly string $model, public readonly array $choices, public readonly CreateResponseUsage $usage, private readonly MetaInformation $meta)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, object: string, created: int, model: string, choices: array<int, array{text: string, index: int, logprobs: array{tokens: array<int, string>, token_logprobs: array<int, float>, top_logprobs: array<int, string>|null, text_offset: array<int, int>}|null, finish_reason: string}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $choices = array_map(fn(array $result): CreateResponseChoice => CreateResponseChoice::from($result), $attributes['choices']);
        return new self($attributes['id'], $attributes['object'], $attributes['created'], $attributes['model'], $choices, CreateResponseUsage::from($attributes['usage']), $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['id' => $this->id, 'object' => $this->object, 'created' => $this->created, 'model' => $this->model, 'choices' => array_map(static fn(CreateResponseChoice $result): array => $result->toArray(), $this->choices), 'usage' => $this->usage->toArray()];
    }
}

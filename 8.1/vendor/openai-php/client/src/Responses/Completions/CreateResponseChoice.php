<?php

declare (strict_types=1);
namespace OpenAI\Responses\Completions;

final class CreateResponseChoice
{
    private function __construct(public readonly string $text, public readonly int $index, public readonly ?\OpenAI\Responses\Completions\CreateResponseChoiceLogprobs $logprobs, public readonly ?string $finishReason)
    {
    }
    /**
     * @param  array{text: string, index: int, logprobs: array{tokens: array<int, string>, token_logprobs: array<int, float>, top_logprobs: array<int, string>|null, text_offset: array<int, int>}|null, finish_reason: string|null}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self($attributes['text'], $attributes['index'], $attributes['logprobs'] ? \OpenAI\Responses\Completions\CreateResponseChoiceLogprobs::from($attributes['logprobs']) : null, $attributes['finish_reason']);
    }
    /**
     * @return array{text: string, index: int, logprobs: array{tokens: array<int, string>, token_logprobs: array<int, float>, top_logprobs: array<int, string>|null, text_offset: array<int, int>}|null, finish_reason: string|null}
     */
    public function toArray(): array
    {
        return ['text' => $this->text, 'index' => $this->index, 'logprobs' => $this->logprobs instanceof \OpenAI\Responses\Completions\CreateResponseChoiceLogprobs ? $this->logprobs->toArray() : null, 'finish_reason' => $this->finishReason];
    }
}

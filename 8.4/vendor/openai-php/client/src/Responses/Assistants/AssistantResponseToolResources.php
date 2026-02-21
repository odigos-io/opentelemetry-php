<?php

declare (strict_types=1);
namespace OpenAI\Responses\Assistants;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @implements ResponseContract<array{code_interpreter?: array{file_ids: array<int,string>}, file_search?: array{vector_store_ids: array<int,string>}}>
 */
final class AssistantResponseToolResources implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{code_interpreter?: array{file_ids: array<int,string>}, file_search?: array{vector_store_ids: array<int,string>}}>
     */
    use ArrayAccessible;
    use Fakeable;
    private function __construct(public ?\OpenAI\Responses\Assistants\AssistantResponseToolResourceCodeInterpreter $codeInterpreter, public ?\OpenAI\Responses\Assistants\AssistantResponseToolResourceFileSearch $fileSearch)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{code_interpreter?: array{file_ids: array<int,string>}, file_search?: array{vector_store_ids: array<int,string>}}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(isset($attributes['code_interpreter']) ? \OpenAI\Responses\Assistants\AssistantResponseToolResourceCodeInterpreter::from($attributes['code_interpreter']) : null, isset($attributes['file_search']) ? \OpenAI\Responses\Assistants\AssistantResponseToolResourceFileSearch::from($attributes['file_search']) : null);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_filter(['code_interpreter' => $this->codeInterpreter?->toArray(), 'file_search' => $this->fileSearch?->toArray()]);
    }
}

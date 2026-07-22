<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses;

use Odigos\OpenAI\Actions\Responses\ItemObjects;
use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Responses\Responses\Input\ComputerToolCallOutput;
use Odigos\OpenAI\Responses\Responses\Input\CustomToolCallOutput;
use Odigos\OpenAI\Responses\Responses\Input\FunctionToolCallOutput;
use Odigos\OpenAI\Responses\Responses\Input\InputMessage;
use Odigos\OpenAI\Responses\Responses\Input\LocalShellCallOutput;
use Odigos\OpenAI\Responses\Responses\Input\McpApprovalResponse;
use Odigos\OpenAI\Responses\Responses\Output\OutputCodeInterpreterToolCall;
use Odigos\OpenAI\Responses\Responses\Output\OutputComputerToolCall;
use Odigos\OpenAI\Responses\Responses\Output\OutputCustomToolCall;
use Odigos\OpenAI\Responses\Responses\Output\OutputFileSearchToolCall;
use Odigos\OpenAI\Responses\Responses\Output\OutputFunctionToolCall;
use Odigos\OpenAI\Responses\Responses\Output\OutputImageGenerationToolCall;
use Odigos\OpenAI\Responses\Responses\Output\OutputLocalShellCall;
use Odigos\OpenAI\Responses\Responses\Output\OutputMcpApprovalRequest;
use Odigos\OpenAI\Responses\Responses\Output\OutputMcpCall;
use Odigos\OpenAI\Responses\Responses\Output\OutputMcpListTools;
use Odigos\OpenAI\Responses\Responses\Output\OutputMessage;
use Odigos\OpenAI\Responses\Responses\Output\OutputReasoning;
use Odigos\OpenAI\Responses\Responses\Output\OutputWebSearchToolCall;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-import-type ResponseItemObjectTypes from ItemObjects
 *
 * @phpstan-type ListInputItemsType array{data: ResponseItemObjectTypes, first_id: string, has_more: bool, last_id: string, object: 'list'}
 *
 * @implements ResponseContract<ListInputItemsType>
 */
final class ListInputItems implements ResponseContract, ResponseHasMetaInformationContract
{
    /** @use ArrayAccessible<ListInputItemsType> */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    /**
     * @param  array<int, InputMessage|OutputMessage|OutputFileSearchToolCall|OutputComputerToolCall|ComputerToolCallOutput|LocalShellCallOutput|McpApprovalResponse|CustomToolCallOutput|OutputWebSearchToolCall|OutputFunctionToolCall|FunctionToolCallOutput|OutputReasoning|OutputMcpListTools|OutputMcpApprovalRequest|OutputMcpCall|OutputImageGenerationToolCall|OutputCodeInterpreterToolCall|OutputLocalShellCall|OutputCustomToolCall>  $data
     * @param  'list'  $object
     */
    private function __construct(public readonly string $object, public readonly array $data, public readonly string $firstId, public readonly string $lastId, public readonly bool $hasMore, private readonly MetaInformation $meta)
    {
    }
    /**
     * @param  ListInputItemsType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        $data = ItemObjects::parse($attributes['data']);
        return new self(object: $attributes['object'], data: $data, firstId: $attributes['first_id'], lastId: $attributes['last_id'], hasMore: $attributes['has_more'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['object' => $this->object, 'data' => array_map(fn(InputMessage|OutputMessage|OutputFileSearchToolCall|OutputFunctionToolCall|FunctionToolCallOutput|OutputWebSearchToolCall|OutputComputerToolCall|ComputerToolCallOutput|LocalShellCallOutput|McpApprovalResponse|CustomToolCallOutput|OutputReasoning|OutputMcpListTools|OutputMcpApprovalRequest|OutputMcpCall|OutputImageGenerationToolCall|OutputCodeInterpreterToolCall|OutputLocalShellCall|OutputCustomToolCall $item): array => $item->toArray(), $this->data), 'first_id' => $this->firstId, 'last_id' => $this->lastId, 'has_more' => $this->hasMore];
    }
}

<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Conversations;

use Odigos\OpenAI\Actions\Conversations\ItemObjects;
use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Conversations\Objects\Message;
use Odigos\OpenAI\Responses\Responses\Input\ComputerToolCallOutput;
use Odigos\OpenAI\Responses\Responses\Input\CustomToolCallOutput;
use Odigos\OpenAI\Responses\Responses\Input\FunctionToolCallOutput;
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
use Odigos\OpenAI\Responses\Responses\Output\OutputReasoning;
use Odigos\OpenAI\Responses\Responses\Output\OutputWebSearchToolCall;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-import-type ItemObjectTypes from ItemObjects
 *
 * @phpstan-type ConversationItemType ItemObjectTypes
 *
 * @implements ResponseContract<ConversationItemType>
 */
final class ConversationItem implements ResponseContract
{
    /**
     * @use ArrayAccessible<ConversationItemType>
     */
    use ArrayAccessible;
    use Fakeable;
    private function __construct(public readonly Message|OutputFileSearchToolCall|OutputFunctionToolCall|FunctionToolCallOutput|LocalShellCallOutput|McpApprovalResponse|CustomToolCallOutput|OutputWebSearchToolCall|OutputComputerToolCall|ComputerToolCallOutput|OutputReasoning|OutputMcpListTools|OutputMcpApprovalRequest|OutputMcpCall|OutputImageGenerationToolCall|OutputCodeInterpreterToolCall|OutputLocalShellCall|OutputCustomToolCall $item)
    {
    }
    /**
     * @param  ConversationItemType  $attributes
     */
    public static function from(array $attributes): self
    {
        // Lets re-use our existing parser, so we don't have to duplicate the logic.
        // But we need to wrap the attributes in an array, since it expects an array of items.
        $item = ItemObjects::parse([$attributes])[0];
        return new self(item: $item);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->item->toArray();
    }
}

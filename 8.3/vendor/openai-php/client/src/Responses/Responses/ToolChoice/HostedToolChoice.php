<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\ToolChoice;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type HostedToolChoiceType array{type: 'file_search'|'web_search'|'web_search_preview'|'computer_use_preview'}
 *
 * @implements ResponseContract<HostedToolChoiceType>
 */
final class HostedToolChoice implements ResponseContract
{
    /**
     * @use ArrayAccessible<HostedToolChoiceType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'file_search'|'web_search'|'web_search_preview'|'computer_use_preview'  $type
     */
    private function __construct(public readonly string $type)
    {
    }
    /**
     * @param  HostedToolChoiceType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(type: $attributes['type']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['type' => $this->type];
    }
}

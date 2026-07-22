<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Responses\Output;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ReasoningSummaryType array{text: string, type: 'summary_text'}
 *
 * @implements ResponseContract<ReasoningSummaryType>
 */
final class OutputReasoningSummary implements ResponseContract
{
    /**
     * @use ArrayAccessible<ReasoningSummaryType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  'summary_text'  $type
     */
    private function __construct(public readonly string $text, public readonly string $type)
    {
    }
    /**
     * @param  ReasoningSummaryType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(text: $attributes['text'], type: $attributes['type']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['text' => $this->text, 'type' => $this->type];
    }
}

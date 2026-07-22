<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Audio\Streaming;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-import-type LogprobsType from Logprobs
 *
 * @phpstan-type TranscriptTextDoneType array{logprobs?: array<int, LogprobsType>|null, text: string}
 *
 * @implements ResponseContract<TranscriptTextDoneType>
 */
final class TranscriptTextDone implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<TranscriptTextDoneType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    /**
     * @param  array<int, Logprobs>|null  $logprobs
     */
    private function __construct(public readonly ?array $logprobs, public readonly string $text, public readonly MetaInformation $meta)
    {
    }
    /**
     * @param  TranscriptTextDoneType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        if (isset($attributes['logprobs'])) {
            $logprobs = array_map(fn(array $logprob): Logprobs => Logprobs::from($logprob, $meta), $attributes['logprobs']);
        }
        return new self(logprobs: $logprobs ?? null, text: $attributes['text'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['logprobs' => $this->logprobs ? array_map(fn(Logprobs $logprob): array => $logprob->toArray(), $this->logprobs) : null, 'text' => $this->text];
    }
}

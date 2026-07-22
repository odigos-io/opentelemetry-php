<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Audio;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Exceptions\UnknownEventException;
use Odigos\OpenAI\Responses\Audio\Streaming\TranscriptTextDelta;
use Odigos\OpenAI\Responses\Audio\Streaming\TranscriptTextDone;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\FakeableForStreamedResponse;
/**
 * @phpstan-type CreateStreamedResponseType array{event: string, data: array<string, mixed>}
 *
 * @implements ResponseContract<CreateStreamedResponseType>
 */
final class TranscriptionStreamResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<CreateStreamedResponseType>
     */
    use ArrayAccessible;
    use FakeableForStreamedResponse;
    private function __construct(public readonly string $event, public readonly TranscriptTextDelta|TranscriptTextDone $response)
    {
    }
    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        $event = $attributes['type'] ?? throw new UnknownEventException('Missing event type in streamed response');
        $meta = $attributes['__meta'];
        unset($attributes['__meta']);
        $response = match ($event) {
            'transcript.text.delta' => TranscriptTextDelta::from($attributes, $meta),
            // @phpstan-ignore-line
            'transcript.text.done' => TranscriptTextDone::from($attributes, $meta),
            // @phpstan-ignore-line
            default => throw new UnknownEventException('Unknown Audio Transcription streaming event: ' . $event),
        };
        return new self(
            event: $event,
            // @phpstan-ignore-line
            response: $response
        );
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['event' => $this->event, 'data' => $this->response->toArray()];
    }
}

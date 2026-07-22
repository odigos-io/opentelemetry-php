<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Realtime\Session;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type InputAudioTranscriptionType array{model: 'whisper-1'}
 *
 * @implements ResponseContract<InputAudioTranscriptionType>
 */
final class InputAudioTranscription implements ResponseContract
{
    /**
     * @use ArrayAccessible<InputAudioTranscriptionType>
     */
    use ArrayAccessible;
    use Fakeable;
    /**
     * @param  "whisper-1"  $model
     */
    private function __construct(public readonly string $model)
    {
    }
    /**
     * @param  InputAudioTranscriptionType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(model: $attributes['model']);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['model' => $this->model];
    }
}

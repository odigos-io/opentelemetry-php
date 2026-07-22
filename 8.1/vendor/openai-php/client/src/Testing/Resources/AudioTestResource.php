<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\AudioContract;
use Odigos\OpenAI\Resources\Audio;
use Odigos\OpenAI\Responses\Audio\SpeechStreamResponse;
use Odigos\OpenAI\Responses\Audio\TranscriptionResponse;
use Odigos\OpenAI\Responses\Audio\TranslationResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class AudioTestResource implements AudioContract
{
    use Testable;
    protected function resource(): string
    {
        return Audio::class;
    }
    public function speech(array $parameters): string
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function speechStreamed(array $parameters): SpeechStreamResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function transcribe(array $parameters): TranscriptionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function translate(array $parameters): TranslationResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

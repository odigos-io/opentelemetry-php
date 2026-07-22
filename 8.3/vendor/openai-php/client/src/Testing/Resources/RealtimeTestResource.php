<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\RealtimeContract;
use Odigos\OpenAI\Resources\Realtime;
use Odigos\OpenAI\Responses\Realtime\SessionResponse;
use Odigos\OpenAI\Responses\Realtime\TranscriptionSessionResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class RealtimeTestResource implements RealtimeContract
{
    use Testable;
    public function resource(): string
    {
        return Realtime::class;
    }
    public function token(array $parameters = []): SessionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function transcribeToken(array $parameters = []): TranscriptionSessionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

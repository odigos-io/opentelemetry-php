<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\FineTunesContract;
use Odigos\OpenAI\Resources\FineTunes;
use Odigos\OpenAI\Responses\FineTunes\ListEventsResponse;
use Odigos\OpenAI\Responses\FineTunes\ListResponse;
use Odigos\OpenAI\Responses\FineTunes\RetrieveResponse;
use Odigos\OpenAI\Responses\StreamResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class FineTunesTestResource implements FineTunesContract
{
    use Testable;
    protected function resource(): string
    {
        return FineTunes::class;
    }
    public function create(array $parameters): RetrieveResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function list(): ListResponse
    {
        return $this->record(__FUNCTION__);
    }
    public function retrieve(string $fineTuneId): RetrieveResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function cancel(string $fineTuneId): RetrieveResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function listEvents(string $fineTuneId): ListEventsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function listEventsStreamed(string $fineTuneId): StreamResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

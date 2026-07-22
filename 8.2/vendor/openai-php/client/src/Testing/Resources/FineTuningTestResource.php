<?php

namespace Odigos\OpenAI\Testing\Resources;

use Odigos\OpenAI\Contracts\Resources\FineTuningContract;
use Odigos\OpenAI\Resources\FineTuning;
use Odigos\OpenAI\Responses\FineTuning\ListJobEventsResponse;
use Odigos\OpenAI\Responses\FineTuning\ListJobsResponse;
use Odigos\OpenAI\Responses\FineTuning\RetrieveJobResponse;
use Odigos\OpenAI\Testing\Resources\Concerns\Testable;
final class FineTuningTestResource implements FineTuningContract
{
    use Testable;
    protected function resource(): string
    {
        return FineTuning::class;
    }
    public function createJob(array $parameters): RetrieveJobResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function listJobs(array $parameters = []): ListJobsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function retrieveJob(string $jobId): RetrieveJobResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function cancelJob(string $jobId): RetrieveJobResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
    public function listJobEvents(string $jobId, array $parameters = []): ListJobEventsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}

<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\Illuminate\Queue;

use Odigos\Illuminate\Contracts\Queue\Queue as QueueContract;
use Odigos\Illuminate\Queue\BeanstalkdQueue;
use Odigos\Illuminate\Queue\RedisQueue;
use Odigos\Illuminate\Queue\SqsQueue;
use OpenTelemetry\SemConv\TraceAttributes;
use OpenTelemetry\SemConv\TraceAttributeValues;
trait AttributesBuilder
{
    private function buildMessageAttributes(object $queue, string $rawPayload, ?string $queueName = null, array $options = [], mixed ...$params): array
    {
        $payload = json_decode($rawPayload, \true) ?? [];
        return array_merge([TraceAttributes::MESSAGING_DESTINATION_NAME => '(anonymous)', TraceAttributes::MESSAGING_MESSAGE_ID => $payload['uuid'] ?? $payload['id'] ?? null, TraceAttributes::MESSAGING_MESSAGE_ENVELOPE_SIZE => strlen($rawPayload), 'messaging.message.job_name' => $payload['displayName'] ?? $payload['job'] ?? null, 'messaging.message.attempts' => $payload['attempts'] ?? 0, 'messaging.message.max_exceptions' => $payload['maxExceptions'] ?? null, 'messaging.message.max_tries' => $payload['maxTries'] ?? null, 'messaging.message.retry_until' => $payload['retryUntil'] ?? null, 'messaging.message.timeout' => $payload['timeout'] ?? null], $this->contextualMessageSystemAttributes($queue, $payload, $queueName, $options, ...$params));
    }
    private function contextualMessageSystemAttributes(object $queue, array $payload, ?string $queueName = null, array $options = [], mixed ...$params): array
    {
        return match (\true) {
            is_a($queue, 'Illuminate\\Queue\\BeanstalkdQueue') => $this->beanstalkContextualAttributes($queue, $payload, $queueName, $options, ...$params),
            is_a($queue, 'Illuminate\\Queue\\RedisQueue') => $this->redisContextualAttributes($queue, $payload, $queueName, $options, ...$params),
            is_a($queue, 'Illuminate\\Queue\\SqsQueue') => $this->awsSqsContextualAttributes($queue, $payload, $queueName, $options, ...$params),
            default => [],
        };
    }
    private function beanstalkContextualAttributes(object $queue, array $_payload, ?string $queueName = null, array $_options = [], mixed ...$_params): array
    {
        return [TraceAttributes::MESSAGING_SYSTEM => 'beanstalk', TraceAttributes::MESSAGING_DESTINATION_NAME => $queue->getQueue($queueName)];
    }
    private function redisContextualAttributes(object $queue, array $_payload, ?string $queueName = null, array $_options = [], mixed ...$_params): array
    {
        return [TraceAttributes::MESSAGING_SYSTEM => 'redis', TraceAttributes::MESSAGING_DESTINATION_NAME => $queue->getQueue($queueName)];
    }
    private function awsSqsContextualAttributes(object $queue, array $_payload, ?string $queueName = null, array $_options = [], mixed ...$_params): array
    {
        return [TraceAttributes::MESSAGING_SYSTEM => TraceAttributeValues::MESSAGING_SYSTEM_AWS_SQS, TraceAttributes::MESSAGING_DESTINATION_NAME => $queue->getQueue($queueName)];
    }
}

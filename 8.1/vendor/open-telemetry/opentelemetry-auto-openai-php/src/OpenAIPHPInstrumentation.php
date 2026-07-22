<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\OpenAIPHP;

use Composer\InstalledVersions;
use Odigos\OpenAI\Contracts\Resources\AudioContract;
use Odigos\OpenAI\Contracts\Resources\ChatContract;
use Odigos\OpenAI\Contracts\Resources\CompletionsContract;
use Odigos\OpenAI\Contracts\Resources\EditsContract;
use Odigos\OpenAI\Contracts\Resources\EmbeddingsContract;
use Odigos\OpenAI\Contracts\Resources\ImagesContract;
use Odigos\OpenAI\Contracts\Resources\ModelsContract;
use Odigos\OpenAI\Contracts\ResponseContract;
use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use OpenTelemetry\API\Metrics\CounterInterface;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextInterface;
use function OpenTelemetry\Instrumentation\hook;
use OpenTelemetry\SemConv\TraceAttributes;
use OpenTelemetry\SemConv\Version;
use Throwable;
final class OpenAIPHPInstrumentation
{
    public const NAME = 'openaiphp';
    /**
     * @var CounterInterface
     */
    public static $totalTokensCounter;
    public static function register(): void
    {
        $instrumentation = new CachedInstrumentation('io.opentelemetry.contrib.php.openaiphp', InstalledVersions::getVersion('open-telemetry/opentelemetry-auto-openai-php'), Version::VERSION_1_32_0->url());
        self::$totalTokensCounter = $instrumentation->meter()->createCounter('openai.usage.total_tokens', 'tokens', 'Total tokens used by OpenAI');
        // hook the individual APIs
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\AudioContract', 'audio', 'speech');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\AudioContract', 'audio', 'transcribe');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\AudioContract', 'audio', 'translate');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\ChatContract', 'chat', 'create');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\ChatContract', 'chat', 'createStreamed');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\CompletionsContract', 'completions', 'create');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\CompletionsContract', 'completions', 'createStreamed');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\EditsContract', 'edits', 'create');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\EmbeddingsContract', 'embeddings', 'create');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\ImagesContract', 'images', 'create');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\ImagesContract', 'images', 'edit');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\ImagesContract', 'images', 'variation');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\ModelsContract', 'models', 'list');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\ModelsContract', 'models', 'retrieve');
        self::hookApi($instrumentation, 'OpenAI\\Contracts\\Resources\\ModelsContract', 'models', 'delete');
    }
    private static function hookApi(CachedInstrumentation $instrumentation, $class, string $resource, string $operation)
    {
        /** @psalm-suppress UnusedFunctionCall */
        hook($class, $operation, pre: static function ($object, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation, $operation, $resource) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = $instrumentation->tracer()->spanBuilder(sprintf('openai %s', $resource . '/' . $operation))->setSpanKind(SpanKind::KIND_INTERNAL)->setAttribute(TraceAttributes::CODE_FUNCTION_NAME, sprintf('%s::%s', $class, $function))->setAttribute(TraceAttributes::CODE_FILE_PATH, $filename)->setAttribute(TraceAttributes::CODE_LINE_NUMBER, $lineno)->setAttribute(OpenAIAttributes::OPENAI_RESOURCE, $resource . '/' . $operation);
            if (isset($params[0]) && is_array($params[0])) {
                $parameters = $params[0];
                foreach ($parameters as $key => $value) {
                    switch ($key) {
                        case 'response_format':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_RESPONSE_FORMAT, $value);
                            break;
                        case 'model':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_MODEL, $value);
                            break;
                        case 'temperature':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_TEMPERATURE, $value);
                            break;
                        case 'frequency_penalty':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_FREQUENCY_PENALTY, $value);
                            break;
                        case 'max_tokens':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_MAX_TOKENS, $value);
                            break;
                        case 'n':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_N, $value);
                            break;
                        case 'presence_penalty':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_PRESENCE_PENALTY, $value);
                            break;
                        case 'seed':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_SEED, $value);
                            break;
                        case 'stream':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_STREAM, $value);
                            break;
                        case 'top_p':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_TOP_P, $value);
                            break;
                        case 'user':
                            $builder->setAttribute(OpenAIAttributes::OPENAI_USER, $value);
                            break;
                    }
                }
            }
            $parent = Context::getCurrent();
            $span = $builder->setParent($parent)->startSpan();
            $context = $span->storeInContext($parent);
            Context::storage()->attach($context);
            return $params;
        }, post: static function ($object, array $params, $result, ?Throwable $exception) {
            $scope = Context::storage()->scope();
            if (null === $scope) {
                return;
            }
            $scope->detach();
            $span = Span::fromContext($scope->context());
            if (is_a($result, 'OpenAI\\Contracts\\ResponseContract')) {
                self::recordUsage($span, $result, $scope->context());
            }
            if ($exception !== null) {
                $span->recordException($exception);
                $span->setStatus(StatusCode::STATUS_ERROR, $exception->getMessage());
            }
            $span->end();
        });
    }
    private static function recordUsage(SpanInterface $span, object $response, ContextInterface $context)
    {
        if (!property_exists($response, 'usage') || !isset($response->usage) || !method_exists($response->usage, 'toArray')) {
            return;
        }
        $model = '';
        if (property_exists($response, 'model')) {
            $model = $response->model;
        }
        foreach ($response->usage->toArray() as $key => $value) {
            switch ($key) {
                case 'prompt_tokens':
                    $span->setAttribute(OpenAIAttributes::OPENAI_USAGE_PROMPT_TOKENS, $value);
                    break;
                case 'completion_tokens':
                    $span->setAttribute(OpenAIAttributes::OPENAI_USAGE_COMPLETION_TOKENS, $value);
                    break;
                case 'total_tokens':
                    $span->setAttribute(OpenAIAttributes::OPENAI_USAGE_TOTAL_TOKENS, $value);
                    self::$totalTokensCounter->add(is_int($value) || is_float($value) ? $value : 0, new \ArrayIterator(['model' => $model]), $context);
                    break;
            }
        }
    }
}

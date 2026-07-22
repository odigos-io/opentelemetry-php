<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Yii;

use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\Context;
use function OpenTelemetry\Instrumentation\hook;
use OpenTelemetry\SemConv\TraceAttributes;
use Odigos\yii\base\InlineAction;
use Odigos\yii\web\Application;
use Odigos\yii\web\Controller;
use Odigos\yii\web\Response;
class YiiInstrumentation
{
    public const NAME = 'yii';
    public static function register(): void
    {
        $instrumentation = new CachedInstrumentation('io.opentelemetry.contrib.php.yii', null, 'https://opentelemetry.io/schemas/1.32.0');
        hook('yii\\web\\Application', 'handleRequest', pre: static function (object $application, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation): void {
            $request = $application->getRequest();
            $parent = Globals::propagator()->extract($request, RequestPropagationGetter::instance());
            /** @psalm-suppress ArgumentTypeCoercion */
            $spanBuilder = $instrumentation->tracer()->spanBuilder(sprintf('%s', $request->getMethod()))->setParent($parent)->setSpanKind(SpanKind::KIND_SERVER)->setAttribute(TraceAttributes::CODE_FUNCTION_NAME, sprintf('%s::%s', $class, $function))->setAttribute(TraceAttributes::CODE_FILE_PATH, $filename)->setAttribute(TraceAttributes::CODE_LINE_NUMBER, $lineno)->setAttribute(TraceAttributes::URL_FULL, $request->getAbsoluteUrl())->setAttribute(TraceAttributes::HTTP_REQUEST_METHOD, $request->getMethod())->setAttribute(TraceAttributes::HTTP_REQUEST_BODY_SIZE, $request->getHeaders()->get('Content-Length', null, \true))->setAttribute(TraceAttributes::URL_SCHEME, $request->getIsSecureConnection() ? 'https' : 'http');
            $span = $spanBuilder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $application, array $params, ?object $response, ?\Throwable $exception): void {
            $scope = Context::storage()->scope();
            if (!$scope) {
                return;
            }
            $scope->detach();
            $span = Span::fromContext($scope->context());
            if ($response) {
                $statusCode = $response->getStatusCode();
                $span->setAttribute(TraceAttributes::HTTP_RESPONSE_STATUS_CODE, $statusCode);
                $span->setAttribute(TraceAttributes::NETWORK_PROTOCOL_VERSION, $response->version);
                $span->setAttribute(TraceAttributes::HTTP_RESPONSE_BODY_SIZE, YiiInstrumentation::getResponseLength($response));
                $headers = $response->getHeaders();
                foreach ((array) (get_cfg_var('otel.instrumentation.http.response_headers') ?: []) as $header) {
                    if ($headers->has($header)) {
                        /** @psalm-suppress ArgumentTypeCoercion */
                        $span->setAttribute(sprintf('http.response.header.%s', strtr(strtolower($header), ['-' => '_'])), $headers->get($header, null, \true));
                    }
                }
                if ($statusCode >= 400 && $statusCode < 600) {
                    $span->setStatus(StatusCode::STATUS_ERROR);
                }
                $prop = Globals::responsePropagator();
                $prop->inject($response, ResponsePropagationSetter::instance(), $scope->context());
            }
            if ($exception) {
                $span->recordException($exception);
                $span->setStatus(StatusCode::STATUS_ERROR, $exception->getMessage());
            }
            $span->end();
        });
        hook('yii\\web\\Controller', 'beforeAction', pre: static function (object $controller, array $params, string $class, string $function, ?string $filename, ?int $lineno): void {
            $action = $params[0] ?? null;
            $scope = Context::storage()->scope();
            if (!$action || !$scope) {
                return;
            }
            $span = Span::fromContext($scope->context());
            $actionName = is_a($action, 'yii\\base\\InlineAction') ? $action->actionMethod : $action->id;
            $route = YiiInstrumentation::normalizeRouteName(get_class($controller), $actionName);
            // Get the HTTP method from the request
            $request = $controller->request;
            $method = $request->getMethod();
            /** @psalm-suppress ArgumentTypeCoercion */
            // Update span name to follow OpenTelemetry HTTP naming convention: {http.method} {http.route}
            $span->updateName(sprintf('%s %s', $method, $route));
            $span->setAttribute(TraceAttributes::HTTP_ROUTE, $route);
        }, post: null);
    }
    protected static function getResponseLength(object $response): ?string
    {
        $headerValue = $response->getHeaders()->get('Content-Length', null, \true);
        if (is_string($headerValue)) {
            return $headerValue;
        }
        if ($response->content != null) {
            return (string) strlen($response->content);
        }
        return null;
    }
    protected static function normalizeRouteName(string $controllerClassName, string $actionName): string
    {
        $lastSegment = strrchr($controllerClassName, '\\');
        if ($lastSegment === \false) {
            return $controllerClassName . '.' . $actionName;
        }
        return substr($lastSegment, 1) . '.' . $actionName;
    }
}

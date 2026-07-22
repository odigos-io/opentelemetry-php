<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\CakePHP\Hooks\Cake\Controller;

use Odigos\Cake\Controller\Controller as CakeController;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\Context;
use Odigos\OpenTelemetry\Contrib\Instrumentation\CakePHP\Hooks\CakeHook;
use Odigos\OpenTelemetry\Contrib\Instrumentation\CakePHP\Hooks\CakeHookTrait;
use function OpenTelemetry\Instrumentation\hook;
use OpenTelemetry\SemConv\TraceAttributes;
use Throwable;
class Controller implements CakeHook
{
    use CakeHookTrait;
    public function instrument(): void
    {
        hook('Cake\\Controller\\Controller', 'invokeAction', pre: function (object $app, array $params, string $class, string $function, ?string $filename, ?int $lineno) {
            $request = $app->getRequest();
            $request = $this->buildSpan($request, $class, $function, $filename, $lineno);
            $app->setRequest($request);
        }, post: static function (object $app, array $params, $return, ?Throwable $exception) {
            $scope = Context::storage()->scope();
            if (!$scope) {
                return;
            }
            $scope->detach();
            $span = \OpenTelemetry\API\Trace\Span::fromContext($scope->context());
            if ($exception) {
                $span->recordException($exception);
                $span->setStatus(StatusCode::STATUS_ERROR, $exception->getMessage());
            }
            $response = $app->getResponse();
            if ($response->getStatusCode() >= 400) {
                $span->setStatus(StatusCode::STATUS_ERROR);
            }
            $span->setAttribute(TraceAttributes::HTTP_RESPONSE_STATUS_CODE, $response->getStatusCode());
            $span->setAttribute(TraceAttributes::NETWORK_PROTOCOL_VERSION, $response->getProtocolVersion());
            $span->setAttribute(TraceAttributes::HTTP_RESPONSE_BODY_SIZE, $response->getHeaderLine('Content-Length'));
            $span->end();
        });
    }
}

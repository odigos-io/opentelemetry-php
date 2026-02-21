<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics\StalenessHandler;

use Closure;
use OpenTelemetry\API\Common\Time\ClockInterface;
use OpenTelemetry\SDK\Metrics\ReferenceCounterInterface;
use OpenTelemetry\SDK\Metrics\StalenessHandlerFactoryInterface;
use OpenTelemetry\SDK\Metrics\StalenessHandlerInterface;
use WeakMap;
final class DelayedStalenessHandlerFactory implements StalenessHandlerFactoryInterface
{
    private readonly int $nanoDelay;
    private readonly Closure $stale;
    private readonly Closure $freshen;
    /** @var WeakMap<DelayedStalenessHandler, int> */
    private WeakMap $staleHandlers;
    /**
     * @param float $delay delay in seconds
     * @psalm-suppress PropertyTypeCoercion
     */
    public function __construct(private readonly ClockInterface $clock, float $delay)
    {
        $this->nanoDelay = (int) ($delay * 1000000000.0);
        $this->stale = function (\OpenTelemetry\SDK\Metrics\StalenessHandler\DelayedStalenessHandler $handler): void {
            $this->staleHandlers[$handler] = $this->clock->now();
        };
        $this->freshen = function (\OpenTelemetry\SDK\Metrics\StalenessHandler\DelayedStalenessHandler $handler): void {
            unset($this->staleHandlers[$handler]);
        };
        $this->staleHandlers = new WeakMap();
    }
    #[\Override]
    public function create(): ReferenceCounterInterface&StalenessHandlerInterface
    {
        $this->triggerStaleHandlers();
        return new \OpenTelemetry\SDK\Metrics\StalenessHandler\DelayedStalenessHandler($this->stale, $this->freshen);
    }
    private function triggerStaleHandlers(): void
    {
        $expired = $this->clock->now() - $this->nanoDelay;
        foreach ($this->staleHandlers as $handler => $timestamp) {
            if ($timestamp > $expired) {
                break;
            }
            /** @var DelayedStalenessHandler $handler */
            unset($this->staleHandlers[$handler]);
            $handler->triggerStale();
        }
    }
}

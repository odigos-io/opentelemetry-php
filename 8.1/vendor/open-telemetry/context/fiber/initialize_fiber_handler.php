<?php

declare (strict_types=1);
namespace OpenTelemetry\Context;

if (\OpenTelemetry\Context\ZendObserverFiber::isEnabled()) {
    \OpenTelemetry\Context\ZendObserverFiber::init();
}

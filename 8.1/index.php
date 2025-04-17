<?php

namespace Odigos\OpenTelemetry;

require dirname(__DIR__) . '/8.1/vendor/autoload.php';

printf('The PHP extension "opentelemetry" is available, version %s', phpversion('opentelemetry'));

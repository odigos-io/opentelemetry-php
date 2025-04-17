<?php

require dirname(__DIR__) . '/8.1/vendor/autoload.php';
// The versioned path is for Odigos auto-instrumentation (Odiglet)
// If you need to use this in your own code, you can use the following line instead:
// require 'vendor/autoload.php';

printf('The PHP extension "opentelemetry" is available, version %s', phpversion('opentelemetry'));

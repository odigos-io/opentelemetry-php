<?php

declare(strict_types=1);

/**
 * Odigos PHP agent bootstrap.
 *
 * Loaded via auto_prepend_file. First loads Composer autoload (community
 * auto-instrumentation packages), then registers Odigos custom instrumentation
 * hooks from ODIGOS_AGENT_CUSTOM_INSTRUMENTATIONS.
 */

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/CustomInstrumentation.php';

\Odigos\CustomInstrumentation\Registrar::register();

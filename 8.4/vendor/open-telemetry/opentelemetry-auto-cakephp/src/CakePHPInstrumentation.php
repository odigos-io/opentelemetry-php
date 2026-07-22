<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\CakePHP;

use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use Odigos\OpenTelemetry\Contrib\Instrumentation\CakePHP\Hooks\Cake\Command\Command;
use Odigos\OpenTelemetry\Contrib\Instrumentation\CakePHP\Hooks\Cake\Controller\Controller;
use Odigos\OpenTelemetry\Contrib\Instrumentation\CakePHP\Hooks\Cake\Http\Server;
class CakePHPInstrumentation
{
    public const NAME = 'cakephp';
    public static function register(): void
    {
        $instrumentation = new CachedInstrumentation('io.opentelemetry.contrib.php.cakephp', null, 'https://opentelemetry.io/schemas/1.32.0');
        Server::hook($instrumentation);
        Controller::hook($instrumentation);
        Command::hook($instrumentation);
    }
}

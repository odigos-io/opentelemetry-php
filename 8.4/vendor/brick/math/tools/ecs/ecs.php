<?php

declare (strict_types=1);
namespace Odigos;

use Odigos\PhpCsFixer\Fixer\ClassNotation\OrderedTypesFixer;
use Odigos\PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use Odigos\SlevomatCodingStandard\Sniffs\Whitespaces\DuplicateSpacesSniff;
use Odigos\Symplify\EasyCodingStandard\Config\ECSConfig;
return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import(__DIR__ . '/vendor/brick/coding-standard/ecs.php');
    $libRootPath = \realpath(__DIR__ . '/../..');
    $ecsConfig->paths([$libRootPath . '/src', $libRootPath . '/tests', $libRootPath . '/phpunit.php', $libRootPath . '/random-tests.php', __FILE__]);
    $ecsConfig->skip([
        // Allows alignment in test providers
        DuplicateSpacesSniff::class => [$libRootPath . '/tests'],
        // We want to keep BigNumber|int|float|string order
        OrderedTypesFixer::class => null,
        PhpdocTypesOrderFixer::class => null,
    ]);
};

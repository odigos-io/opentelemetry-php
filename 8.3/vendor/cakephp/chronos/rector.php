<?php

declare (strict_types=1);
namespace Odigos;

use Odigos\Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Odigos\Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Odigos\Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Odigos\Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Odigos\Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Odigos\Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Odigos\Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Odigos\Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Odigos\Rector\Config\RectorConfig;
use Odigos\Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Odigos\Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Odigos\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Odigos\Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Odigos\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Odigos\Rector\Php80\Rector\Class_\StringableForToStringRector;
use Odigos\Rector\Set\ValueObject\SetList;
use Odigos\Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Odigos\Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector;
use Odigos\Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictFluentReturnRector;
use Odigos\Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Odigos\Rector\TypeDeclaration\Rector\Function_\AddFunctionVoidReturnTypeWhereNoReturnRector;
$cacheDir = \getenv('RECTOR_CACHE_DIR') ?: \sys_get_temp_dir() . \DIRECTORY_SEPARATOR . 'rector';
return RectorConfig::configure()->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])->withCache(cacheClass: FileCacheStorage::class, cacheDirectory: $cacheDir)->withPhpSets()->withAttributesSets()->withSets([SetList::CODE_QUALITY, SetList::CODING_STYLE, SetList::DEAD_CODE, SetList::EARLY_RETURN, SetList::INSTANCEOF, SetList::TYPE_DECLARATION])->withSkip([ClassPropertyAssignToConstructorPromotionRector::class, CatchExceptionNameMatchingTypeRector::class, ClosureToArrowFunctionRector::class, RemoveUselessReturnTagRector::class, ReturnTypeFromStrictFluentReturnRector::class, NewlineAfterStatementRector::class, StringClassNameToClassConstantRector::class, ReturnTypeFromStrictTypedCallRector::class, ParamTypeByMethodCallTypeRector::class, AddFunctionVoidReturnTypeWhereNoReturnRector::class]);

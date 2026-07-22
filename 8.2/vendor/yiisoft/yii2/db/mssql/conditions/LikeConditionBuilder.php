<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
namespace Odigos\yii\db\mssql\conditions;

/**
 * {@inheritdoc}
 */
class LikeConditionBuilder extends \Odigos\yii\db\conditions\LikeConditionBuilder
{
    /**
     * {@inheritdoc}
     */
    protected $escapingReplacements = ['%' => '[%]', '_' => '[_]', '[' => '[[]', ']' => '[]]', '\\' => '[\]'];
}

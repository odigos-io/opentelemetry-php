<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
namespace Odigos\yii\db\cubrid\conditions;

/**
 * {@inheritdoc}
 */
class LikeConditionBuilder extends \Odigos\yii\db\conditions\LikeConditionBuilder
{
    /**
     * {@inheritdoc}
     */
    protected $escapeCharacter = '!';
    /**
     * `\` is initialized in [[buildLikeCondition()]] method since
     * we need to choose replacement value based on [[\yii\db\Schema::quoteValue()]].
     * {@inheritdoc}
     */
    protected $escapingReplacements = ['%' => '!%', '_' => '!_', '!' => '!!'];
}

<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
namespace Odigos\yii\db\mysql;

use Odigos\yii\db\ExpressionBuilderInterface;
use Odigos\yii\db\ExpressionBuilderTrait;
use Odigos\yii\db\ExpressionInterface;
use Odigos\yii\db\JsonExpression;
use Odigos\yii\db\Query;
use Odigos\yii\helpers\Json;
/**
 * Class JsonExpressionBuilder builds [[JsonExpression]] for MySQL DBMS.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since 2.0.14
 */
class JsonExpressionBuilder implements ExpressionBuilderInterface
{
    use ExpressionBuilderTrait;
    public const PARAM_PREFIX = ':qp';
    /**
     * {@inheritdoc}
     * @param JsonExpression|ExpressionInterface $expression the expression to be built
     */
    public function build(ExpressionInterface $expression, array &$params = [])
    {
        $value = $expression->getValue();
        if ($value instanceof Query) {
            list($sql, $params) = $this->queryBuilder->build($value, $params);
            return "({$sql})";
        }
        $placeholder = static::PARAM_PREFIX . count($params);
        $params[$placeholder] = Json::encode($value);
        return $placeholder;
    }
}

<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
namespace Odigos\yii\db;

use Odigos\yii\base\Event;
/**
 * AfterSaveEvent represents the information available in [[ActiveRecord::EVENT_AFTER_INSERT]] and [[ActiveRecord::EVENT_AFTER_UPDATE]].
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @since 2.0
 */
class AfterSaveEvent extends Event
{
    /**
     * @var array The attribute values that had changed and were saved.
     */
    public $changedAttributes;
}

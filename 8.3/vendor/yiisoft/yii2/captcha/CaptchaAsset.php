<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
namespace Odigos\yii\captcha;

use Odigos\yii\web\AssetBundle;
/**
 * This asset bundle provides the javascript files needed for the [[Captcha]] widget.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CaptchaAsset extends AssetBundle
{
    public $sourcePath = '@yii/assets';
    public $js = ['yii.captcha.js'];
    public $depends = ['Odigos\yii\web\YiiAsset'];
}

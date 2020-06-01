<?php

declare(strict_types=1);

namespace vsevolodryzhov\yii2ArControl\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ChosenAsset extends AssetBundle
{
    public $sourcePath = '@vendor/harvesthq/chosen';

    public $js = [
        YII_DEBUG ? 'chosen.jquery.js' : 'chosen.jquery.min.js'
    ];

    public $css = [
        YII_DEBUG ? 'chosen.css' : 'chosen.min.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

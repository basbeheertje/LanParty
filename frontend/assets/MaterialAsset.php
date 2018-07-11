<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Material frontend application asset bundle.
 */
class MaterialAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/materialsite.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'macgyer\yii2materializecss\assets\MaterializeAsset',
    ];
}

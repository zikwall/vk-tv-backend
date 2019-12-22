<?php

namespace zikwall\vktv\bundles;

use yii\web\AssetBundle;

class OpenPlayerBundle extends AssetBundle
{
    public $sourcePath = '@vktv/assets/openplayer/dist';
    public $css = [
        'openplayer.min.css'
    ];
    public $js = [
        'openplayer.min.js',
    ];
}

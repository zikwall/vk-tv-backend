<?php

namespace zikwall\vktv\bundles;

use yii\web\AssetBundle;

class PlyrBundle extends AssetBundle
{
    public $sourcePath = '@vktv/assets/plyr/dist';
    public $css = [
        'openplayer.min.css'
    ];
    public $js = [
        'openplayer.min.js',
    ];
}

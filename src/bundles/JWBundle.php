<?php

namespace zikwall\vktv\bundles;

use yii\web\AssetBundle;

class JWBundle extends AssetBundle
{
    public $sourcePath = '@vktv/assets/jw';
    public $js = [
        'jw.js',
        'jwplayer.core.js',
        'jwplayer.controls.js',
        'jwplayer.core.controls.html5.js',
        'jwplayer.core.controls.js',
        //'jwplayer.core.controls.polyfills.html5.js',
        //'jwplayer.core.controls.polyfills.js',
        //'jwplayer.vr.js',
        //'provider.airplay.js',
        'provider.hlsjs.js',
        'ad/googima.js',
        'ad/vast.js',
    ];
}

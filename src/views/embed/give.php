<style>
    /**
        Fix for Android outline orange border
     */
    * {
        -webkit-tap-highlight-color: transparent!important;
        -webkit-appearance:none!important;
        outline: none; /* <-- is fix */
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }

    /**
        Styling Player
     */
    [id="jw"].jw-error {
        background:#fff!important;
        overflow:hidden;
        position:relative

    }
    [id="jw"] .jw-error-msg{
        top:50%;
        left:50%;
        position:absolute;
        transform:translate(-50%,-50%)

    }
    [id="jw"] .jw-error-text{
        text-align:start;
        color:#FFF;
        font:14px/1.35 Arial,Helvetica,sans-serif

    }
</style>
<div id="jw"></div>

<?php
$ad = $embed['ad_url'];
$embed = $embed['url'];

$JW = <<<JS
    let AD_URL = "$ad";
    
    if (!AD_URL) {
        AD_URL = "";
    }
    
    const random = (min, max) => {
        let rand = min - 0.5 + Math.random() * (max - min + 1);
        return Math.round(rand);
    };
    
    AD_URL = AD_URL.replace('{random}', random(1, 4294967295), 'g');
    
    const player = jwplayer('jw');
    player.setup({
        file: '$embed',
        image: 'http://tv.zikwall.ru/web/images/backgrounds/fantasy.jpg',
        autostart: true,
        mute: false,
        advertising: {
            client: 'vast',
            tag: AD_URL
        }
    });
    
    player.on('pause', (event) => {
        console.log(event);
        window.ReactNativeWebView.postMessage(event);
    });
JS;

$this->registerJs($JW, yii\web\View::POS_END);


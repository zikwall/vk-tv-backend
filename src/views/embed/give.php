<div id="jw"></div>

<?php
$embed = $embed['url'];

$JW = <<<JS
    const player = jwplayer('jw');
    
    player.setup({
        file: '$embed',
        image: 'https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg',
        autostart: true,
        mute: true,
    });
    
    player.on('pause', (event) => {
        console.log(event);
        window.ReactNativeWebView.postMessage(event);
    });
JS;

$this->registerJs($JW, yii\web\View::POS_END);


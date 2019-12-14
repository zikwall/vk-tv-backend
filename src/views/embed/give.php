<div id="jw"></div>

<?php
$embed = $embed['url'];

$JW = <<<JS
    const random = (min, max) => {
        let rand = min - 0.5 + Math.random() * (max - min + 1);
        return Math.round(rand);
    };
    
    let adUrl = 'https://an.yandex.ru/meta/347075?imp-id=2&charset=UTF-8&target-ref=http%3A%2F%2Flimehd.ru&page-ref=http%3A%2F%2Flimehd.ru&rnd={random}';
    adUrl = adUrl.replace('{random}', random(1, 4294967295), 'g');

    const player = jwplayer('jw');
    
    player.setup({
        file: '$embed',
        image: 'https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg',
        autostart: true,
        mute: true,
        advertising: {
            client: 'vast',
            tag: adUrl
        }
    });
    
    player.on('pause', (event) => {
        console.log(event);
        window.ReactNativeWebView.postMessage(event);
    });
JS;

$this->registerJs($JW, yii\web\View::POS_END);


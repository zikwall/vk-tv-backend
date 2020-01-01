<div id="jw"></div>

<?php
$embed = $embed['url'];

$JW = <<<JS
    const arr_rand = (arr) => {
        let rand = arr[Math.floor(Math.random() * arr.length)];

        return rand;
    };
    
    const random = (min, max) => {
        let rand = min - 0.5 + Math.random() * (max - min + 1);
        return Math.round(rand);
    };
    
    // надо определить какая реклама глючит!
    let adUrls = [
        'https://an.yandex.ru/meta/347075?imp-id=2&charset=UTF-8&target-ref=http%3A%2F%2Flimehd.ru&page-ref=http%3A%2F%2Flimehd.ru&rnd={random}',
        'https://out.pladform.ru/getVast?pl=116720&type=preroll&license=1&thematic=1762&age=5&duration=0&target=mobile&adformat=3&dl=https://limehd.tv',
        'https://px.adhigh.net/p/direct_vast?pid=172&tid=instream_spbtv',
        'https://out.pladform.ru/getVast?pl=116722&type=preroll&license=1&thematic=1762&age=4&duration=0&target=mobile&adformat=3&dl=https://limehd.tv',
        'https://an.yandex.ru/meta/290606?imp-id=2&charset=UTF-8&target-ref=http%3A%2F%2Flimehd.ru&page-ref=http%3A%2F%2Flimehd.ru&rnd={random}',
        'https://data.videonow.ru/?profile_id=2458118&format=vast&container=preroll'
    ];
    
    adUrl = arr_rand(adUrls);
    adUrl = adUrl.replace('{random}', random(1, 4294967295), 'g');

    console.log(adUrl);

    const player = jwplayer('jw');
    
    player.setup({
        file: '$embed',
        image: 'http://tv.zikwall.ru/web/images/backgrounds/fantasy.jpg',
        autostart: true,
        mute: false,
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


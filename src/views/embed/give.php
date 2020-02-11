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
        //advertising: {
            //client: 'vast',
            //tag: 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/single_ad_samples&ciu_szs=300x250&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&cust_params=deployment%3Ddevsite%26sample_ct%3Dlinearvpaid2js&correlator='
        //}
    });
    
    player.on('pause', (event) => {
        console.log(event);
        window.ReactNativeWebView.postMessage(event);
    });
JS;

$this->registerJs($JW, yii\web\View::POS_END);


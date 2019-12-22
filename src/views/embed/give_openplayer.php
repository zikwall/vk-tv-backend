<video class="op-player__media" id="video" autoplay controls playsinline>
    <source src="<?= $embed['url']; ?>">
</video>

<?php
$JW = <<<JS
    const random = (min, max) => {
        let rand = min - 0.5 + Math.random() * (max - min + 1);
        return Math.round(rand);
    };
    
    let adUrls = [
        'https://an.yandex.ru/meta/347075?imp-id=2&charset=UTF-8&target-ref=http%3A%2F%2Flimehd.ru&page-ref=http%3A%2F%2Flimehd.ru&rnd={random}',
        'https://out.pladform.ru/getVast?pl=116720&type=preroll&license=1&thematic=1762&age=5&duration=0&target=mobile&adformat=3&dl=https://limehd.tv',
        'https://px.adhigh.net/p/direct_vast?pid=172&tid=instream_spbtv',
        'https://out.pladform.ru/getVast?pl=116722&type=preroll&license=1&thematic=1762&age=4&duration=0&target=mobile&adformat=3&dl=https://limehd.tv',
        'https://an.yandex.ru/meta/290606?imp-id=2&charset=UTF-8&target-ref=http%3A%2F%2Flimehd.ru&page-ref=http%3A%2F%2Flimehd.ru&rnd={random}',
        'https://data.videonow.ru/?profile_id=2458118&format=vast&container=preroll'
    ];
    
    const getAdArray = () => {
        adArr = [];
        
        for (let ad in adUrls) {
            adUrl = adUrls[ad];
            
            adUrl = adUrl.replace('{random}', random(1, 4294967295), 'g');
            adArr.push(adUrl);
        }
        
        return adArr;
    };
    
    const ads = getAdArray();

const player = new OpenPlayer('video', ads, false, {
    hls: {
        startLevel: -1,
        enableWorker: true,
        widevineLicenseUrl: 'https://cwip-shaka-proxy.appspot.com/no_auth',
        emeEnabled: true,
     }
});

player.init();

JS;

$this->registerJs($JW, yii\web\View::POS_END);

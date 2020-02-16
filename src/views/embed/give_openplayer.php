<video class="op-player__media" id="video" autoplay controls playsinline>
    <source src="<?= $embed['url']; ?>">
</video>

<?php
$AD = $embed['ad_url'];

$JW = <<<JS
const random = (min, max) => {
    let rand = min - 0.5 + Math.random() * (max - min + 1);
    return Math.round(rand);
};

let AD_URL = '$AD';
AD_URL = AD_URL.replace('{random}', random(1, 4294967295), 'g');

const player = new OpenPlayer('video', AD_URL, false, {
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

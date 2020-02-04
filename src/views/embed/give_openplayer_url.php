<video class="op-player__media" id="video" autoplay controls playsinline>
    <source src="<?= $url; ?>">
</video>

<?php
$JW = <<<JS

const player = new OpenPlayer('video', [], false, {
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

<div id="jw"></div>

<?php

$JW = <<<JS
    jwplayer("jw").setup({
        file: 'https://83tpjqlujs1.a.trbcdn.net/livemaster/tftrm1v2h9_stream1/playlist.m3u8',
        image: 'https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg',
        autostart: true,
        mute: true
    });
JS;

$this->registerJs($JW, ['position' => \yii\web\View::POS_END]);


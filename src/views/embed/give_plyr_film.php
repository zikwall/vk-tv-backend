
<?php
$JW = <<<JS

const player = new Plyr('video', {
    captions: {
        active: true
    }, 
    ads: {
        enabled: true, 
        tagUrl: 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/single_ad_samples&ciu_szs=300x250&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&cust_params=deployment%3Ddevsite%26sample_ct%3Dskippablelinear&correlator='
    }
});
JS;

$this->registerJs($JW, yii\web\View::POS_END);
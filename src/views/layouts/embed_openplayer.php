<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $content string */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/web/static/openplayer.css">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body style="margin:0;padding:0;">
<?php $this->beginBody() ?>
<?= $content ?>
<script src="/web/static/openplayer.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

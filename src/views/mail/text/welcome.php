<?php

/**
 * @var $user \vktv\models\User
 * @var $token \zikwall\vktv\models\Token
 * @var $module \zikwall\vktv\Module
 */
?>
<?= 'Hello' ?>,

<?= "Your account on {" . Yii::$app->name . "} has been created" ?>.
<?php if ($module->enableGeneratingPassword): ?>
    <?= 'We have generated a password for you' ?>:
    <?= $user->password ?>
<?php endif ?>

<?php if ($token !== null): ?>
    <?= 'In order to complete your registration, please click the link below' ?>.

    <?= $token->url ?>

    <?= 'If you cannot click the link, please try pasting the text into your browser' ?>.
<?php endif ?>

<?= 'If you did not make this request you can ignore this email' ?>.

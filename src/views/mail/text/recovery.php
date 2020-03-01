<?php

/**
 * @var \vktv\models\User   $user
 * @var \zikwall\vktv\models\Token  $token
 */
?>
<?= sprintf('Hello %s', $user->username) ?>,

<?= 'We have received a request to reset the password for your account on PlayHub' ?>.
<?= 'Please click the link below to complete your password reset' ?>.

<?= $token->url ?>

<?= 'If you cannot click the link, please try pasting the text into your browser' ?>.

<?= 'If you did not make this request you can ignore this email' ?>.

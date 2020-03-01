<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \zikwall\vktv\models\forms\RecoveryForm $model
 */

$this->title = 'Reset your password';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .center-login {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    .ui_block {
        position: relative;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        margin: 0px 0 15px;
    }
    .ui_block_body {
        padding: 15px 20px;
    }
    .login_fast_restore_wrap, .login_form_wrap {
        margin: 0 auto;
        width: 270px;
    }
    .login_fast_restore_wrap input.big_text, .login_form_wrap input.big_text {
        margin-bottom: 15px;
        width: 270px;
    }
    input.big_text {
        height: 35px;
        border-radius: 3px;
    }
    input.big_text, input.big_text~.placeholder .ph_input {
        font-size: 14px;
        padding: 6px 12px 8px;
        box-sizing: border-box;
    }
    .fakeinput, .fakeinput~.placeholder .ph_input, div[contenteditable=true], div[contenteditable=true]~.placeholder .ph_input, input.big_text, input.big_text~.placeholder .ph_input, input.dark, input.dark~.placeholder .ph_input, input.search, input.search~.placeholder .ph_input, input.text, input.text~.placeholder .ph_input, textarea, textarea~.placeholder .ph_input {
        color: #000;
        padding: 3px 5px;
        margin: 0;
        border: 1px solid #d3d9de;
    }
    .login_buttons_wrap {
        margin-top: 20px;
    }
    .button_big_text.flat_button {
        font-size: 14px;
        line-height: 20px;
        border-radius: 3px;
    }
    .login_button {
        width: 105px;
    }
    .button_blue button, .button_gray button, .button_light_gray button, .flat_button {
        padding: 7px 16px 8px;
        margin: 0;
        font-size: 12.5px;
        display: inline-block;
        zoom: 1;
        cursor: pointer;
        white-space: nowrap;
        outline: none;
        font-family: -apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Geneva,Noto Sans Armenian,Noto Sans Bengali,Noto Sans Cherokee,Noto Sans Devanagari,Noto Sans Ethiopic,Noto Sans Georgian,Noto Sans Hebrew,Noto Sans Kannada,Noto Sans Khmer,Noto Sans Lao,Noto Sans Osmanya,Noto Sans Tamil,Noto Sans Telugu,Noto Sans Thai,sans-serif;
        vertical-align: top;
        line-height: 15px;
        text-align: center;
        text-decoration: none;
        background: none;
        background-color: #5181b8;
        color: #fff;
        border: 0;
        border-radius: 4px;
        box-sizing: border-box;
    }
</style>

<section class="login_page center-login" style="max-width:980px">
    <div class="music-img-box-cont-sm">
        <div class="ui_block">
            <div class="ui_block_body">
                <div style="margin-top:10px"></div>
                <div class="login_form_wrap">
                    <?php $form = ActiveForm::begin([
                        'id' => 'password-recovery-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                    ]); ?>
                    <?= $form->field($model, 'password')->passwordInput(['class' => 'big_text']) ?>
                    <div class="login_buttons_wrap">
                        <?= Html::submitButton('Finish', ['class' => 'flat_button button_big_text login_button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="login_fast_restore_wrap _retore_wrap">
                    <a class="login_link login_fast_restore_link" href="#">Забыли пароль или не можете войти?</a>
                </div>
            </div>
        </div>
    </div>
</section>




<?php

namespace vktv\models\forms;

use vktv\helpers\Password;
use vktv\models\User;
use Yii;
use yii\base\Model;
use zikwall\vktv\ModuleTrait;

class LoginForm extends Model
{
    use ModuleTrait;

    /**
     * @var string User's email or username
     */
    public $username;
    /**
     * @var string User's plain password
     */
    public $password;
    /**
     * @var string Whether to remember the user
     */
    public $rememberMe = false;
    /**
     * @var User
     */
    protected $user;

    public function attributeLabels()
    {
        return [
            'username'   => 'Login',
            'password'   => 'Password',
            'rememberMe' => 'Remember me next time',
        ];
    }

    public function rules()
    {
        return [
            'requiredFields' => [['username', 'password'], 'required'],
            'loginTrim' => ['username', 'trim'],
            'passwordValidate' => [
                'password',
                function ($attribute) {
                    if ($this->user === null || !Password::validate($this->password, $this->user->password_hash)) {
                        $this->addError($attribute, 'Invalid login or password');
                    }
                }
            ],
            'confirmationValidate' => [
                'username',
                function ($attribute) {
                    if ($this->user !== null) {
                        //$confirmationRequired = $this->getModule()->enableConfirmation && !$this->getModule()->enableUnconfirmedLogin;
                        /*if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                            $this->addError($attribute, 'You need to confirm your email address');
                        }
                        if ($this->user->getIsBlocked()) {
                            $this->addError($attribute, 'Your account has been blocked');
                        }*/
                    }
                }
            ],
            'rememberMe' => ['rememberMe', 'boolean'],
        ];
    }

    public function getUser()
    {
        return $this->user;
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->getUser()->login($this->user, $this->rememberMe ? $this->getModule()->rememberFor : 0);
        } else {
            return false;
        }
    }

    public function formName()
    {
        return 'login-form';
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->user = User::find()->findUserByUsernameOrEmail(trim($this->username));
            return true;
        } else {
            return false;
        }
    }

    public function afterValidate()
    {
        $this->password = "";
        return parent::afterValidate();
    }
}

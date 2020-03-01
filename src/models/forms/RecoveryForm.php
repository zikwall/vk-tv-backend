<?php

namespace zikwall\vktv\models\forms;

use vktv\models\User;
use zikwall\vktv\constants\Auth;
use zikwall\vktv\models\Token;
use zikwall\vktv\ModuleTrait;
use yii\base\Model;

class RecoveryForm extends Model
{
    use ModuleTrait;

    const SCENARIO_REQUEST = 'request';
    const SCENARIO_RESET = 'reset';

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'    => 'Email',
            'password' => 'Password',
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_REQUEST => ['email'],
            self::SCENARIO_RESET => ['password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'emailTrim' => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'passwordRequired' => ['password', 'required'],
            'passwordLength' => ['password', 'string', 'max' => 72, 'min' => 6],
            ['password', 'match', 'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', 'message' => Auth::ERROR_INVALID_PASSWORD['message']],
        ];
    }

    /**
     * Sends recovery message.
     *
     * @return bool
     */
    public function sendRecoveryMessage()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::find()->findUserByEmail($this->email);

        if ($user instanceof User) {
            /** @var Token $token */
            $token = \Yii::createObject([
                'class' => Token::class,
                'user_id' => $user->id,
                'type' => Token::TYPE_RECOVERY,
            ]);

            if (!$token->save(false)) {
                return false;
            }

            if (!$this->getModule()->getMailer()->sendRecoveryMessage($user, $token)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Resets user's password.
     *
     * @param Token $token
     *
     * @return bool
     */
    public function resetPassword(Token $token)
    {
        if (!$this->validate() || $token->user === null) {
            return false;
        }

        if ($token->user->resetPassword($this->password)) {
            $token->delete();

            return true;
        } else {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'recovery-form';
    }
}

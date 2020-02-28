<?php


namespace zikwall\vktv\controllers;

use vktv\helpers\AttributesValidator;
use vktv\helpers\Password;
use vktv\models\Friendship;
use vktv\models\User;
use Yii;
use vktv\models\forms\LoginForm;
use Firebase\JWT\JWT;
use yii\web\Response;
use yii\web\IdentityInterface;
use zikwall\vktv\helpers\Image;
use zikwall\vktv\ModuleTrait;
use zikwall\vktv\constants\Auth;

class AuthController extends BaseController
{
    use ModuleTrait;

    public function actionContinueSignup()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $post  = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $name       = $post['name'];
        $publiEmail = $post['publicEmail'];
        $avatar     = $post['avatar'];
        //$token      = $post['token'];

        file_put_contents(Yii::getAlias('@app/runtime') . '/test_photo.log', print_r([$post, $_POST], true));

        Image::base64ToJPEG($avatar, Yii::getAlias('@app/runtime') . '/tmp.jpg');

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        if ($this->getUser()->isAlreadyConfirmed()) {
            return $this->response(Auth::MESSAGE_USER_ALREADY_CONFIRMED_SINGUP, 200);
        }

        if (!empty($publiEmail)) {
            if (!AttributesValidator::isValidEmail($publiEmail)) {
                return $this->response(Auth::ERROR_INVALID_EMAIL_ADRESS, 200);
            }
        }

        if (!empty($name)) {
            if (!AttributesValidator::isValidRealName($name)) {
                return $this->response(Auth::ERROR_INVALID_NAME, 200);
            }
        }

        if (!$this->getUser()->afterRegistrationHandle($name, $publiEmail)) {
            return $this->response(Auth::MESSAGE_USER_AFTER_REGISTRATION_FAILED, 200);
        }

        return $this->response([
            'code' => 200,
            'response' => [
                'message' => 'Successfully!',
                'user' => $this->getUserAttributes($this->getUser())
            ]
        ], 200);
    }

    public function actionForgot()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $post  = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $email = $post['email'];


        if (!AttributesValidator::isValidEmail($email)) {
            return $this->response(Auth::ERROR_INVALID_EMAIL_ADRESS, 200);
        }

        if (!User::findByEmail($email)) {
            return $this->response(Auth::ERROR_EMAIL_NOT_FOUND, 200);
        }

        return $this->response([
            'code' => 200,
            'response' => Auth::MESSAGE_SUCCESSUL_SEND_FORGOT_MESSAGE
        ], 200);
    }

    public function actionSignin()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $this->disableAuthorization();

        $post = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $user = static::authByUserAndPassword($post['username'], $post['password']);

        if ($user === null) {
            return $this->response(Auth::ERROR_WRONG_USERNAME_OR_PASSWORD, 200);
        }

        if ($user->isBlocked()) {
            return $this->response(Auth::MESSAGE_USER_IS_BLOCKED, 200);
        }

        if ($user->isDestroyed()) {
            return $this->response(Auth::MESSAGE_USER_IS_DESTROYED, 200);
        }

        $jwt = $this->jwt($user);

        return $this->response([
            'code' => 200,
            'token' => $jwt['token'],
            'token_expired' => $jwt['payload']['exp'],
            'user' => $this->getUserAttributes($user)
        ], 200);
    }

    public function actionSignup()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $this->disableAuthorization();

        $post = json_decode(Yii::$app->getRequest()->getRawBody(), true);

        $email    = $post['email'];
        $username = $post['username'];
        $password = $post['password'];
        $deivceId = $post['deviceId'];

        if (!AttributesValidator::isValidPassword($password)) {
            return $this->response(Auth::ERROR_INVALID_PASSWORD, 200);
        }

        if (!AttributesValidator::isValidEmail($email)) {
            return $this->response(Auth::ERROR_INVALID_EMAIL_ADRESS, 200);
        }

        if (!AttributesValidator::isValidUsername($username)) {
            return $this->response(Auth::ERROR_INVALID_USERNAME, 200);
        }

        if (User::findByEmail($email)) {
            return $this->response(Auth::ERROR_EMAIL_ALREADY_USE, 200);
        }

        if (User::findByUsername($username)) {
            return $this->response(Auth::ERROR_USERNAME_ALREADY_USE, 200);
        }

        // blacklists email
        // registration off

        /**
         * @var $user User
         */
        $user = Yii::createObject([
            'class'    => User::class,
            'scenario' => 'create',
            'email'    => $email,
            'username' => $username,
            'password' => $password,
            'first_device_id' => $deivceId
        ]);

        if ($user->register()) {
            $jwt = $this->jwt($user);

            return $this->response([
                'code' => 200,
                'token' => $jwt['token'],
                'token_expired' => $jwt['payload']['exp'],
                'user' => $this->getUserAttributes($user)
            ], 200);
        }

        return $this->response(Auth::ERROR_FAILED_REGISTRATION, 200);
    }

    public function actionSelfDestroy()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $post = json_decode(Yii::$app->getRequest()->getRawBody(), true);

        $username = $post['username'];
        $email    = $post['email'];
        $password = $post['password'];

        // auth with jwt AND

        $user = static::authByUserAndPassword($username, $password);

        if ($user === null) {
            return $this->response(Auth::ERROR_WRONG_USERNAME_OR_PASSWORD, 200);
        }

        if ($user->destroy()) {
            return $this->response(Auth::SUCCESS_DESTROYED_ACCOUNT, 200);
        }
    }

    public function actionLogout()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        if (Yii::$app->request->cookies->has('token')) {
            Yii::$app->request->cookies->remove('token');
        }

        return true;
    }

    final protected function jwt(IdentityInterface $user) : array
    {
        $payload = [
            'iss' => "yii-rest-jwt",
            'iat' => time(),
            'uid' => $user->getId(),
            'exp' => time()
        ];

        if (!empty($this->getModule()->jwtExpire)) {
            $payload['exp'] += $this->getModule()->jwtExpire;
        }

        return [
            'token' => JWT::encode($payload, $this->getModule()->jwtKey),
            'payload' => $payload
        ];
    }

    final public static function authByUserAndPassword(string $username, string $password)
    {
        /**
         * @var $login LoginForm
         */
        $login = Yii::createObject(LoginForm::class);

        if (!$login->load(['username' => $username, 'password' => $password], '') || !$login->validate()) {
            return null;
        }

        return $login->getUser();
    }

    public function getUserAttributes(User $user) : array
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'is_premium' => $user->is_premium && $user->premium_ttl > time(),
            'is_official' => $user->is_official,
            'profile' => [
                'name' => $user->profile->name,
                'public_email' => $user->profile->public_email,
                'avatar' => $user->profile->avatar
            ],
            'friends' => Friendship::getFriendsQuery($user)->asArray()->all()
        ];
    }
}

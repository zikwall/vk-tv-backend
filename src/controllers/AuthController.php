<?php


namespace zikwall\vktv\controllers;

use vktv\helpers\AttributesValidator;
use vktv\helpers\Password;
use vktv\models\User;
use Yii;
use vktv\models\forms\LoginForm;
use Firebase\JWT\JWT;
use yii\web\Response;
use yii\web\IdentityInterface;
use zikwall\vktv\ModuleTrait;
use zikwall\vktv\constants\Auth;

class AuthController extends BaseController
{
    use ModuleTrait;

    public function actionSignin()
    {
        if (Yii::$app->request->getIsOptions()) {
            return true;
        }

        $post = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $user = static::authByUserAndPassword($post['username'], $post['password']);

        if ($user === null) {
            return $this->response(Auth::ERROR_WRONG_USERNAME_OR_PASSWORD, 400);
        }

        if ($user->isBlocked()) {
            return $this->response(Auth::MESSAGE_USER_IS_BLOCKED, 400);
        }

        if ($user->isDestroyed()) {
            return $this->response(Auth::MESSAGE_USER_IS_DESTROYED, 400);
        }

        $jwt = $this->jwt($user);

        return $this->response([
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

        $post = json_decode(Yii::$app->getRequest()->getRawBody(), true);

        $email    = $post['email'];
        $username = $post['username'];
        $password = $post['password'];

        if (!AttributesValidator::isValidPassword($password)) {
            return $this->response(Auth::ERROR_INVALID_PASSWORD, 400);
        }

        if (!AttributesValidator::isValidEmail($email)) {
            return $this->response(Auth::ERROR_INVALID_EMAIL_ADRESS, 400);
        }
        
        if (!AttributesValidator::isValidUsername($username)) {
            return $this->response(Auth::ERROR_INVALID_USERNAME, 400);
        }

        if (User::findByEmail($email)) {
            return $this->response(Auth::ERROR_EMAIL_ALREADY_USE, 400);
        }

        if (User::findByUsername($username)) {
            return $this->response(Auth::ERROR_USERNAME_ALREADY_USE, 400);
        }

        // blacklists email
        // registration off

        $user = Yii::createObject([
            'class'    => User::class,
            'scenario' => 'create',
            'email'    => $email,
            'username' => $username,
            'password' => $password,
        ]);

        if ($user->register()) {
            $jwt = $this->jwt($user);

            return $this->response([
                'token' => $jwt['token'],
                'token_expired' => $jwt['payload']['exp'],
                'user' => $this->getUserAttributes($user)
            ], 200);
        }

        return $this->response(Auth::ERROR_FAILED_REGISTRATION, 400);
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
            return $this->response(Auth::ERROR_WRONG_USERNAME_OR_PASSWORD, 400);
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
            'profile' => [
                'name' => $user->profile->name,
                'public_email' => $user->profile->public_email
            ]
        ];
    }

    public function response(array $content, int $status) : Response
    {
        Yii::$app->response->statusCode = $status;
        return $this->asJson($content);
    }
}

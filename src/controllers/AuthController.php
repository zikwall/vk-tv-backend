<?php


namespace zikwall\vktv\controllers;

use Yii;
use vktv\models\forms\LoginForm;
use Firebase\JWT\JWT;
use yii\web\Response;
use yii\web\IdentityInterface;
use zikwall\vktv\ModuleTrait;

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
            return $this->response([
                'status' => 400,
                'message' => 'Wrong username or password'
            ], 400);
        }

        $jwt = $this->jwt($user);

        return $this->response([
            'token' => $jwt['token'],
            'token_expired' => date('Y-m-d H:i:s', $jwt['payload']['exp']),
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
                'profile' => [
                    'name' => $user->profile->name,
                    'public_email' => $user->profile->public_email
                ]
            ]
        ], 200);
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

    public function response(array $content, int $status) : Response
    {
        Yii::$app->response->statusCode = $status;
        return $this->asJson($content);
    }
}

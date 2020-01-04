<?php

namespace zikwall\vktv\controllers;

use vktv\models\User;
use Yii;
use Firebase\JWT\JWT;
use yii\web\HttpException;
use yii\web\IdentityInterface;
use yii\web\Response;
use zikwall\vktv\ModuleTrait;

class BaseController extends \yii\rest\Controller
{
    use ModuleTrait;

    public $user = null;

    public function beforeAction($action) : bool
    {
        Yii::$app->response->headers->set('Access-Control-Allow-Methods', ['POST', 'OPTIONS']);
        Yii::$app->response->headers->set('Access-Control-Allow-Headers', implode(', ', [
            "Accept", "Origin", "X-Auth-Token", "content-type",
            "Content-Type", "Authorization", "X-Requested-With",
            "Accept-Language", "Last-Event-ID", "Accept-Language",
            "Cookie", "Content-Length", "WWW-Authenticate", "X-XSRF-TOKEN",
            "withcredentials", "x-forwarded-for", "x-real-ip",
            "user-agent", "keep-alive", "host",
            "connection", "upgrade", "dnt", "if-modified-since", "cache-control",
            "x-compress"
        ]));

        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->set('Access-Control-Allow-Credentials', true);
        Yii::$app->response->headers->set('Access-Control-Max-Age', 86400);

        $user = $this->authWithJwt();

        if ($user === null && $this->getModule()->enableBasicAuth) {
            list($username, $password) = Yii::$app->request->getAuthCredentials();
            $user = AuthController::authByUserAndPassword($username, $password);
        }

        //if ($user === null) {
            //throw new HttpException('401', 'Invalid token!');
        //}

        //if ($this->isUserDisabled($user)) {
            //throw new HttpException('401', 'Invalid user!');
        //}

        /**
         * Disabled session for REST API ideology
         */
        if (Yii::$app->user->getIsGuest()) {
            // Yii::$app->user->login($user);
        }

        return parent::beforeAction($action);
    }

    public function init() : void
    {
        parent::init();
        $this->enableCsrfValidation = \false;
        $this->layout = \false;
    }

    final private function authWithJwt()
    {
        $authHeader = Yii::$app->request->getHeaders()->get('Authorization');

        if (!empty($authHeader) && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $token = $matches[1];

            try {
                $validData = JWT::decode($token, $this->getModule()->jwtKey, ['HS256']);
                if (!empty($validData->uid)) {
                    return $this->user = User::find()->where(['id' => $validData->uid])->one();
                }
            } catch (\Exception $e) {
                /*return [
                    'code' => 401,
                    'message' => 'User Unauthorized',
                    'exception' => $e->getMessage()
                ];*/
            }
        }

        return null;
    }

    public function response(array $content, int $status) : Response
    {
        Yii::$app->response->statusCode = $status;
        return $this->asJson($content);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function isUnauthtorized()
    {
        return $this->getUser() === null && !($this->getUser() instanceof IdentityInterface);
    }
}

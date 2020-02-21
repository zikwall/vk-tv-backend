<?php

namespace zikwall\vktv\controllers;

use vktv\helpers\AttributesValidator;
use yii\db\Query;
use zikwall\vktv\constants\Auth;
use zikwall\vktv\constants\Validation;
use zikwall\vktv\RequestTrait;

class PremiumController extends BaseController
{
    use RequestTrait;

    public function actionActivate()
    {
        if ($this->isRequestOptions()) {
            return true;
        }

        if ($this->isUnauthtorized()) {
            return $this->response(Auth::MESSAGE_IS_UNAUTHORIZED, 200);
        }

        $post = $this->getJSONBody();
        $validate = AttributesValidator::isEveryRequired($post, ['key']);

        if ($validate['state'] === false) {
            return $this->response(
                array_merge(Validation::NOT_REQUIRED_ATTRIBUTES, ['attributes' => $validate['missing']
                ]));
        }

        $key = (new Query())->from('premium_key')->where(['key' => $post['key']])->one();

        if (!$key) {
            return $this->response([
                'code' => 100,
                'message' => 'Такой код не найден!',
                'attributes' => [
                    'key'
                ]
            ]);
        }

        $countOfActivations = (new Query())->from('{{%user_premium}}')->count();

        if ((int) $key['activation_time_limit'] < time() || (int) $countOfActivations >= (int) $key['activation_count_limit']) {
            return $this->response([
                'code' => 100,
                'message' => 'Вы не можете активировать данный премиум, он уже все...',
                'attributes' => [
                    'key'
                ]
            ]);
        }

        $alredyActivated = (new Query())
            ->from('{{%user_premium}}')
            ->where(['and', ['user_id' => $this->getUser()->getId()], ['key_id' => $key['id']]])
            ->count();

        if ((int) $alredyActivated === 1) {
            return $this->response([
                'code' => 100,
                'message' => 'Вы уже активировали данный премиум.',
                'attributes' => [
                    'key'
                ]
            ]);
        }

        if ($this->getUser()->makePremium($key)) {
            return $this->response([
                'code' => 200,
                'response' => [
                    'message' => "Успешно активирован премиум до " . date('d-m-Y H:i', $key['expired']),
                    'user' => [
                        'is_premium' => $this->getUser()->is_premium && $this->getUser()->premium_ttl > time(),
                    ]
                ]
            ]);
        }

        return $this->response([
            'code' => 100,
            'message' => 'Не удалось активировать проемиум, нам жаль...'
        ]);
    }
}

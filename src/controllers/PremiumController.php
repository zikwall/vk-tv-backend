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
                ]), 200);
        }
        
        $key = (new Query())->from('premium_key')->where(['key' => $post['key']])->one();
        
        if (!$key) {
            return $this->response([
                'code' => 100,
                'message' => 'Такой код не найден!',
                'attributes' => [
                    'key'
                ]
            ], 200);
        }
        
        if ($this->getUser()->makePremium($key['expired'])) {
            return $this->response([
                'code' => 200,
                'message' => "Успешно активирован премиум до " . date('d-m-Y H:i', $key['expired'])
            ], 200);
        }
        
        return $this->response([
            'code' => 100,
            'message' => 'Не удалось активировать проемиум, нам жаль...'
        ], 200);
    }
}

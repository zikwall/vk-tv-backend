<?php

namespace zikwall\vktv\controllers;

class CommonController extends BaseController
{
    public function actionSocials()
    {
        return $this->response([
            'code' => 200,
            'socials' => [
                'telegram' => 'https://t.me/playhub_community',
                'vk' => '',
            ]
        ]);
    }
}

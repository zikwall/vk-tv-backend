<?php

namespace zikwall\vktv;

use Yii;

trait RequestTrait
{
    public function getJSONBody(\Closure $sinitizeCallback = null) : array
    {
        $bodyRawArray = json_decode(Yii::$app->getRequest()->getRawBody(), true);

        if ($sinitizeCallback !== null && $sinitizeCallback instanceof \Closure) {
            return $sinitizeCallback($bodyRawArray);
        }

        return $bodyRawArray;
    }
    
    public function isRequestOptions() : bool 
    {
        return Yii::$app->request->getIsOptions();
    }
}
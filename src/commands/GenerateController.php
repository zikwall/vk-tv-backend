<?php

namespace zikwall\vktv\commands;

use yii\console\Controller;
use zikwall\m3uparse\Aggregation;
use zikwall\m3uparse\Configure;
use zikwall\m3uparse\parsers\{
    Free,
    FreeBestTv
};

class GenerateController extends Controller
{
    public $message;

    public function options($actionID)
    {
        return ['message'];
    }

    public function optionAliases()
    {
        return ['m' => 'message'];
    }

    public function actionIndex()
    {
        $agg = new Aggregation(new Configure('', '/web/uploads/playlists', '', '/web/channels/'));

        print_r(
            $agg->merge(new Free(), new FreeBestTv())
        );
    }
}
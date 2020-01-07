<?php

namespace zikwall\vktv\commands;

use vktv\helpers\Category;
use vktv\helpers\PlaylistHelper;
use vktv\models\Epg;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use zikwall\m3uparse\Aggregation;

use zikwall\m3uparse\Configuration;
use zikwall\m3uparse\epgmodule\EPGAgregation;
use zikwall\m3uparse\parsers\{
    free\Free,
    freebesttv\FreeBestTv,
    vasiliy78L\Base,
    forever\Forever
};

use zikwall\m3uparse\epgmodule\{
    epgsources\xmltv\XMLTV
};

use vktv\models\Playlist;

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
        $agg = new Aggregation(new Configuration());
        $playlist = $agg->merge(new Base(), new Forever(), new FreeBestTv());

        if (empty($playlist)) {
            return;
        }

        Playlist::deleteAll();

        $sanitizedPlaylist = [];
        foreach ($playlist as $pl) {
            $sanitizedPlaylist[] = [
                'epg_id'        => $pl['epg_id'],
                'name'          => $pl['name'],
                'url'           => $pl['url'],
                'ssl'           => $pl['ssl'],
                'image'         => $pl['image'] ? PlaylistHelper::createImage($pl['image']) : null,
                'use_origin'    => $pl['use_origin'],
                'xmltv_id'      => $pl['xmltv_id'],
                'category'      => $pl['category'] ?? Category::getDefaultCategory()
            ];
        }

        Yii::$app->db->createCommand()->batchInsert('{{%playlist}}',
            ['epg_id', 'name', 'url', 'ssl', 'image', 'use_origin', 'xmltv_id', 'category'],
            $sanitizedPlaylist
        )->execute();
    }

    public function actionEpgXmltv()
    {
        // TODO delete only XMLTV
        Epg::deleteAll(['>', 'day_begin', strtotime('+5 day')]);

        $channels = ArrayHelper::getColumn(
            Playlist::find()->select(['xmltv_id'])->where(['is not', 'xmltv_id', null])->asArray()->all(),
            'xmltv_id'
        );

        $aggEPG = new EPGAgregation(new Configuration());
        $epgs = $aggEPG->merge($channels, new XMLTV());

        foreach ($epgs as $epg) {
            foreach ($epg as $programs) {

                $sanitizedEpg = [];
                foreach ($programs as $program) {
                    unset($program['day_begin_human']);

                    $sanitizedEpg[] = [
                        'day_begin' => $program['day_begin'],
                        'tz'        => $program['tz'],
                        'start'     => $program['start'],
                        'stop'      => $program['stop'],
                        'title'     => $program['title'],
                        'desc'      => $program['desc'],
                        'epg_id'    => $program['id']
                    ];
                }

                Yii::$app->db->createCommand()->batchInsert('{{%epg}}',
                    ['day_begin', 'tz', 'start', 'stop', 'title', 'desc', 'epg_id'],
                    $sanitizedEpg
                )->execute();
            }
        }
    }
}

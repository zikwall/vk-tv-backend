<?php

namespace vktv\services;

use vktv\helpers\AttributesValidator;
use vktv\models\Content;
use vktv\models\Playlist;
use yii\db\Query;
use yii\web\IdentityInterface;

class ContentService
{
    public static function saveWithActiveRecord(Content $content, array $contentAttributes, IdentityInterface $user)
    {
        $content->user_id               = $user->getId();
        $content->name                  = $contentAttributes['name'];
        $content->url                   = $contentAttributes['url'];
        $content->type                  = $contentAttributes['type'];
        $content->category              = $contentAttributes['category'];
        $content->image                 = $contentAttributes['image_url'];
        $content->desc                  = $contentAttributes['desc'];
        $content->use_own_player_url    = (int) $contentAttributes['use_own_player'];
        $content->own_player_url        = $contentAttributes['own_player_url'];
        $content->age_limit             = (int) $contentAttributes['is_18_years_old'] ? 50 : 10;
        $content->created_at            = time();
        $content->updated_at            = 0;
        $content->is_auth_required      = 0;
        $content->visibility            = \zikwall\vktv\constants\Content::VISIBILITY_PUBLIC;
        $content->pinned                = (int) $contentAttributes['is_pinned'];
        $content->archived              = (int) $contentAttributes['is_archive'];
        $content->active                = (int) $contentAttributes['is_active'];
        $content->ad_url                = $contentAttributes['ad_url'];
        $content->use_origin            = $contentAttributes['use_origin'];

        if (!$content->save()) {
            return false;
        }

        return $content;
    }
    
    public static function savePlaylistAfterContent(Playlist $playlist, Content $content, IdentityInterface $user)
    {
        $playlist->epg_id       = 0;
        $playlist->content_id   = $content->id;
        $playlist->user_id      = $user->getId();
        $playlist->name         = $content->name;
        $playlist->url          = $content->url;
        $playlist->ssl          = AttributesValidator::isSSL($content->url) ? 1 : 0;
        $playlist->active       = $content->active;
        $playlist->blocked      = $content->blocked;
        $playlist->image        = $content->image;
        $playlist->use_origin   = $content->use_origin ?? 0;
        $playlist->category     = $content->category;
        $playlist->ad_url       = $content->ad_url;

        if (!$playlist->save()) {
            return false;
        }
        
        return $playlist;
    }

    public static function insert(array $contentAttributes, IdentityInterface $user, bool $usePlaylist) : bool
    {
        $inserted = (new Query())
            ->createCommand()
            ->insert('{{%content}}', [
                'user_id'               => $user->getId(),
                'name'                  => $contentAttributes['name'],
                'url'                   => $contentAttributes['url'],
                'type'                  => $contentAttributes['type'],
                'category'              => $contentAttributes['category'],
                'image'                 => $contentAttributes['image_url'],
                'desc'                  => $contentAttributes['desc'],
                'use_own_player_url'    => $contentAttributes['use_own_player'],
                'own_player_url'        => $contentAttributes['own_player_url'],
                //'ad_url'              => $contentAttributes['ad_url'],
                //'use_origin'          => $contentAttributes['use_origin'],
                //'rating'              => $contentAttributes['rating'],
                'age_limit'             => $contentAttributes['is_18_years_old'],
                'created_at'            => time(),
                'updated_at'            => 0,
                'is_auth_required'      => 0,
                'visibility'            => \zikwall\vktv\constants\Content::VISIBILITY_PUBLIC,
                'pinned'                => $contentAttributes['is_pinned'],
                'archived'              => $contentAttributes['is_archived'],
                'active'                => $contentAttributes['is_active'],
            ])->execute();

        return $inserted === 1;
    }

    public static function update(array $contentAttributes, IdentityInterface $user, int $id, bool $usePlaylist) : bool
    {
        $updated = (new Query())
            ->createCommand()
            ->update('{{%content}}', [
                'user_id'               => $user->getId(),
                'name'                  => $contentAttributes['name'],
                'url'                   => $contentAttributes['url'],
                'type'                  => $contentAttributes['type'],
                'category'              => $contentAttributes['category'],
                'image'                 => $contentAttributes['image_url'],
                'desc'                  => $contentAttributes['desc'],
                'use_own_player_url'    => $contentAttributes['use_own_player'],
                'own_player_url'        => $contentAttributes['own_player_url'],
                //'ad_url'              => $contentAttributes['ad_url'],
                //'use_origin'          => $contentAttributes['use_origin'],
                //'rating'              => $contentAttributes['rating'],
                'age_limit'             => $contentAttributes['is_18_years_old'],
                'created_at'            => time(),
                'updated_at'            => 0,
                'is_auth_required'      => 0,
                'visibility'            => \zikwall\vktv\constants\Content::VISIBILITY_PUBLIC,
                'pinned'                => $contentAttributes['is_pinned'],
                'archived'              => $contentAttributes['is_archived'],
                'active'                => $contentAttributes['is_active'],
            ], [
                'id' => $id,
                'user_id' => $user->getId()
            ])->execute();

        return $updated === 1;
    }
}

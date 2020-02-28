<div align="center">
  <h1>TV Service Backend</h1>
  <h4>Make easy</h4>
  <h5>This is a full-featured module for creating applications and sites designed for television broadcasting.</h5>
</div>

## End[points]

* [Login](endpoints/Login.md) : `POST /vktv/auth/signin`
* [Register](endpoints/Register.md) : `POST /vktv/auth/signup`
* [Forgot](endpoints/Forgot.md) : `POST /vktv/auth/forgot`
* [API Channels](endpoints/API_Channels.md) : `GET /vktv/api/channels`
* [API EPG](endpoints/API_EPG.md) : `GET /vktv/api/epg`
* [API FAQ](endpoints/API_FAQ.md) : `GET /vktv/auth/faq`
* [WEB Embed Give](endpoints/WEB_Embed_Give.md) : `GET /vktv/embed/give`

## Installation

`composer require zikwall/vk-tv-backend`

## Develop mode

```json
{
    "minimum-stability": "dev",
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/zikwall/vk-tv-backend.git"
        }
    ],
    "require": {
        "zikwall/vk-tv-backend": "dev-master"
    }
}

```

### Configuration

#### Web & console aplications config

```php
'bootstrap' => [\zikwall\vktv\Bootstrap::class],
...

'modules' => [
      'vktv' => [
            'class' => \zikwall\vktv\Module::class,
      ],
],

```

#### Migrations

`php yii migrate --migrationPath=@vktv/migrations`

#### Console App

1. Scan and load playlists into the database, run: `php yii vktv/generate`
2. Scan and add TV programs to the database from XMLTV, run: `php yii vktv/generate/epg-xmltv`
3. Run Calculate content ratings: `php7.3 yii vktv/recount-rating/calculate`

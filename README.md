
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

1. Run parse and store to DB playlists: `php yii vktv/generate`



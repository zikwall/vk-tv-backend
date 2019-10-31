
## Installation

`composer require zikwall/vk-tv-backend`

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



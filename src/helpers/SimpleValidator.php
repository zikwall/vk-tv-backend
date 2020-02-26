<?php

namespace vktv\helpers;

use vktv\helpers\AttributesValidator;
use vktv\helpers\Category;
use vktv\helpers\Type;

class SimpleValidator
{
    public static function validateContentForm(array $post)
    {
        if (AttributesValidator::isNotEmptyString($post['name']) === false || AttributesValidator::isOverMaxlen($post['name'], 30)) {
            return [
                'code' => 100,
                'message' => 'Наименование не может быть пустым и длинее 30 символов.',
                'attributes' => [
                    'name'
                ]
            ];
        }

        if (AttributesValidator::isNotEmptyString($post['url']) === false || AttributesValidator::isOverMaxlen($post['url'], 250)) {
            return [
                'code' => 100,
                'message' => 'Ссылка на вещание не может быть пустым и длинее 250 символов.',
                'attributes' => [
                    'url'
                ]
            ];
        }

        if (AttributesValidator::isNotEmptyString($post['url'])) {
            if (!preg_match('/([a-zA-Z0-9\s_\\.\-\(\):])+(.m3u|.m3u8)$/i', $post['url']) || !AttributesValidator::isValidURL($post['url'])) {
                return [
                    'code' => 100,
                    'message' => 'Некорректная ссылка на вещание.',
                    'attributes' => [
                        'url'
                    ]
                ];
            }
        }

        if ($post['image_url'] !== null && AttributesValidator::isNotEmptyString($post['image_url'])) {
            if (AttributesValidator::isOverMaxlen($post['image_url'], 500)) {
                return [
                    'code' => 100,
                    'message' => 'Ссылка на изображение не может быть длинее 500 символов.',
                    'attributes' => [
                        'image_url'
                    ]
                ];
            }

            if (!AttributesValidator::isValidURL($post['image_url'])) {
                return [
                    'code' => 100,
                    'message' => 'Некорректная ссылка на изображение.',
                    'attributes' => [
                        'image_url'
                    ]
                ];
            }
        }

        if ($post['ad_url'] !== null && AttributesValidator::isNotEmptyString($post['ad_url'])) {
            if (AttributesValidator::isOverMaxlen($post['ad_url'], 500)) {
                return [
                    'code' => 100,
                    'message' => 'Ссылка на рекламу не может быть длинее 500 символов.',
                    'attributes' => [
                        'ad_url'
                    ]
                ];
            }

            if (!AttributesValidator::isValidURL($post['ad_url'])) {
                return [
                    'code' => 100,
                    'message' => 'Некорректная ссылка на рекламу.',
                    'attributes' => [
                        'ad_url'
                    ]
                ];
            }
        }

        if ($post['use_own_player'] || AttributesValidator::isNotEmptyString($post['own_player_url'])) {
            if ($post['use_own_player'] && AttributesValidator::isNotEmptyString($post['own_player_url']) === false) {
                return [
                    'code' => 100,
                    'message' => 'Вы установлили флаг "Использовать свой плеер", но не указали ссылку на плеер.',
                    'attributes' => [
                        'own_player_url'
                    ]
                ];
            }

            if (AttributesValidator::isOverMaxlen($post['own_player_url'], 500)) {
                return [
                    'code' => 100,
                    'message' => 'Ссылка на плеер не может быть длинее 500 символов.',
                    'attributes' => [
                        'own_player_url'
                    ]
                ];
            }

            if (!AttributesValidator::isValidURL($post['own_player_url'])) {
                return [
                    'code' => 100,
                    'message' => 'Некорректная ссылка на свой плеер.',
                    'attributes' => [
                        'own_player_url'
                    ]
                ];
            }
        }

        if (AttributesValidator::isOverMaxlen($post['desc'], 1000)) {
            return [
                'code' => 100,
                'message' => 'Описание не может быть длинее 1000 символов.',
                'attributes' => [
                    'desc'
                ]
            ];
        }

        if (!in_array($post['type'], array_keys(Type::getList()))) {
            return [
                'code' => 100,
                'message' => 'Вы хотите установить не существующий тип контента!',
                'attributes' => [
                    'type'
                ]
            ];
        }

        if (!in_array($post['category'], array_keys(Category::getList()))) {
            return [
                'code' => 100,
                'message' => 'Вы хотите установить не существующую категорию!',
                'attributes' => [
                    'category'
                ]
            ];
        }

        return [
            'code' => 200
        ];
    }
}

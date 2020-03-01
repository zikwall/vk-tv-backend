<?php

namespace zikwall\vktv\constants;

class Auth
{
    const ERROR_WRONG_USERNAME_OR_PASSWORD = [
        'code' => 1,
        'message' => 'Wrong username or password.',
        'attributes' => [
            'username', 'password'
        ]
    ];

    const ERROR_INVALID_EMAIL_ADRESS = [
        'code' => 2,
        'message' => 'Invalid email adress.',
        'attributes' => [
            'email'
        ]
    ];

    const ERROR_EMAIL_ALREADY_USE = [
        'code' => 3,
        'message' => 'This email already use.',
        'attributes' => [
            'email'
        ]
    ];

    const ERROR_USERNAME_ALREADY_USE = [
        'code' => 4,
        'message' => 'This username already use.',
        'attributes' => [
            'username'
        ]
    ];

    const ERROR_INVALID_PASSWORD = [
        'code' => 5,
        'message' => 'Пароль должен содержать не менее восьми символов, как минимум одну заглавную букву, одну строчную букву и одну цифру.',
        'attributes' => [
            'password'
        ]
    ];

    const ERROR_INVALID_USERNAME = [
        'code' => 5,
        'message' => 'Username may contain next characters minimum five characters, at least uppercase letter, lowercase letter and number.',
        'attributes' => [
            'username'
        ]
    ];

    const ERROR_FAILED_REGISTRATION = [
        'code' => 6,
        'message' => 'An error occurred while registering, do not worry, we are already looking for a problem.',
    ];

    const ERROR_EMAIL_NOT_FOUND = [
        'code' => 7,
        'message' => 'This email not found in Play database.',
        'attributes' => [
            'email'
        ]
    ];

    const ERROR_INVALID_NAME = [
        'code' => 8,
        'message' => 'Incorrect name. The name may contain letters of the Latin alphabet and a separator in the form of a space, see for yourself [a-zA-Z\',.-]',
        'attributes' => [
            'name'
        ]
    ];

    const ERROR_NOT_VALID_DATA = [
        'code' => 9,
        'message' => 'Incorrect attributes',
        'attributes' => []
    ];

    const ERROR_NOT_SAVED_DATA = [
        'code' => 10,
        'message' => 'Failed to save',
        'attributes' => []
    ];

    const SUCCESS_DESTROYED_ACCOUNT = [
        'code' => 101,
        'message' => 'Succsessfully delete account, Bye!',
    ];

    const MESSAGE_USER_IS_BLOCKED = [
        'code' => 1001,
        'message' => 'Account is blocked.'
    ];

    const MESSAGE_USER_IS_DESTROYED = [
        'code' => 1002,
        'message' => 'Account is destroyed.'
    ];

    const MESSAGE_IS_UNAUTHORIZED = [
        'code' => 1003,
        'message' => 'User is not authorized!',
    ];

    const MESSAGE_SUCCESSUL_SEND_FORGOT_MESSAGE = [
        'code' => 1004,
        'message' => 'Инструкции с дальнейшими указаниями были отправлены на указанный адрес электронной почты. Проверьте спам.!',
    ];

    const MESSAGE_USER_ALREADY_CONFIRMED_SINGUP = [
        'code' => 1005,
        'message' => 'It seems you have already passed this stage...',
    ];

    const MESSAGE_USER_AFTER_REGISTRATION_FAILED = [
        'code' => 1006,
        'message' => 'Failed to update data, please do it in the settings yourself',
    ];
}

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
        'message' => 'Password may contain minimum eight characters, at least one uppercase letter, one lowercase letter and one number.',
        'attributes' => [
            'password'
        ]
    ];

    const ERROR_INVALID_USERNAME = [
        'code' => 5,
        'message' => 'Username may contain next characters minimum five characters, at least uppercase letter, lowercase letter and number.',
        'attributes' => [
            'password'
        ]
    ];

    const ERROR_FAILED_REGISTRATION = [
        'code' => 6,
        'message' => 'An error occurred while registering, do not worry, we are already looking for a problem.',
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
}
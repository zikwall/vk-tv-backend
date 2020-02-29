<?php

namespace vktv\helpers;

class AttributesValidator
{
    public static function isEveryRequired(array $checkArray, array $requiredItems) : array
    {
        $isInvalid = false;
        $missingAttributes = [];

        foreach ($requiredItems as $requiredItem) {
            if (!isset($checkArray[$requiredItem])) {
                $isInvalid = true;
                $missingAttributes[] = $requiredItem;
            }
        }

        return [
            'state' => !$isInvalid,
            'missing' => $missingAttributes
        ];
    }

    public static function isValidPassword(string $password) : bool
    {
        if (strlen($password) < 8) {
            return false;
        }

        // Как минимум одна заглавная буква, одна строчная буква и одна цифра и больше 8
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
            return false;
        }

        return true;
    }

    public static function isValidEmail(string $email) : bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isValidUsername(string $username) : bool
    {
        if (strlen($username) < 5 || strlen($username) > 20) {
            return false;
        }

        return preg_match('/^[a-zA-Z0-9]{5,20}$/', $username);
    }

    public static function isValidRealName(string $name) : bool
    {
        if (strlen($name) < 2 || strlen($name) > 30) {
            return false;
        }

        return preg_match('/^[a-zA-Zа-яА-Я]+(([\',. -][a-zA-Zа-яА-Я ])?[a-zA-Zа-яА-Я]*)*$/', $name);
    }

    public static function isValidURL($str)
    {
        return preg_match('/^(https?:\\/\\/)?' . // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' . // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' . // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' . // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' .// query string
            '(\\#[-a-z\\d_]*)?$/i', $str);
    }

    public static function isOverMaxlen(string $attribute, int $maxLen) : bool
    {
        return strlen($attribute) > $maxLen;
    }

    public static function isNotEmptyString(string $attribute) : bool
    {
        return strlen($attribute) > 0;
    }

    public static function isSSL(string $url) : bool
    {
        return strpos($url, "https://") !== false;
    }
}

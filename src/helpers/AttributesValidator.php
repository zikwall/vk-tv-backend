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

        return preg_match('/^[a-zA-Z]+(([\',. -][a-zA-Z ])?[a-zA-Z]*)*$/', $name);
    }
}

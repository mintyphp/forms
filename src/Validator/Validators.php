<?php

namespace MintyPHP\Form\Validator;

class Validators
{
    public static function required(string $message = ''): Validator
    {
        $validator = new Required();
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function email(string $message = ''): Validator
    {
        $validator = new Email();
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function url(string $message = ''): Validator
    {
        $validator = new Url();
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function integer(string $message = ''): Validator
    {
        $validator = new Integer();
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function expression(string $comperator, string $value, string $message = ''): Validator
    {
        $validator = new Expression($comperator, $value);
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function minLength(int $minLength, string $message = ''): Validator
    {
        $validator = new MinLength($minLength);
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function maxLength(int $maxLength, string $message = ''): Validator
    {
        $validator = new MaxLength($maxLength);
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function regex(string $pattern, string $message = ''): Validator
    {
        $validator = new Regex($pattern);
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }
}

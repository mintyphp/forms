<?php

namespace MintyPHP\Form\Validator;

class Validators
{
    public static function required(string $message = ''): Validator
    {
        $validator = new RequiredValidator();
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function email(string $message = ''): Validator
    {
        $validator = new EmailValidator();
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function url(string $message = ''): Validator
    {
        $validator = new UrlValidator();
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function integer(string $message = ''): Validator
    {
        $validator = new IntValidator();
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function expression(string $comperator, string $value, string $message = ''): Validator
    {
        $validator = new ExpressionValidator($comperator, $value);
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function minLength(string $minLength, string $message = ''): Validator
    {
        $validator = new MinLengthValidator($minLength);
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function maxLength(string $maxLength, string $message = ''): Validator
    {
        $validator = new MaxLengthValidator($maxLength);
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }

    public static function regex(string $pattern, string $message = ''): Validator
    {
        $validator = new RegexValidator($pattern);
        if ($message) {
            $validator->message($message);
        }
        return $validator;
    }
}

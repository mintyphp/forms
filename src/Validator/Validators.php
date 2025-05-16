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

    // public static function minLength(int $length): Validator
    // {
    //     return new MinLengthValidator($length);
    // }

    // public static function maxLength(int $length): Validator
    // {
    //     return new MaxLengthValidator($length);
    // }
}

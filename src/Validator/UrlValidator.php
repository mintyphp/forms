<?php

namespace MintyPHP\Form\Validator;

class UrlValidator implements Validator
{
    protected string $message = 'Invalid URL';

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function validate(string $value): string
    {
        if (!preg_match('/^https?:\/\//', strtolower($value))) {
            return $this->message;
        }
        return !filter_var($value, FILTER_VALIDATE_URL) ? $this->message : '';
    }
}

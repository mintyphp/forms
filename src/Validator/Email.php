<?php

namespace MintyPHP\Form\Validator;

class Email implements Validator
{
    protected string $message = 'Invalid email address';

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function validate(string $value): string
    {
        return !filter_var($value, FILTER_VALIDATE_EMAIL) ? $this->message : '';
    }
}

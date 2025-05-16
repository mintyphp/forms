<?php

namespace MintyPHP\Form\Validator;

class RequiredValidator implements Validator
{
    protected string $message = 'Field is required';

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function validate(string $value): string
    {
        return empty(trim($value)) ? $this->message : '';
    }
}

<?php

namespace MintyPHP\Form\Validator;

class IntegerValidator implements Validator
{
    protected string $message = 'Must be a whole number';

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function validate(string $value): string
    {
        return strval(intval($value)) !== $value ? $this->message : '';
    }
}

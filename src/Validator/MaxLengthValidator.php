<?php

namespace MintyPHP\Form\Validator;

class MaxLengthValidator implements Validator
{
    protected int $maxLength = 255;
    protected string $message = 'Exceeds maximum length';

    public function maxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function validate(string $value): string
    {
        return mb_strlen($value) > $this->maxLength ? $this->message : '';
    }
}

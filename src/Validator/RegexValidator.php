<?php

namespace MintyPHP\Form\Validator;

class RegexValidator implements Validator
{
    protected string $pattern = '/.*/';
    protected string $message = 'Invalid format';

    public function pattern(string $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function validate(string $value): string
    {
        return !preg_match($this->pattern, $value) ? $this->message : '';
    }
}

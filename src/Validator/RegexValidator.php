<?php

namespace MintyPHP\Form\Validator;

class RegexValidator implements ExpressionValidator
{
    protected string $pattern = '/.*/';
    protected string $message = 'Invalid format';

    public function __construct(string $pattern)
    {
        if (@preg_match($pattern, "") === false) {
            throw new \InvalidArgumentException("Invalid regex pattern: $pattern");
        }
        $this->pattern = $pattern;
    }

    public function evaluate(string $value): bool
    {
        return preg_match($this->pattern, $value) ? true : false;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

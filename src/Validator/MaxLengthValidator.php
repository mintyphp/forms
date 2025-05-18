<?php

namespace MintyPHP\Form\Validator;

class MaxLengthValidator implements ExpressionValidator
{
    protected int $maxLength = 255;
    protected string $message = 'Exceeds maximum length';

    public function __construct(string $maxLength)
    {
        if (!is_numeric($maxLength) || intval($maxLength) < 0) {
            throw new \InvalidArgumentException('Max length must be a non-negative integer');
        }
        $this->maxLength = intval($maxLength);
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function evaluate(string $value): bool
    {
        return mb_strlen($value) <= $this->maxLength;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

<?php

namespace MintyPHP\Form\Validator;

class MaxLength implements Validator
{
    protected int $maxLength;
    protected string $message = 'Exceeds maximum length';

    public function __construct(int $maxLength)
    {
        if ($maxLength < 0) {
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
        return mb_strlen(trim($value)) <= $this->maxLength;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

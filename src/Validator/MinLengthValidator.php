<?php

namespace MintyPHP\Form\Validator;

class MinLengthValidator implements Validator
{
    protected int $minLength;
    protected string $message = 'Exceeds minimum length';

    public function __construct(string $minLength)
    {
        if (!is_numeric($minLength) || intval($minLength) < 0) {
            throw new \InvalidArgumentException('Min length must be a non-negative integer');
        }
        $this->minLength = intval($minLength);
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function evaluate(string $value): bool
    {
        return mb_strlen($value) <= $this->minLength;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

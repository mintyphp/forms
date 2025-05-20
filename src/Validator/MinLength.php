<?php

namespace MintyPHP\Form\Validator;

class MinLength implements Validator
{
    protected int $minLength;
    protected string $message = 'Exceeds minimum length';

    public function __construct(int $minLength)
    {
        if ($minLength < 0) {
            throw new \InvalidArgumentException('Min length must be a non-negative integer');
        }
        $this->minLength = $minLength;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function evaluate(string $value): bool
    {
        return mb_strlen($value) >= $this->minLength;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

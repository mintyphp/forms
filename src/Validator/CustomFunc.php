<?php

namespace MintyPHP\Form\Validator;

class CustomFunc implements Validator
{
    protected mixed $function;
    protected string $message = 'Invalid value';

    public function __construct(mixed $function)
    {
        if (!is_callable($function)) {
            throw new \InvalidArgumentException("Invalid function");
        }
        $this->function = $function;
    }

    public function evaluate(string $value): bool
    {
        return call_user_func($this->function, $value) ? true : false;
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

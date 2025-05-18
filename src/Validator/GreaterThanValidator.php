<?php

namespace MintyPHP\Form\Validator;

class GreaterThanValidator implements Validator
{
    protected string $value;
    protected string $message = 'Number must be greater than {value}';

    public function __construct(string $value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Value must be numeric');
        }
        $this->value = $value;
    }

    public function evaluate(string $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }
        return floatval($value) > floatval($this->value);
    }

    public function message(string $message): self
    {
        $this->message = str_replace('{value}', $this->value, $message);
        return $this;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

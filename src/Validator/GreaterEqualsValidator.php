<?php

namespace MintyPHP\Form\Validator;

class GreaterEqualsValidator implements Validator
{
    protected string $value;
    protected string $message = 'Number must be greater than or equal to {value}';

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
        return floatval($value) >= floatval($this->value);
    }

    public function message(string $message): self
    {
        if (strpos($message, '{value}') === false) {
            throw new \InvalidArgumentException('Message must contain "{value}"');
        }
        $this->message = str_replace('{value}', $this->value, $message);
        return $this;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

<?php

namespace MintyPHP\Form\Validator;

class Expression implements Validator
{
    protected string $comparator;
    protected string|int|float $value;
    protected string $message = 'Number must be {comparator} {value}';

    public function __construct(string $comparator, string|int|float $value)
    {
        if (!in_array($comparator, ['>', '>=', '<', '<='])) {
            throw new \InvalidArgumentException('Comparator not supported');
        }
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Value must be numeric');
        }
        $this->comparator = $comparator;
        $this->value = $value;
    }

    public function evaluate(string $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }
        //evaluate the expression
        switch ($this->comparator) {
            case '>':
                return floatval($value) > floatval($this->value);
            case '>=':
                return floatval($value) >= floatval($this->value);
            case '<':
                return floatval($value) < floatval($this->value);
            case '<=':
                return floatval($value) <= floatval($this->value);
        }
        // If we reach here, something went wrong
        throw new \RuntimeException('Comparator not implemented');
    }

    public function message(string $message): self
    {
        $this->message = str_replace(['{value}', '{comparator}'], [strval($this->value), $this->comparator], $message);
        return $this;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

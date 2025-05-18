<?php

namespace MintyPHP\Form\Validator;

class ExpressionValidator implements Validator
{
    protected string $comperator;
    protected string $value;
    protected string $message = 'Number must be {comperator} {value}';

    public function __construct(string $comperator, string $value)
    {
        if (!in_array($comperator, ['>', '>=', '<', '<='])) {
            throw new \InvalidArgumentException('Comperator not supported');
        }
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Value must be numeric');
        }
        $this->comperator = $comperator;
        $this->value = $value;
    }

    public function evaluate(string $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }
        //evaluate the expression
        switch ($this->comperator) {
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
        throw new \RuntimeException('Not implemented comperator: ' . $this->comperator);
    }

    public function message(string $message): self
    {
        $this->message = str_replace(['{value}', '{comperator}'], [$this->value, $this->comperator], $message);
        return $this;
    }

    public function validate(string $value): string
    {
        return !$this->evaluate($value) ? $this->message : '';
    }
}

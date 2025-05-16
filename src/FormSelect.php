<?php

namespace MintyPHP\Form;

use DOMElement;
use MintyPHP\Form\Validator\Validator;

class FormSelect implements FormControl
{
    use HtmlElement;

    protected string $name = '';
    protected string $value = '';
    /** @var array<string,string> $options */
    protected array $options = [];

    public function __construct()
    {
        $this->tag('select');
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function value(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param array<string,string> $options
     */
    public function options(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param array<string, string> $data
     */
    public function fill(array $data): void
    {
        if (key_exists($this->name, $data)) {
            $this->value = trim($data[$this->name]);
        }
    }

    public function validate(Validator $validator): string
    {
        return $validator->validate($this->value);
    }

    public function setError(string $message): void {}

    public function render(\DOMDocument $doc): \DOMElement
    {
        $select = $this->renderElement($doc);
        return $select;
    }
}

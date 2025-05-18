<?php

namespace MintyPHP\Form;

use MintyPHP\Form\HtmlElement;
use DOMElement;

class Fieldset
{
    use HtmlElement;

    /** @var Field[] */
    protected array $fields = [];
    protected ?Legend $legend = null;
    protected ?Header $header = null;

    public function __construct()
    {
        $this->tag('div');
    }

    public function field(Field $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    /**
     * @param Field[] $fields
     */
    public function fields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->field($field);
        }
        return $this;
    }

    public function legend(Legend $legend): self
    {
        $this->legend = $legend;
        return $this;
    }

    public function header(Header $header): self
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param array<string, string|string[]|null> $data
     */
    public function fill(array $data): void
    {
        foreach ($this->fields as $field) {
            $field->fill($data);
        }
    }

    /**
     * @return array<string, string|string[]|null>
     */
    public function extract(): array
    {
        $data = [];
        foreach ($this->fields as $field) {
            foreach ($field->extract() as $name => $value) {
                if (isset($data[$name])) {
                    if (!is_array($data[$name])) {
                        $data[$name] = [$data[$name]];
                    }
                    if (is_array($value)) {
                        $data[$name] = array_merge($data[$name], $value);
                    } else {
                        $data[$name][] = $value;
                    }
                } else {
                    $data[$name] = $value;
                }
            }
        }
        return $data;
    }

    public function validate(): bool
    {
        $isValid = true;
        foreach ($this->fields as $field) {
            $errorMesage = $field->validate();
            if ($errorMesage) {
                $isValid = false;
            }
            $field->setError($errorMesage);
        }
        return $isValid;
    }

    /**
     * @param array<string, string> $messages
     */
    public function addErrors(array $messages): void
    {
        foreach ($this->fields as $field) {
            $name = $field->getControl()->getName();
            if (!isset($messages[$name])) {
                continue;
            }
            $message = $messages[$name];
            $field->setError($message);
        }
    }

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $fieldset = $this->renderElement($doc);
        if ($this->legend) {
            $legendElement = $this->legend->renderDom($doc);
            $fieldset->appendChild($legendElement);
        }
        if ($this->header) {
            $headerElement = $this->header->renderDom($doc);
            $fieldset->appendChild($headerElement);
        }
        foreach ($this->fields as $field) {
            $fieldElement = $field->renderDom($doc);
            $fieldset->appendChild($fieldElement);
        }
        return $fieldset;
    }
}

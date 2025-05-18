<?php

namespace MintyPHP\Form;

use MintyPHP\Form\HtmlElement;
use DOMElement;

class FormFieldset
{
    use HtmlElement;

    /** @var FormField[] */
    protected array $fields = [];
    protected ?FormHeader $header = null;

    public function __construct()
    {
        $this->tag('div');
    }

    public function field(FormField $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    /**
     * @param FormField[] $fields
     */
    public function fields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->field($field);
        }
        return $this;
    }

    public function header(FormHeader $header): self
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param array<string, string|string[]> $data
     */
    public function fill(array $data): void
    {
        foreach ($this->fields as $field) {
            $field->fill($data);
        }
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

    public function setError(string $message): void
    {
        foreach ($this->fields as $field) {
            $field->setError($message);
        }
    }

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $fieldset = $this->renderElement($doc);
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

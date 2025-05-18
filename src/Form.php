<?php

namespace MintyPHP\Form;

class Form
{
    use HtmlElement;

    protected string $action = '';
    protected string $method = 'POST';
    protected string $enctype = 'application/x-www-form-urlencoded';
    /** @var Fieldset[] */
    protected array $fieldsets = [];

    protected bool $hideFieldsets = false;

    public function __construct()
    {
        $this->tag('form');
    }

    public function action(string $action): self
    {
        $this->action = $action;
        return $this;
    }

    public function method(string $method): self
    {
        $this->method = strtoupper($method);
        return $this;
    }

    public function enctype(string $enctype): self
    {
        $this->enctype = $enctype;
        return $this;
    }

    public function class(string $class): self
    {
        $this->classes[] = $class;
        return $this;
    }

    /**
     * @param string[] $classes
     */
    public function classes(array $classes): self
    {
        foreach ($classes as $class) {
            $this->class($class);
        }
        return $this;
    }

    public function attribute(string $name, string $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @param array<string, string> $attributes
     */
    public function attributes(array $attributes): self
    {
        foreach ($attributes as $name => $value) {
            $this->attribute($name, $value);
        }
        return $this;
    }

    public function fieldset(Fieldset $fieldset): self
    {
        $this->fieldsets[] = $fieldset;
        return $this;
    }

    /**
     * @param Fieldset[] $fieldsets
     */
    public function fieldsets(array $fieldsets): self
    {
        foreach ($fieldsets as $fieldset) {
            $this->fieldset($fieldset);
        }
        return $this;
    }

    public function field(Field $field): self
    {
        $this->hideFieldsets = true;
        $fieldset = new Fieldset();
        $fieldset->field($field);
        $this->fieldset($fieldset);
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

    /**
     * @param array<string, string|string[]|null> $data
     */
    public function fill(array $data): void
    {
        foreach ($this->fieldsets as $fieldset) {
            $fieldset->fill($data);
        }
    }

    /**
     * @return array<string, string|string[]|null>
     */
    public function extract(): array
    {

        $data = [];
        foreach ($this->fieldsets as $fieldset) {
            foreach ($fieldset->extract() as $name => $value) {
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
        foreach ($this->fieldsets as $fieldset) {
            $valid = $fieldset->validate();
            if (!$valid) {
                $isValid = false;
            }
        }
        return $isValid;
    }

    /**
     * @param array<string, string> $messages
     */
    public function addErrors(array $messages): void
    {
        foreach ($this->fieldsets as $fieldset) {
            $fieldset->addErrors($messages);
        }
    }

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        // Create a new DOMElement for the form
        $formElement = $this->renderElement($doc);
        if (!empty($this->action)) {
            $formElement->setAttribute('action', $this->action);
        }
        if (strtoupper($this->method) != 'GET') {
            $formElement->setAttribute('method', strtolower($this->method));
        }
        if ($this->enctype != 'application/x-www-form-urlencoded') {
            $formElement->setAttribute('enctype', $this->enctype);
        }
        if (!empty($this->classes)) {
            $formElement->setAttribute('class', implode(' ', $this->classes));
        }
        foreach ($this->attributes as $name => $value) {
            $formElement->setAttribute($name, $value);
        }
        foreach ($this->fieldsets as $fieldset) {
            $fieldsetElement = $fieldset->renderDom($doc);
            if ($this->hideFieldsets) {
                foreach ($fieldsetElement->childNodes as $child) {
                    $formElement->appendChild($child);
                }
            } else {
                $formElement->appendChild($fieldsetElement);
            }
        }
        return $formElement;
    }
}

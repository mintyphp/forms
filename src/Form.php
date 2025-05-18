<?php

namespace MintyPHP\Form;

class Form
{
    use HtmlElement;

    protected string $action = '';
    protected string $method = 'POST';
    protected string $enctype = 'application/x-www-form-urlencoded';
    /** @var FormFieldset[] */
    protected array $fieldsets = [];

    protected bool $hideFieldsets = false;

    public function __construct() {}

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

    public function fieldset(FormFieldset $fieldset): self
    {
        $this->fieldsets[] = $fieldset;
        return $this;
    }

    /**
     * @param FormFieldset[] $fieldsets
     */
    public function fieldsets(array $fieldsets): self
    {
        foreach ($fieldsets as $fieldset) {
            $this->fieldset($fieldset);
        }
        return $this;
    }

    public function field(FormField $field): self
    {
        $this->hideFieldsets = true;
        $fieldset = new FormFieldset();
        $fieldset->field($field);
        $this->fieldset($fieldset);
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

    /**
     * @param array<string, string|string[]> $data
     */
    public function fill(array $data): void
    {
        foreach ($this->fieldsets as $fieldset) {
            $fieldset->fill($data);
        }
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

    public function render(\DOMDocument $doc): \DOMElement
    {
        // Create a new DOMElement for the form
        $formElement = $doc->createElement('form');
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
            $fieldsetElement = $fieldset->render($doc);
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

    private function addCsrfInput(\DOMDocument $doc, \DOMElement $form): void
    {
        if (!$form->getAttribute('method') || $form->getAttribute('method') == 'GET') {
            return;
        }
        if (class_exists('MintyPHP\Session')) {
            ob_start();
            // @phpstan-ignore-next-line
            forward_static_call(['MintyPHP\Session', 'getCsrfInput']);
            $csrfInput = ob_get_clean();
            if ($csrfInput) {
                // add raw xml to the DOM
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $dom->loadXML($csrfInput);
                $importedNode = $doc->importNode($dom->documentElement, true);
                $form->appendChild($importedNode);
            }
        }
    }

    public function __toString(): string
    {
        // save the DOMElement to a string
        $domDocument = new \DOMDocument('1.0', 'UTF-8');
        $form = $this->render($domDocument);
        $this->addCsrfInput($domDocument, $form);
        $domDocument->appendChild($form);
        // format the output
        $domDocument->formatOutput = true;
        $domDocument->preserveWhiteSpace = false;
        // remove the XML declaration
        $str = $domDocument->saveXML();
        if (!$str) {
            throw new \RuntimeException('Failed to save XML');
        }
        return trim(preg_replace('/<\?xml.*?\?>/', '', $str));
    }
}

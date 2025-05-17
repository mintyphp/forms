<?php

namespace MintyPHP\Form;

class Form
{
    use HtmlElement;

    protected string $action = '';
    protected string $method = 'POST';
    protected string $enctype = 'application/x-www-form-urlencoded';
    /** @var FormRow[] */
    protected array $rows = [];

    protected bool $noRows = false;

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

    public function row(FormRow $row): self
    {
        $this->rows[] = $row;
        return $this;
    }

    /**
     * @param FormRow[] $rows
     */
    public function rows(array $rows): self
    {
        foreach ($rows as $row) {
            $this->row($row);
        }
        return $this;
    }

    /**
     * @param FormField[] $fields
     */
    public function fields(array $fields): self
    {
        $this->noRows = true;
        foreach ($fields as $field) {
            $this->row((new FormRow())->field($field));
        }
        return $this;
    }

    /**
     * @param array<string, string|string[]> $data
     */
    public function fill(array $data): void
    {
        foreach ($this->rows as $row) {
            $row->fill($data);
        }
    }

    public function validate(): bool
    {
        $isValid = true;
        foreach ($this->rows as $row) {
            $valid = $row->validate();
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
        foreach ($this->rows as $row) {
            $rowElement = $row->render($doc);
            if ($this->noRows) {
                foreach ($rowElement->childNodes as $child) {
                    $formElement->appendChild($child);
                }
            } else {
                $formElement->appendChild($rowElement);
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

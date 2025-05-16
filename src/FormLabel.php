<?php

namespace MintyPHP\Form;

use DOMElement;

class FormLabel
{
    use HtmlElement;

    protected string $caption = '';
    protected string $for = '';

    public function __construct()
    {
        $this->tag('label');
    }

    public function caption(string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    public function for(string $for): self
    {
        $this->for = $for;
        return $this;
    }

    public function setError(string $message): void {}


    public function render(\DOMDocument $doc): \DOMElement
    {
        $label = $this->renderElement($doc);
        if ($this->for) {
            $label->setAttribute('for', $this->for);
        }
        $label->textContent = $this->caption;
        return $label;
    }
}

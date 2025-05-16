<?php

namespace MintyPHP\Form;

use DOMElement;

class FormError
{
    use HtmlElement;

    protected string $message = '';

    public function __construct()
    {
        $this->tag('div');
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setError(string $message): void
    {
        $this->message($message);
    }

    public function render(\DOMDocument $doc): \DOMElement
    {
        $label = $this->renderElement($doc);
        $label->textContent = $this->message;
        return $label;
    }
}

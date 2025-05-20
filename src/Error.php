<?php

namespace MintyPHP\Form;

use DOMElement;

class Error
{
    use HtmlElement;

    protected string $message = '';

    public function __construct()
    {
        $this->tag('span');
        $this->class('help-block');
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

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $label = $this->renderElement($doc);
        $label->textContent = $this->message;
        return $label;
    }
}

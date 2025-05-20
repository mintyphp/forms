<?php

namespace MintyPHP\Form;

use DOMElement;

class Label
{
    use HtmlElement;

    protected string $caption = '';
    protected string $for = '';
    protected bool $disabled = false;

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

    public function disabled(): self
    {
        $this->disabled = true;
        $this->class('disabled');
        return $this;
    }

    public function setError(string $message): void {}

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        $label = $this->renderElement($doc);
        if ($this->for) {
            $label->setAttribute('for', $this->for);
        }
        $label->textContent = $this->caption;
        return $label;
    }
}

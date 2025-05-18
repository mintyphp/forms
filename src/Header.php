<?php

namespace MintyPHP\Form;

use DOMElement;

class Header
{
    use HtmlElement;

    public function __construct()
    {
        $this->tag('h3');
    }

    public function caption(string $caption): self
    {
        $this->content($caption);
        return $this;
    }

    public function renderDom(\DOMDocument $doc): \DOMElement
    {
        return $this->renderElement($doc);
    }
}

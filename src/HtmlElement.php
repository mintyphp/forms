<?php

namespace MintyPHP\Form;

use DOMElement;

trait HtmlElement
{
    protected string $tag = '';
    protected string $content = '';
    protected string $id = '';
    /** @var string[] */
    protected array $classes = [];
    /** @var array<string, string> $attributes */
    protected array $attributes = [];

    protected function tag(string $tag): self
    {
        $this->tag = strtolower($tag);
        return $this;
    }

    protected function content(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function id(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function class(string $class): self
    {
        $this->addClass($class);
        return $this;
    }

    public function addClass(string $class): self
    {
        if (!in_array($class, $this->classes)) {
            $this->classes[] = $class;
        }
        return $this;
    }

    public function removeClass(string $class): self
    {
        $index = array_search($class, $this->classes);
        if ($index !== false) {
            unset($this->classes[$index]);
        }
        return $this;
    }

    /**
     * @param string[] $classes
     */
    public function classes(array $classes): self
    {
        foreach ($classes as $class) {
            $this->addClass($class);
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

    protected function renderElement(\DOMDocument $doc): \DOMElement
    {
        $element = $doc->createElement($this->tag);
        if ($this->id) {
            $element->setAttribute('id', $this->id);
        }
        if ($this->classes) {
            $element->setAttribute('class', implode(' ', $this->classes));
        }
        foreach ($this->attributes as $name => $value) {
            $element->setAttribute($name, $value);
        }
        if ($this->content) {
            $element->textContent = $this->content;
        }
        return $element;
    }
}

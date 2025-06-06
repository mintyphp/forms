<?php

namespace MintyPHP\Form;

use MintyPHP\Form\Validator\Validator;

interface Control
{
    public function id(string $id): self;
    public function getId(): string;
    public function name(string $name): self;
    public function getName(): string;
    public function value(string $value): self;

    public function disabled(): self;
    public function readonly(): self;
    public function required(): self;
    public function autofocus(): self;
    public function autocomplete(string $value): self;

    /**
     * @param array<string, string|string[]|null> $data
     */
    public function fill(array $data): void;
    /**
     * @return array<string, string|string[]|null> $data
     */
    public function extract(bool $withNulls = false): array;
    public function validate(Validator $validator): string;
    public function setError(string $message): void;
    public function renderDom(\DOMDocument $doc): \DOMElement;
}

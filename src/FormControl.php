<?php

namespace MintyPHP\Form;

use MintyPHP\Form\Validator\Validator;

interface FormControl
{
    public function id(string $id): self;
    public function getId(): string;
    public function name(string $name): self;
    public function getName(): string;
    /**
     * @param array<string, string|array<string>> $data
     */
    public function fill(array $data): void;
    public function validate(Validator $validator): string;
    public function setError(string $message): void;
    public function render(\DOMDocument $doc): \DOMElement;
}

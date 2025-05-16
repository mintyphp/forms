<?php

namespace MintyPHP\Form\Validator;

interface Validator
{
    public function validate(string $value): string;
    public function message(string $message): self;
}

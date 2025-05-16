<?php

namespace MintyPHP\Form;

class Elements
{
    public static string $style = 'none';
    /** @var array<string, string> */
    public static array $namespaces = [
        'none' => 'MintyPHP\\Form\\',
        'bulma' => 'MintyPHP\\Form\\Bulma\\',
    ];

    public static function form(): Form
    {
        /** @var Form */
        $form = self::create('Form');
        return $form;
    }

    public static function create(string $className): object
    {
        $class = self::$namespaces[self::$style] . $className;
        if (class_exists($class)) {
            return new $class();
        }
        $class = self::$namespaces['none'] . $className;
        if (class_exists($class)) {
            return new $class();
        }
        throw new \Exception("Class $class does not exist");
    }

    public static function text(string $name = '', string $placeholder = ''): FormInput
    {
        /** @var FormInput */
        $input = self::create('FormInput');
        if ($name) {
            $input->name($name);
        }
        if ($placeholder) {
            $input->placeholder($placeholder);
        }
        return $input;
    }

    public static function email(string $name = '', string $placeholder = ''): FormInput
    {
        /** @var FormInput */
        $input = self::create('FormInput');
        $input->type('email');
        if ($name) {
            $input->name($name);
        }
        if ($placeholder) {
            $input->placeholder($placeholder);
        }
        return $input;
    }


    public static function label(string $caption = ''): FormLabel
    {
        /** @var FormLabel */
        $label = self::create('FormLabel');
        if ($caption) {
            $label->caption($caption);
        }
        return $label;
    }

    public static function field(): FormField
    {
        /** @var FormField */
        $field = self::create('FormField');
        return $field;
    }

    public static function header(): FormHeader
    {
        /** @var FormHeader */
        $header = self::create('FormHeader');
        return $header;
    }

    public static function legend(): FormLegend
    {
        /** @var FormLegend */
        $legend = self::create('FormLegend');
        return $legend;
    }

    public static function error(): FormError
    {
        /** @var FormError */
        $error = self::create('FormError');
        return $error;
    }

    public static function row(): FormRow
    {
        /** @var FormRow */
        $row = self::create('FormRow');
        return $row;
    }
}

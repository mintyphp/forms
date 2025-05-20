<?php

namespace MintyPHP\Tests\Forms;

use PHPUnit\Framework\TestCase;

use MintyPHP\Form\Form;
use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

class UsernameFormTest extends TestCase
{
    private function createForm(string $style): Form
    {
        E::$style = $style;
        return E::form([
            E::field(E::email('username', 'Enter your email')->required(), E::label('Username'), [V::required('Username is required'), V::email('Enter a valid email address')]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<div>',
            '  <label for="username">Username</label>',
            '  <input id="username" type="email" name="username" value="" placeholder="Enter your email" required="required"/>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testRenderBulma(): void
    {
        $form = $this->createForm('bulma');
        $lines = [
            '<div class="field">',
            '  <label class="label" for="username">Username</label>',
            '  <div class="control">',
            '    <input id="username" class="input" type="email" name="username" value="" placeholder="Enter your email" required="required"/>',
            '  </div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testFillForm(): void
    {
        $form = $this->createForm('none');
        $form->fill(['username' => 'some_random_username']);
        $lines = [
            '<div>',
            '  <label for="username">Username</label>',
            '  <input id="username" type="email" name="username" value="some_random_username" placeholder="Enter your email" required="required"/>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testValidators(): void
    {
        $form = $this->createForm('none');
        $form->fill(['username' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="error">',
            '  <label for="username">Username</label>',
            '  <input id="username" type="email" name="username" value="" placeholder="Enter your email" required="required"/>',
            '  <div>Username is required</div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['username' => 'some_random_username']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="error">',
            '  <label for="username">Username</label>',
            '  <input id="username" type="email" name="username" value="some_random_username" placeholder="Enter your email" required="required"/>',
            '  <div>Enter a valid email address</div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['username' => 'test@test.com']);
        $this->assertTrue($form->validate());
        $lines = [
            '<div>',
            '  <label for="username">Username</label>',
            '  <input id="username" type="email" name="username" value="test@test.com" placeholder="Enter your email" required="required"/>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testValidatorsBulma(): void
    {
        $form = $this->createForm('bulma');
        $form->fill(['username' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="field">',
            '  <label class="label" for="username">Username</label>',
            '  <div class="control">',
            '    <input id="username" class="input is-danger" type="email" name="username" value="" placeholder="Enter your email" required="required"/>',
            '  </div>',
            '  <p class="help is-danger">Username is required</p>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['username' => 'some_random_username']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="field">',
            '  <label class="label" for="username">Username</label>',
            '  <div class="control">',
            '    <input id="username" class="input is-danger" type="email" name="username" value="some_random_username" placeholder="Enter your email" required="required"/>',
            '  </div>',
            '  <p class="help is-danger">Enter a valid email address</p>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['username' => 'test@test.com']);
        $this->assertTrue($form->validate());
        $lines = [
            '<div class="field">',
            '  <label class="label" for="username">Username</label>',
            '  <div class="control">',
            '    <input id="username" class="input" type="email" name="username" value="test@test.com" placeholder="Enter your email" required="required"/>',
            '  </div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }
}

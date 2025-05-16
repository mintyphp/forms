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
        return E::form()->fields([
            E::field()
                ->label(E::label('Username'))
                ->control(E::email('username', 'Enter your email'))
                ->validators([
                    V::required('Username is required'),
                    V::email('Enter a valid email address')
                ]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="username">Username</label>',
            '    <input id="username" type="email" name="username" value="" placeholder="Enter your email"/>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }

    public function testRenderBulma(): void
    {
        $form = $this->createForm('bulma');
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="username">Username</label>',
            '    <div class="control">',
            '      <input id="username" class="input" type="email" name="username" value="" placeholder="Enter your email"/>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }

    public function testFillForm(): void
    {
        $form = $this->createForm('none');
        $form->fill(['username' => 'some_random_username']);
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="username">Username</label>',
            '    <input id="username" type="email" name="username" value="some_random_username" placeholder="Enter your email"/>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }

    public function testValidators(): void
    {
        $form = $this->createForm('none');
        $form->fill(['username' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="error">',
            '    <label for="username">Username</label>',
            '    <input id="username" type="email" name="username" value="" placeholder="Enter your email"/>',
            '    <div>Username is required</div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
        $form->fill(['username' => 'some_random_username']);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="error">',
            '    <label for="username">Username</label>',
            '    <input id="username" type="email" name="username" value="some_random_username" placeholder="Enter your email"/>',
            '    <div>Enter a valid email address</div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
        $form->fill(['username' => 'test@test.com']);
        $this->assertTrue($form->validate());
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="username">Username</label>',
            '    <input id="username" type="email" name="username" value="test@test.com" placeholder="Enter your email"/>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }

    public function testValidatorsBulma(): void
    {
        $form = $this->createForm('bulma');
        $form->fill(['username' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="username">Username</label>',
            '    <div class="control">',
            '      <input id="username" class="input is-danger" type="email" name="username" value="" placeholder="Enter your email"/>',
            '    </div>',
            '    <p class="help is-danger">Username is required</p>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
        $form->fill(['username' => 'some_random_username']);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="username">Username</label>',
            '    <div class="control">',
            '      <input id="username" class="input is-danger" type="email" name="username" value="some_random_username" placeholder="Enter your email"/>',
            '    </div>',
            '    <p class="help is-danger">Enter a valid email address</p>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
        $form->fill(['username' => 'test@test.com']);
        $this->assertTrue($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="username">Username</label>',
            '    <div class="control">',
            '      <input id="username" class="input" type="email" name="username" value="test@test.com" placeholder="Enter your email"/>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }
}

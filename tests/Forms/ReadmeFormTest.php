<?php

namespace MintyPHP\Tests\Forms;

use PHPUnit\Framework\TestCase;

use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

class ReadmeFormTest extends TestCase
{
    public function testRenderForm(): void
    {
        E::$style = 'none';
        $form = E::form([
            E::field(E::text('username')->required(), E::label('Username')),
            E::field(E::password('password'), E::label('Password')),
            E::field(E::submit('Login')),
        ]);
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="username">Username</label>',
            '    <input id="username" type="text" name="username" value="" required="required"/>',
            '  </div>',
            '  <div>',
            '    <label for="password">Password</label>',
            '    <input id="password" type="password" name="password" value=""/>',
            '  </div>',
            '  <div>',
            '    <input type="submit" value="Login"/>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(true, false));
    }

    public function testRenderBulmaForm(): void
    {
        E::$style = 'bulma';
        $form = E::form([
            E::field(E::text('username')->required(), E::label('Username')),
            E::field(E::password('password'), E::label('Password')),
            E::field(E::submit('Login')),
        ]);
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="username">Username</label>',
            '    <div class="control">',
            '      <input id="username" class="input" type="text" name="username" value="" required="required"/>',
            '    </div>',
            '  </div>',
            '  <div class="field">',
            '    <label class="label" for="password">Password</label>',
            '    <div class="control">',
            '      <input id="password" class="input" type="password" name="password" value=""/>',
            '    </div>',
            '  </div>',
            '  <div class="field">',
            '    <div class="control">',
            '      <input class="button is-primary" type="submit" value="Login"/>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(true, false));
    }

    public function testValidateForm(): void
    {
        E::$style = 'bulma';
        $form = E::form([
            E::field(E::text('username')->required(), E::label('Username')),
            E::field(E::password('password'), E::label('Password')),
            E::field(E::submit('Login')),
        ]);
        $form->fill(['username' => 'test', 'password' => 'test']);
        $form->validate();
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="username">Username</label>',
            '    <div class="control">',
            '      <input id="username" class="input" type="text" name="username" value="test" required="required"/>',
            '    </div>',
            '  </div>',
            '  <div class="field">',
            '    <label class="label" for="password">Password</label>',
            '    <div class="control">',
            '      <input id="password" class="input" type="password" name="password" value="test"/>',
            '    </div>',
            '  </div>',
            '  <div class="field">',
            '    <div class="control">',
            '      <input class="button is-primary" type="submit" value="Login"/>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(true, false));
    }

    public function testAddErrorsForm(): void
    {
        E::$style = 'bulma';
        $form = E::form([
            E::field(E::text('username')->required(), E::label('Username')),
            E::field(E::password('password'), E::label('Password')),
            E::field(E::submit('Login')),
        ]);
        $form->fill(['username' => 'test', 'password' => 'test']);
        $form->validate();
        $form->addErrors([
            'username' => 'Invalid username/password combination',
            'password' => 'Invalid username/password combination',
        ]);
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="username">Username</label>',
            '    <div class="control">',
            '      <input id="username" class="input is-danger" type="text" name="username" value="test" required="required"/>',
            '    </div>',
            '    <p class="help is-danger">Invalid username/password combination</p>',
            '  </div>',
            '  <div class="field">',
            '    <label class="label" for="password">Password</label>',
            '    <div class="control">',
            '      <input id="password" class="input is-danger" type="password" name="password" value="test"/>',
            '    </div>',
            '    <p class="help is-danger">Invalid username/password combination</p>',
            '  </div>',
            '  <div class="field">',
            '    <div class="control">',
            '      <input class="button is-primary" type="submit" value="Login"/>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(true, false));
    }
}

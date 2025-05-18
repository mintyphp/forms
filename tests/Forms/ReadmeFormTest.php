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
            E::field(E::text('username'), E::label('Username'), [V::required('Username is required')]),
            E::field(E::password('password'), E::label('Password')),
            E::field(E::submit('Login')),
        ]);
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="username">Username</label>',
            '    <input id="username" type="text" name="username" value=""/>',
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
            E::field(E::text('username'), E::label('Username'), [V::required('Username is required')]),
            E::field(E::password('password'), E::label('Password')),
            E::field(E::submit('Login')),
        ]);
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="username">Username</label>',
            '    <div class="control">',
            '      <input id="username" class="input" type="text" name="username" value=""/>',
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
}

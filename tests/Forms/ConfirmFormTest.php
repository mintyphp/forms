<?php

namespace MintyPHP\Tests\Forms;

use PHPUnit\Framework\TestCase;

use MintyPHP\Form\Form;
use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

class ConfirmFormTest extends TestCase
{
    private function createForm(string $style): Form
    {
        E::$style = $style;
        return E::form([
            E::field(E::label('I agree to the terms and conditions'), E::checkbox('confirm'), [V::required('Field must be checked')]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="confirm">I agree to the terms and conditions</label>',
            '    <input id="confirm" type="checkbox" name="confirm" value="on"/>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }

    public function testRenderBulma(): void
    {
        $form = $this->createForm('bulma');
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="checkbox"><input type="checkbox" name="confirm" value="on"/>I agree to the terms and conditions</label>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }

    public function testFillForm(): void
    {
        $form = $this->createForm('none');
        $form->fill(['confirm' => 'on']);
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="confirm">I agree to the terms and conditions</label>',
            '    <input id="confirm" type="checkbox" name="confirm" value="on" checked="checked"/>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['confirm' => '']);
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="confirm">I agree to the terms and conditions</label>',
            '    <input id="confirm" type="checkbox" name="confirm" value="on"/>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['confirm' => 'off']);
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill([]);
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }

    public function testValidators(): void
    {
        $form = $this->createForm('none');
        $form->fill(['confirm' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="error">',
            '    <label for="confirm">I agree to the terms and conditions</label>',
            '    <input id="confirm" type="checkbox" name="confirm" value="on"/>',
            '    <div>Field must be checked</div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['confirm' => 'in-between']);
        $this->assertFalse($form->validate());
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['confirm' => 'on']);
        $this->assertTrue($form->validate());
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="confirm">I agree to the terms and conditions</label>',
            '    <input id="confirm" type="checkbox" name="confirm" value="on" checked="checked"/>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }

    public function testValidatorsBulma(): void
    {
        $form = $this->createForm('bulma');
        $form->fill(['bool' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="checkbox"><input type="checkbox" name="confirm" value="on"/>I agree to the terms and conditions</label>',
            '    <p class="help is-danger">Field must be checked</p>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['confirm' => 'in-between']);
        $this->assertFalse($form->validate());
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['confirm' => 'on']);
        $this->assertTrue($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="checkbox"><input type="checkbox" name="confirm" value="on" checked="checked"/>I agree to the terms and conditions</label>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }
}

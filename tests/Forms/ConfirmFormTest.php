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
            E::field(E::checkbox('confirm')->required(), E::label('I agree to the terms and conditions'), [V::required('Field must be checked')]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<div>',
            '  <label for="confirm">I agree to the terms and conditions</label>',
            '  <input id="confirm" type="checkbox" name="confirm" value="on" required="required"/>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testRenderBulma(): void
    {
        $form = $this->createForm('bulma');
        $lines = [
            '<div class="field">',
            '  <label class="checkbox"><input type="checkbox" name="confirm" value="on" required="required"/>I agree to the terms and conditions</label>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testFillForm(): void
    {
        $form = $this->createForm('none');
        $form->fill(['confirm' => 'on']);
        $lines = [
            '<div>',
            '  <label for="confirm">I agree to the terms and conditions</label>',
            '  <input id="confirm" type="checkbox" name="confirm" value="on" checked="checked" required="required"/>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['confirm' => '']);
        $lines = [
            '<div>',
            '  <label for="confirm">I agree to the terms and conditions</label>',
            '  <input id="confirm" type="checkbox" name="confirm" value="on" required="required"/>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['confirm' => 'off']);
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill([]);
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testValidators(): void
    {
        $form = $this->createForm('none');
        $form->fill(['confirm' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="error">',
            '  <label for="confirm">I agree to the terms and conditions</label>',
            '  <input id="confirm" type="checkbox" name="confirm" value="on" required="required"/>',
            '  <div>Field must be checked</div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['confirm' => 'in-between']);
        $this->assertFalse($form->validate());
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['confirm' => 'on']);
        $this->assertTrue($form->validate());
        $lines = [
            '<div>',
            '  <label for="confirm">I agree to the terms and conditions</label>',
            '  <input id="confirm" type="checkbox" name="confirm" value="on" checked="checked" required="required"/>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testValidatorsBulma(): void
    {
        $form = $this->createForm('bulma');
        $form->fill(['bool' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="field">',
            '  <label class="checkbox"><input type="checkbox" name="confirm" value="on" required="required"/>I agree to the terms and conditions</label>',
            '  <p class="help is-danger">Field must be checked</p>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['confirm' => 'in-between']);
        $this->assertFalse($form->validate());
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['confirm' => 'on']);
        $this->assertTrue($form->validate());
        $lines = [
            '<div class="field">',
            '  <label class="checkbox"><input type="checkbox" name="confirm" value="on" checked="checked" required="required"/>I agree to the terms and conditions</label>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }
}

<?php

namespace MintyPHP\Tests\Forms;

use PHPUnit\Framework\TestCase;

use MintyPHP\Form\Form;
use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

class BooleanFormTest extends TestCase
{
    private function createForm(string $style): Form
    {
        $booleans = [
            'yes' => 'Yes',
            'no' => 'No',
        ];
        E::$style = $style;
        return E::form([
            E::field(E::select('bool', $booleans)->required(), E::label('Yes or No?'), [V::required('Field cannot be empty')]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<div>',
            '  <label for="bool">Yes or No?</label>',
            '  <select id="bool" name="bool" required="required">',
            '    <option value="">...</option>',
            '    <option value="yes">Yes</option>',
            '    <option value="no">No</option>',
            '  </select>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testRenderBulma(): void
    {
        $form = $this->createForm('bulma');
        $lines = [
            '<div class="field">',
            '  <label class="label" for="bool">Yes or No?</label>',
            '  <div class="select">',
            '    <select id="bool" name="bool" required="required">',
            '      <option value="">...</option>',
            '      <option value="yes">Yes</option>',
            '      <option value="no">No</option>',
            '    </select>',
            '  </div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testFillForm(): void
    {
        $form = $this->createForm('none');
        $form->fill(['bool' => 'yes']);
        $lines = [
            '<div>',
            '  <label for="bool">Yes or No?</label>',
            '  <select id="bool" name="bool" required="required">',
            '    <option value="">...</option>',
            '    <option value="yes" selected="selected">Yes</option>',
            '    <option value="no">No</option>',
            '  </select>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testValidators(): void
    {
        $form = $this->createForm('none');
        $form->fill(['bool' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="error">',
            '  <label for="bool">Yes or No?</label>',
            '  <select id="bool" name="bool" required="required">',
            '    <option value="" selected="selected">...</option>',
            '    <option value="yes">Yes</option>',
            '    <option value="no">No</option>',
            '  </select>',
            '  <div>Field cannot be empty</div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['bool' => 'in-between']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="error">',
            '  <label for="bool">Yes or No?</label>',
            '  <select id="bool" name="bool" required="required">',
            '    <option value="">...</option>',
            '    <option value="yes">Yes</option>',
            '    <option value="no">No</option>',
            '  </select>',
            '  <div>Invalid option value</div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['bool' => 'no']);
        $this->assertTrue($form->validate());
        $lines = [
            '<div>',
            '  <label for="bool">Yes or No?</label>',
            '  <select id="bool" name="bool" required="required">',
            '    <option value="">...</option>',
            '    <option value="yes">Yes</option>',
            '    <option value="no" selected="selected">No</option>',
            '  </select>',
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
            '  <label class="label" for="bool">Yes or No?</label>',
            '  <div class="select is-danger">',
            '    <select id="bool" name="bool" required="required">',
            '      <option value="" selected="selected">...</option>',
            '      <option value="yes">Yes</option>',
            '      <option value="no">No</option>',
            '    </select>',
            '  </div>',
            '  <p class="help is-danger">Field cannot be empty</p>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['bool' => 'in-between']);
        $this->assertFalse($form->validate());
        $lines = [
            '<div class="field">',
            '  <label class="label" for="bool">Yes or No?</label>',
            '  <div class="select is-danger">',
            '    <select id="bool" name="bool" required="required">',
            '      <option value="">...</option>',
            '      <option value="yes">Yes</option>',
            '      <option value="no">No</option>',
            '    </select>',
            '  </div>',
            '  <p class="help is-danger">Invalid option value</p>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
        $form->fill(['bool' => 'no']);
        $this->assertTrue($form->validate());
        $lines = [
            '<div class="field">',
            '  <label class="label" for="bool">Yes or No?</label>',
            '  <div class="select">',
            '    <select id="bool" name="bool" required="required">',
            '      <option value="">...</option>',
            '      <option value="yes">Yes</option>',
            '      <option value="no" selected="selected">No</option>',
            '    </select>',
            '  </div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }
}

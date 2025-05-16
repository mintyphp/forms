<?php

namespace MintyPHP\Tests\Forms;

use PHPUnit\Framework\TestCase;

use MintyPHP\Form\Form;
use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

class CountryFormTest extends TestCase
{
    private function createForm(string $style): Form
    {
        $countries = [
            'BE' => 'Belgium',
            'FR' => 'France',
            'DE' => 'Germany',
            'IE' => 'Ireland',
            'IT' => 'Italy',
            'LU' => 'Luxembourg',
            'NL' => 'Netherlands',
            'PT' => 'Portugal',
            'ES' => 'Spain',
            'SE' => 'Sweden',
        ];
        E::$style = $style;
        return E::form()->fields([
            E::field()
                ->label(E::label('Choose countries'))
                ->control(E::checkboxes('countries', $countries))
                ->validators([
                    V::required('Field cannot be empty'),
                ]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="bool">Yes or No?</label>',
            '    <select id="bool" name="bool">',
            '      <option value="" selected="selected">Select an option</option>',
            '      <option value="yes">Yes</option>',
            '      <option value="no">No</option>',
            '    </select>',
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
            '    <label class="label" for="bool">Yes or No?</label>',
            '    <div class="select">',
            '      <select id="bool" name="bool">',
            '        <option value="" selected="selected">Select an option</option>',
            '        <option value="yes">Yes</option>',
            '        <option value="no">No</option>',
            '      </select>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }

    public function testFillForm(): void
    {
        $form = $this->createForm('none');
        $form->fill(['bool' => 'yes']);
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="bool">Yes or No?</label>',
            '    <select id="bool" name="bool">',
            '      <option value="">Select an option</option>',
            '      <option value="yes" selected="selected">Yes</option>',
            '      <option value="no">No</option>',
            '    </select>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }

    public function testValidators(): void
    {
        $form = $this->createForm('none');
        $form->fill(['bool' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="error">',
            '    <label for="bool">Yes or No?</label>',
            '    <select id="bool" name="bool">',
            '      <option value="" selected="selected">Select an option</option>',
            '      <option value="yes">Yes</option>',
            '      <option value="no">No</option>',
            '    </select>',
            '    <div>Field cannot be empty</div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
        $form->fill(['bool' => 'in-between']);
        $this->assertFalse($form->validate());
        $this->assertEquals(implode("\n", $lines), $form->__toString());
        $form->fill(['bool' => 'no']);
        $this->assertTrue($form->validate());
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="bool">Yes or No?</label>',
            '    <select id="bool" name="bool">',
            '      <option value="">Select an option</option>',
            '      <option value="yes">Yes</option>',
            '      <option value="no" selected="selected">No</option>',
            '    </select>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }

    public function testValidatorsBulma(): void
    {
        $form = $this->createForm('bulma');
        $form->fill(['bool' => '']);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="bool">Yes or No?</label>',
            '    <div class="select is-danger">',
            '      <select id="bool" name="bool">',
            '        <option value="" selected="selected">Select an option</option>',
            '        <option value="yes">Yes</option>',
            '        <option value="no">No</option>',
            '      </select>',
            '    </div>',
            '    <p class="help is-danger">Field cannot be empty</p>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
        $form->fill(['bool' => 'in-between']);
        $this->assertFalse($form->validate());
        $this->assertEquals(implode("\n", $lines), $form->__toString());
        $form->fill(['bool' => 'no']);
        $this->assertTrue($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label" for="bool">Yes or No?</label>',
            '    <div class="select">',
            '      <select id="bool" name="bool">',
            '        <option value="">Select an option</option>',
            '        <option value="yes">Yes</option>',
            '        <option value="no" selected="selected">No</option>',
            '      </select>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->__toString());
    }
}

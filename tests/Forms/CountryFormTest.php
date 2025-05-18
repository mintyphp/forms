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
        return E::form([
            E::field(E::label('Choose countries'), E::checkboxes('countries', $countries), [V::required('Field cannot be empty')]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="countries">Choose countries</label>',
            '    <fieldset id="countries">',
            '      <input id="countries_BE" name="countries" value="BE"/>',
            '      <label for="countries_BE">Belgium</label>',
            '      <input id="countries_FR" name="countries" value="FR"/>',
            '      <label for="countries_FR">France</label>',
            '      <input id="countries_DE" name="countries" value="DE"/>',
            '      <label for="countries_DE">Germany</label>',
            '      <input id="countries_IE" name="countries" value="IE"/>',
            '      <label for="countries_IE">Ireland</label>',
            '      <input id="countries_IT" name="countries" value="IT"/>',
            '      <label for="countries_IT">Italy</label>',
            '      <input id="countries_LU" name="countries" value="LU"/>',
            '      <label for="countries_LU">Luxembourg</label>',
            '      <input id="countries_NL" name="countries" value="NL"/>',
            '      <label for="countries_NL">Netherlands</label>',
            '      <input id="countries_PT" name="countries" value="PT"/>',
            '      <label for="countries_PT">Portugal</label>',
            '      <input id="countries_ES" name="countries" value="ES"/>',
            '      <label for="countries_ES">Spain</label>',
            '      <input id="countries_SE" name="countries" value="SE"/>',
            '      <label for="countries_SE">Sweden</label>',
            '    </fieldset>',
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
            '    <label class="label">Choose countries</label>',
            '    <div class="checkboxes">',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="BE"/>Belgium</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="FR"/>France</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="DE"/>Germany</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="IE"/>Ireland</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="IT"/>Italy</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="LU"/>Luxembourg</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="NL"/>Netherlands</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="PT"/>Portugal</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="ES"/>Spain</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="SE"/>Sweden</label>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }

    public function testFillForm(): void
    {
        $form = $this->createForm('none');
        $form->fill(['countries' => 'DE']);
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="countries">Choose countries</label>',
            '    <fieldset id="countries">',
            '      <input id="countries_BE" name="countries" value="BE"/>',
            '      <label for="countries_BE">Belgium</label>',
            '      <input id="countries_FR" name="countries" value="FR"/>',
            '      <label for="countries_FR">France</label>',
            '      <input id="countries_DE" name="countries" value="DE" checked="checked"/>',
            '      <label for="countries_DE">Germany</label>',
            '      <input id="countries_IE" name="countries" value="IE"/>',
            '      <label for="countries_IE">Ireland</label>',
            '      <input id="countries_IT" name="countries" value="IT"/>',
            '      <label for="countries_IT">Italy</label>',
            '      <input id="countries_LU" name="countries" value="LU"/>',
            '      <label for="countries_LU">Luxembourg</label>',
            '      <input id="countries_NL" name="countries" value="NL"/>',
            '      <label for="countries_NL">Netherlands</label>',
            '      <input id="countries_PT" name="countries" value="PT"/>',
            '      <label for="countries_PT">Portugal</label>',
            '      <input id="countries_ES" name="countries" value="ES"/>',
            '      <label for="countries_ES">Spain</label>',
            '      <input id="countries_SE" name="countries" value="SE"/>',
            '      <label for="countries_SE">Sweden</label>',
            '    </fieldset>',
            '  </div>',
            '</form>',
        ];
        $form->fill(['countries' => ['BE', 'DE']]);
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="countries">Choose countries</label>',
            '    <fieldset id="countries">',
            '      <input id="countries_BE" name="countries" value="BE" checked="checked"/>',
            '      <label for="countries_BE">Belgium</label>',
            '      <input id="countries_FR" name="countries" value="FR"/>',
            '      <label for="countries_FR">France</label>',
            '      <input id="countries_DE" name="countries" value="DE" checked="checked"/>',
            '      <label for="countries_DE">Germany</label>',
            '      <input id="countries_IE" name="countries" value="IE"/>',
            '      <label for="countries_IE">Ireland</label>',
            '      <input id="countries_IT" name="countries" value="IT"/>',
            '      <label for="countries_IT">Italy</label>',
            '      <input id="countries_LU" name="countries" value="LU"/>',
            '      <label for="countries_LU">Luxembourg</label>',
            '      <input id="countries_NL" name="countries" value="NL"/>',
            '      <label for="countries_NL">Netherlands</label>',
            '      <input id="countries_PT" name="countries" value="PT"/>',
            '      <label for="countries_PT">Portugal</label>',
            '      <input id="countries_ES" name="countries" value="ES"/>',
            '      <label for="countries_ES">Spain</label>',
            '      <input id="countries_SE" name="countries" value="SE"/>',
            '      <label for="countries_SE">Sweden</label>',
            '    </fieldset>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }

    public function testValidators(): void
    {
        $form = $this->createForm('none');
        $form->fill(['countries' => []]);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="error">',
            '    <label for="countries">Choose countries</label>',
            '    <fieldset id="countries">',
            '      <input id="countries_BE" name="countries" value="BE"/>',
            '      <label for="countries_BE">Belgium</label>',
            '      <input id="countries_FR" name="countries" value="FR"/>',
            '      <label for="countries_FR">France</label>',
            '      <input id="countries_DE" name="countries" value="DE"/>',
            '      <label for="countries_DE">Germany</label>',
            '      <input id="countries_IE" name="countries" value="IE"/>',
            '      <label for="countries_IE">Ireland</label>',
            '      <input id="countries_IT" name="countries" value="IT"/>',
            '      <label for="countries_IT">Italy</label>',
            '      <input id="countries_LU" name="countries" value="LU"/>',
            '      <label for="countries_LU">Luxembourg</label>',
            '      <input id="countries_NL" name="countries" value="NL"/>',
            '      <label for="countries_NL">Netherlands</label>',
            '      <input id="countries_PT" name="countries" value="PT"/>',
            '      <label for="countries_PT">Portugal</label>',
            '      <input id="countries_ES" name="countries" value="ES"/>',
            '      <label for="countries_ES">Spain</label>',
            '      <input id="countries_SE" name="countries" value="SE"/>',
            '      <label for="countries_SE">Sweden</label>',
            '    </fieldset>',
            '    <div>Field cannot be empty</div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['countries' => ['USA']]);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="error">',
            '    <label for="countries">Choose countries</label>',
            '    <fieldset id="countries">',
            '      <input id="countries_BE" name="countries" value="BE"/>',
            '      <label for="countries_BE">Belgium</label>',
            '      <input id="countries_FR" name="countries" value="FR"/>',
            '      <label for="countries_FR">France</label>',
            '      <input id="countries_DE" name="countries" value="DE"/>',
            '      <label for="countries_DE">Germany</label>',
            '      <input id="countries_IE" name="countries" value="IE"/>',
            '      <label for="countries_IE">Ireland</label>',
            '      <input id="countries_IT" name="countries" value="IT"/>',
            '      <label for="countries_IT">Italy</label>',
            '      <input id="countries_LU" name="countries" value="LU"/>',
            '      <label for="countries_LU">Luxembourg</label>',
            '      <input id="countries_NL" name="countries" value="NL"/>',
            '      <label for="countries_NL">Netherlands</label>',
            '      <input id="countries_PT" name="countries" value="PT"/>',
            '      <label for="countries_PT">Portugal</label>',
            '      <input id="countries_ES" name="countries" value="ES"/>',
            '      <label for="countries_ES">Spain</label>',
            '      <input id="countries_SE" name="countries" value="SE"/>',
            '      <label for="countries_SE">Sweden</label>',
            '    </fieldset>',
            '    <div>Invalid checkbox value</div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['countries' => ['BE', 'DE']]);
        $this->assertTrue($form->validate());
        $lines = [
            '<form method="post">',
            '  <div>',
            '    <label for="countries">Choose countries</label>',
            '    <fieldset id="countries">',
            '      <input id="countries_BE" name="countries" value="BE" checked="checked"/>',
            '      <label for="countries_BE">Belgium</label>',
            '      <input id="countries_FR" name="countries" value="FR"/>',
            '      <label for="countries_FR">France</label>',
            '      <input id="countries_DE" name="countries" value="DE" checked="checked"/>',
            '      <label for="countries_DE">Germany</label>',
            '      <input id="countries_IE" name="countries" value="IE"/>',
            '      <label for="countries_IE">Ireland</label>',
            '      <input id="countries_IT" name="countries" value="IT"/>',
            '      <label for="countries_IT">Italy</label>',
            '      <input id="countries_LU" name="countries" value="LU"/>',
            '      <label for="countries_LU">Luxembourg</label>',
            '      <input id="countries_NL" name="countries" value="NL"/>',
            '      <label for="countries_NL">Netherlands</label>',
            '      <input id="countries_PT" name="countries" value="PT"/>',
            '      <label for="countries_PT">Portugal</label>',
            '      <input id="countries_ES" name="countries" value="ES"/>',
            '      <label for="countries_ES">Spain</label>',
            '      <input id="countries_SE" name="countries" value="SE"/>',
            '      <label for="countries_SE">Sweden</label>',
            '    </fieldset>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }

    public function testValidatorsBulma(): void
    {
        $form = $this->createForm('bulma');
        $form->fill(['countries' => []]);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label">Choose countries</label>',
            '    <div class="checkboxes is-danger">',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="BE"/>Belgium</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="FR"/>France</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="DE"/>Germany</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="IE"/>Ireland</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="IT"/>Italy</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="LU"/>Luxembourg</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="NL"/>Netherlands</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="PT"/>Portugal</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="ES"/>Spain</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="SE"/>Sweden</label>',
            '    </div>',
            '    <p class="help is-danger">Field cannot be empty</p>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['countries' => ['USA']]);
        $this->assertFalse($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label">Choose countries</label>',
            '    <div class="checkboxes is-danger">',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="BE"/>Belgium</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="FR"/>France</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="DE"/>Germany</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="IE"/>Ireland</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="IT"/>Italy</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="LU"/>Luxembourg</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="NL"/>Netherlands</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="PT"/>Portugal</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="ES"/>Spain</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="SE"/>Sweden</label>',
            '    </div>',
            '    <p class="help is-danger">Invalid checkbox value</p>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
        $form->fill(['countries' => ['BE', 'DE']]);
        $this->assertTrue($form->validate());
        $lines = [
            '<form method="post">',
            '  <div class="field">',
            '    <label class="label">Choose countries</label>',
            '    <div class="checkboxes">',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="BE" checked="checked"/>Belgium</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="FR"/>France</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="DE" checked="checked"/>Germany</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="IE"/>Ireland</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="IT"/>Italy</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="LU"/>Luxembourg</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="NL"/>Netherlands</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="PT"/>Portugal</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="ES"/>Spain</label>',
            '      <label class="checkbox"><input type="checkbox" name="countries" value="SE"/>Sweden</label>',
            '    </div>',
            '  </div>',
            '</form>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString());
    }
}

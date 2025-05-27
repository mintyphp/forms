<?php

namespace MintyPHP\Tests\Forms;

use PHPUnit\Framework\TestCase;

use MintyPHP\Form\Form;
use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

class SourceFormTest extends TestCase
{
    private function createForm(string $style): Form
    {
        $sources = [
            'Ad',
            'Blog',
            'Magazine',
            'Newspaper',
        ];
        E::$style = $style;
        return E::form([
            E::field(E::text('source')->options($sources), E::label('How did you hear about us?'), [V::required('Field cannot be empty')]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<div>',
            '  <label for="source">How did you hear about us?</label>',
            '  <div>',
            '    <input id="source" type="text" name="source" value="" list="source-options"/>',
            '    <datalist id="source-options">',
            '      <option>Ad</option>',
            '      <option>Blog</option>',
            '      <option>Magazine</option>',
            '      <option>Newspaper</option>',
            '    </datalist>',
            '  </div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }

    public function testRenderBulma(): void
    {
        $form = $this->createForm('bulma');
        $lines = [
            '<div class="field">',
            '  <label class="label" for="source">How did you hear about us?</label>',
            '  <div class="control">',
            '    <input id="source" class="input" type="text" name="source" value="" list="source-options"/>',
            '    <datalist id="source-options">',
            '      <option>Ad</option>',
            '      <option>Blog</option>',
            '      <option>Magazine</option>',
            '      <option>Newspaper</option>',
            '    </datalist>',
            '  </div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }
}

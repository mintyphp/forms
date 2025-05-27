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
            E::field(E::text('sources')->options($sources), E::label('How did you hear about us?'), [V::required('Field cannot be empty')]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<div>',
            '  <label for="sources">How did you hear about us?</label>',
            '  <div>',
            '    <input id="sources" type="text" name="sources" value="" list="sources-options"/>',
            '    <datalist id="sources-options">',
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
            '  <label class="label" for="sources">How did you hear about us?</label>',
            '  <div class="control">',
            '    <input id="sources" class="input" type="text" name="sources" value="" list="sources-options"/>',
            '    <datalist id="sources-options">',
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

<?php

namespace MintyPHP\Tests\Forms;

use PHPUnit\Framework\TestCase;

use MintyPHP\Form\Form;
use MintyPHP\Form\Elements as E;
use MintyPHP\Form\Validator\Validators as V;

class DifferentFormTest extends TestCase
{
    private function createForm(string $style): Form
    {
        $sources = [
            'ad' => 'Ad',
            'blog' => 'Blog',
            'magazine' => 'Magazine',
            'newspaper' => 'Newspaper',
        ];
        E::$style = $style;
        return E::form([
            E::field(E::selectOrType('source', $sources, 'Different ...'), E::label('How did you find us?'), [V::required('Field cannot be empty')]),
        ]);
    }

    public function testRenderForm(): void
    {
        $form = $this->createForm('none');
        $lines = [
            '<div>',
            '  <label for="source">How did you find us?</label>',
            '  <select id="source" name="source" onchange="var last=this.options[this.options.length-1]; var hasPrevious=last.previousSibling.nodeName==\'HR\'; if (this.options.length-1==this.selectedIndex) { var str=prompt(last.text,last.previousSibling.text); if (str) { if (hasPrevious) { opt=document.createElement(\'option\'); this.insertBefore(opt, last); } else { opt=last.previousSibling; } opt.value=opt.text=str; this.selectedIndex-=1; } else { this.selectedIndex=this.dataset.lastIndex; } } this.dataset.lastIndex=this.selectedIndex;">',
            '    <option value="" selected="selected">...</option>',
            '    <option value="ad">Ad</option>',
            '    <option value="blog">Blog</option>',
            '    <option value="magazine">Magazine</option>',
            '    <option value="newspaper">Newspaper</option>',
            '    <hr/>',
            '    <option value="!type!">Different ...</option>',
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
            '  <label class="label" for="source">How did you find us?</label>',
            '  <div class="select">',
            '    <select id="source" name="source" onchange="var last=this.options[this.options.length-1]; var hasPrevious=last.previousSibling.nodeName==\'HR\'; if (this.options.length-1==this.selectedIndex) { var str=prompt(last.text,last.previousSibling.text); if (str) { if (hasPrevious) { opt=document.createElement(\'option\'); this.insertBefore(opt, last); } else { opt=last.previousSibling; } opt.value=opt.text=str; this.selectedIndex-=1; } else { this.selectedIndex=this.dataset.lastIndex; } } this.dataset.lastIndex=this.selectedIndex;">',
            '      <option value="" selected="selected">...</option>',
            '      <option value="ad">Ad</option>',
            '      <option value="blog">Blog</option>',
            '      <option value="magazine">Magazine</option>',
            '      <option value="newspaper">Newspaper</option>',
            '      <hr/>',
            '      <option value="!type!">Different ...</option>',
            '    </select>',
            '  </div>',
            '</div>',
        ];
        $this->assertEquals(implode("\n", $lines), $form->toString(false, false));
    }
}

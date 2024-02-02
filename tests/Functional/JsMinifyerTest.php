<?php

namespace JuanchoSL\AssetMinifyer\Tests\Functional;

use JuanchoSL\AssetMinifyer\Adapters\Minifyer;
use PHPUnit\Framework\TestCase;

class JsMinifyerTest extends TestCase
{
    public function testMinifier()
    {
        $js = "
        var variable = 'variable';
        ";
        $content = (new Minifyer)->cleanJs($js);
        $this->assertLessThan(strlen($js), strlen($content));
    }
    public function testRemoveComments()
    {
        $js = "
        //comentarios
        var variable = 'variable';
        ";
        $content = (new Minifyer)->cleanJs($js);
        $this->assertStringNotContainsString('//comentarios', $content);
    }
    public function testRemoveSpaces()
    {
        $js = "
        var variable = 'variable';
        ";
        $content = (new Minifyer)->cleanJs($js);
        $this->assertStringNotContainsString(' = ', $content);
    }
    public function testRemoveExtraSpaces()
    {
        $js = "
        var variable  = 'variable';
        ";
        $content = (new Minifyer)->cleanJs($js);
        $this->assertStringNotContainsString('  ', $content);
    }
}
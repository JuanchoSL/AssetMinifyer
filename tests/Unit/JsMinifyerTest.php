<?php

namespace JuanchoSL\AssetMinifyer\Tests\Unit;

use JuanchoSL\AssetMinifyer\Drivers\JSMin;
use PHPUnit\Framework\TestCase;

class JsMinifyerTest extends TestCase
{
    public function testMinifier()
    {
        $js = "
        var variable = 'variable';
        ";
        $content = JSMin::minify($js);
        $this->assertLessThan(strlen($js), strlen($content));
    }
    public function testRemoveComments()
    {
        $js = "
        //comentarios
        var variable = 'variable';
        ";
        $content = JSMin::minify($js);
        $this->assertStringNotContainsString('//comentarios', $content);
    }
    public function testRemoveSpaces()
    {
        $js = "
        var variable = 'variable';
        ";
        $content = JSMin::minify($js);
        $this->assertStringNotContainsString(' = ', $content);
    }
    public function testRemoveExtraSpaces()
    {
        $js = "
        var variable  = 'variable';
        ";
        $content = JSMin::minify($js);
        $this->assertStringNotContainsString('  ', $content);
    }
}
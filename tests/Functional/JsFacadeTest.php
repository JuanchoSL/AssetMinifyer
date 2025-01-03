<?php

namespace JuanchoSL\AssetMinifyer\Tests\Functional;

use JuanchoSL\AssetMinifyer\Drivers\JShrinkMin;
use JuanchoSL\AssetMinifyer\Facades\Minifier;
use PHPUnit\Framework\TestCase;

class JsFacadeTest extends TestCase
{

    protected $minifier;

    protected function setUp(): void
    {
        $this->minifier = new Minifier(new JShrinkMin());
    }
    public function testMinifier()
    {
        $js = "
        var variable = 'variable';
        ";
        $content = (string) $this->minifier->addContent($js);
        $this->assertLessThan(strlen($js), strlen($content));
    }
    public function testRemoveComments()
    {
        $js = "
        //comentarios
        var variable = 'variable';
        ";
        $content = (string) $this->minifier->addContent($js);
        $this->assertStringNotContainsString('//comentarios', $content);
    }
    public function testRemoveSpaces()
    {
        $js = "
        var variable = 'variable';
        ";
        $content = (string) $this->minifier->addContent($js);
        $this->assertStringNotContainsString(' = ', $content);
    }
    public function testRemoveExtraSpaces()
    {
        $js = "
        var variable  = 'variable';
        ";
        $content = (string) $this->minifier->addContent($js);
        $this->assertStringNotContainsString('  ', $content);
    }
}
<?php

namespace JuanchoSL\AssetMinifyer\Tests\Unit;

use JuanchoSL\AssetMinifyer\Adapters\Minifyer;
use PHPUnit\Framework\TestCase;

class CssMinifyerTest extends TestCase
{
    public function testMinifier()
    {
        $css = "
        body {
            color: black;
        }
        ";
        $content = (new Minifyer)->cleanCss($css);
        $this->assertLessThan(strlen($css), strlen($content));
    }
    public function testRemoveLineComments()
    {
        $css = "
        //reset
        body {
            color: black;
        }
        ";
        $content = (new Minifyer)->cleanCss($css);
        $this->assertStringNotContainsString('\//reset', $content);
    }
    public function testRemoveLinesComments()
    {
        $css = "
        /* reset */
        body {
            color: black;
        }
        ";
        $content = (new Minifyer)->cleanCss($css);
        $this->assertStringNotContainsString('\/* reset *\/', $content);
    }
    public function testRemoveSpaces()
    {
        $css = "
        body {
            color: black;
        }
        ";
        $content = (new Minifyer)->cleanCss($css);
        $this->assertStringNotContainsString(': ', $content);
    }
    public function testRemoveExtraSpaces()
    {
        $css = "
        body  {
            color: black;
        }
        ";
        $content = (new Minifyer)->cleanCss($css);
        $this->assertStringNotContainsString('  ', $content);
    }
}
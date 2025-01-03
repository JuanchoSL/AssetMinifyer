<?php

namespace JuanchoSL\AssetMinifyer\Tests\Functional;

use JuanchoSL\AssetMinifyer\Drivers\CSSMin;
use JuanchoSL\AssetMinifyer\Facades\Minifier;
use PHPUnit\Framework\TestCase;

class CssFacadeTest extends TestCase
{

    protected $minifier;

    protected function setUp(): void
    {
        $this->minifier = new Minifier(new CSSMin());
    }
    public function testMinifier()
    {
        $css = "
        body {
            color: black;
        }
        ";
        $content = (string) $this->minifier->addContent($css);
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
        $content = (string) $this->minifier->addContent($css);
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
        $content = (string) $this->minifier->addContent($css);
        $this->assertStringNotContainsString('\/* reset *\/', $content);
    }
    public function testRemoveSpaces()
    {
        $css = "
        body {
            color: black;
        }
        ";
        $content = (string) $this->minifier->addContent($css);
        $this->assertStringNotContainsString(': ', $content);
    }
    public function testRemoveExtraSpaces()
    {
        $css = "
        body  {
            color: black;
        }
        ";
        $content = (string) $this->minifier->addContent($css);
        $this->assertStringNotContainsString('  ', $content);
    }
}
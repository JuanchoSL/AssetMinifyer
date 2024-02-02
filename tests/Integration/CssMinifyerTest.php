<?php

namespace JuanchoSL\AssetMinifyer\Tests\Integration;

use JuanchoSL\AssetMinifyer\Adapters\Minifyer;
use JuanchoSL\Exceptions\NotFoundException;
use JuanchoSL\Exceptions\UnprocessableEntityException;
use JuanchoSL\Exceptions\UnsupportedMediaTypeException;
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
        $temporal_file = implode(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), str_replace(__NAMESPACE__, "", __CLASS__)]) . '.css';
        file_put_contents($temporal_file, $css, FILE_APPEND | LOCK_EX);
        $content = (new Minifyer)->addFile($temporal_file)->getContent();
        $this->assertLessThan(strlen($css), strlen($content));
        unlink($temporal_file);
    }
    public function testRemoveLineComments()
    {
        $css = "
        //reset
        body {
            color: black;
        }
        ";
        $temporal_file = implode(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), str_replace(__NAMESPACE__, "", __CLASS__)]) . '.css';
        file_put_contents($temporal_file, $css, FILE_APPEND | LOCK_EX);
        $content = (new Minifyer)->addFile($temporal_file)->getContent();
        $this->assertStringNotContainsString('\//reset', $content);
        unlink($temporal_file);
    }
    public function testRemoveLinesComments()
    {
        $css = "
        /* reset */
        body {
            color: black;
        }
        ";
        $temporal_file = implode(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), str_replace(__NAMESPACE__, "", __CLASS__)]) . '.css';
        file_put_contents($temporal_file, $css, FILE_APPEND | LOCK_EX);
        $content = (new Minifyer)->addFile($temporal_file)->getContent();
        $this->assertStringNotContainsString('\/* reset *\/', $content);
        unlink($temporal_file);
    }
    public function testRemoveSpaces()
    {
        $css = "
        body {
            color: black;
        }
        ";
        $temporal_file = implode(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), str_replace(__NAMESPACE__, "", __CLASS__)]) . '.css';
        file_put_contents($temporal_file, $css, FILE_APPEND | LOCK_EX);
        $content = (new Minifyer)->addFile($temporal_file)->getContent();
        $this->assertStringNotContainsString(': ', $content);
        unlink($temporal_file);
    }
    public function testRemoveExtraSpaces()
    {
        $css = "
        body  {
            color: black;
        }
        ";
        $temporal_file = implode(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), str_replace(__NAMESPACE__, "", __CLASS__)]) . '.css';
        file_put_contents($temporal_file, $css, FILE_APPEND | LOCK_EX);
        $content = (new Minifyer)->addFile($temporal_file)->getContent();
        $this->assertStringNotContainsString('  ', $content);
        unlink($temporal_file);
    }

    public function testFileNotFound()
    {
        $this->expectException(NotFoundException::class);
        (new Minifyer)->addFile(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'fail_file')->getContent();
    }
    public function testFileEmpty()
    {
        $temporal_file = implode(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), str_replace(__NAMESPACE__, "", __CLASS__)]) . '.css';
        file_put_contents($temporal_file, '', FILE_APPEND | LOCK_EX);
        $this->expectException(UnprocessableEntityException::class);
        try {
            (new Minifyer)->addFile($temporal_file)->getContent();
        } finally {
            unlink($temporal_file);
        }
    }
    public function testFileUnsupported()
    {
        $temporal_file = implode(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), str_replace(__NAMESPACE__, "", __CLASS__)]) . '.txt';
        file_put_contents($temporal_file, 'text', FILE_APPEND | LOCK_EX);
        $this->expectException(UnsupportedMediaTypeException::class);
        try {
            (new Minifyer)->addFile($temporal_file)->getContent();
        } finally {
            unlink($temporal_file);
        }
    }
}
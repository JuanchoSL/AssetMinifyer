<?php

declare(strict_types=1);

namespace JuanchoSL\AssetMinifyer\Drivers;

use JuanchoSL\AssetMinifyer\Contracts\MinifyerInterface;

class CSSMin implements MinifyerInterface
{

    protected string $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    /**
     * Elimina los comentarios de una cadena, que puede ser código php
     * @param string $str Cadena a ser limpiada
     * @return string cadena limpiada sin comentarios
     */
    protected function removeComments(string $str): string
    {
        $str = preg_replace(
            array(
                // eliminate single line comments in '// ...' form
                '#^\s*//(.+)$#m',
                // eliminate multi-line comments in '/* ... */' form, at multiline
                '#\s*/\*(.+)\*/\s*#Us',
                // eliminate multi-line comments in '/* ... */' form, at start of string
                '#^\s*/\*(.+)\*/#Us',
                // eliminate multi-line comments in '/* ... */' form, at end of string
                '#/\*(.+)\*/\s*$#Us'
            ),
            '',
            $str
        );
        // eliminate extraneous space
        return trim($str ?? '');
    }

    protected function removeEndLines(string $str): string
    {
        $str = preg_replace(array("/(\r|\n|\t)/", "/\s{2,}/"), " ", $str);
        return trim($str ?? '');
    }

    protected function removeExtraSpaces(string $str): string
    {
        foreach ([': ', '{ ', ' }', '; ', ' :', ' {', '} ', ' ;', ', ', ' ,', ' "', '" ', " '", "' ", " (", " )", "( ", ") ", " =", "= "] as $search) {
            $str = str_replace($search, trim($search), $str);
        }
        return trim($str);
    }

    public function min(): string
    {
        $content = $this->input;
        $content = $this->removeComments($content);
        $content = $this->removeEndLines($content);
        $content = $this->removeExtraSpaces($content);
        return $content;
    }

    public static function minify(string $content): string
    {
        $obj = new CSSMin($content);
        return $obj->min();
    }

}
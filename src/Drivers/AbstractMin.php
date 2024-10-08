<?php

declare(strict_types=1);

namespace JuanchoSL\AssetMinifyer\Drivers;
class AbstractMin
{
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
        $str = str_replace(' and(', ' and (', $str);
        return trim($str);
    }
}
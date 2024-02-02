<?php

namespace JuanchoSL\AssetMinifyer\Contracts;

interface MinifyerInterface
{
    public static function minify(string $sontent): string;
}
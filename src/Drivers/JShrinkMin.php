<?php

declare(strict_types=1);

namespace JuanchoSL\AssetMinifyer\Drivers;

use JuanchoSL\AssetMinifyer\Contracts\MinifyerInterface;
use JShrink\Minifier;

class JShrinkMin implements MinifyerInterface
{


    public static function minify(string $content): string
    {
        return Minifier::minify($content);
    }

}
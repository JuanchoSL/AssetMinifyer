<?php

declare(strict_types=1);

namespace JuanchoSL\AssetMinifyer\Drivers;

use JuanchoSL\AssetMinifyer\Contracts\MinifyerInterface;
use JShrink\Minifier;

class JShrinkMin extends AbstractMin implements MinifyerInterface
{

    public function min(string $content): string
    {
        $content = Minifier::minify($content);
        $content = $this->removeComments($content);
        //$content = $this->removeEndLines($content);
        //$content = $this->removeExtraSpaces($content);
        return $content;
    }

    public static function minify(string $content): string
    {
        $obj = new JShrinkMin();
        return $obj->min($content);
    }

}
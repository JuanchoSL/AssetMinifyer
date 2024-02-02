<?php

declare(strict_types=1);

namespace JuanchoSL\AssetMinifyer\Adapters;

use JuanchoSL\AssetMinifyer\Drivers\CSSMin;
use JuanchoSL\AssetMinifyer\Drivers\JSMin;
use JuanchoSL\Exceptions\NotFoundException;
use JuanchoSL\Exceptions\UnprocessableEntityException;
use JuanchoSL\Exceptions\UnsupportedMediaTypeException;

class Minifyer
{

    private string $content = "";

    protected function addContent(string $content): self
    {
        if ($this->content != "") {
            $this->content .= PHP_EOL;
        }
        $this->content .= $content;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function addFile(string $file): self
    {
        if (!file_exists($file)) {
            throw new NotFoundException("The file '{$file}' does not exists");
        }
        $content = file_get_contents($file);
        if (!empty($content)) {
            switch (strtolower(pathinfo($file, PATHINFO_EXTENSION))) {
                case 'js':
                    $content = $this->cleanJs($content);
                    break;
                case 'css':
                    $content = $this->cleanCss($content);
                    break;
                default:
                    throw new UnsupportedMediaTypeException("Only CSS and JS files can be processed");
            }
        } else {
            throw new UnprocessableEntityException("The file '{$file}' can not be readed or is empty");
        }
        $this->addContent($content);
        return $this;
    }

    /**
     * Array of fullpaths for files to parse
     * @param array<int, string> $files
     */
    public function addFiles(array $files): self
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
        return $this;
    }

    public function cleanJs(string $content): string
    {
        return JSMin::minify($content);
    }

    public function cleanCss(string $content): string
    {
        return CSSMin::minify($content);
    }

}

<?php

declare(strict_types=1);

namespace JuanchoSL\AssetMinifyer\Facades;

use JuanchoSL\AssetMinifyer\Contracts\MinifyerInterface;
use JuanchoSL\Exceptions\NotFoundException;
use JuanchoSL\Exceptions\UnprocessableEntityException;

class Minifier implements \Stringable
{

    private array $contents = [];

    protected MinifyerInterface $minifier;

    public function __construct(MinifyerInterface $minifier)
    {
        $this->minifier = $minifier;
    }

    public function getContent(): string
    {
        $response = '';
        foreach ($this->contents as $content) {
            $response .= $this->minifier->minify($content) . PHP_EOL;
        }
        return $response;
    }

    public function addContent(string $data): self
    {
        $this->contents[md5($data)] = $data;
        return $this;
    }

    public function addFile(string $file): self
    {
        if (filter_var($file, FILTER_VALIDATE_URL) === false && !file_exists($file)) {
            throw new NotFoundException("The file '{$file}' does not exists");
        }
        $content = file_get_contents($file);
        if (empty($content)) {
            throw new UnprocessableEntityException("The file '{$file}' can not be readed or is empty");
        }
        return $this->addContent($content);
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

    public function __tostring(): string
    {
        return $this->getContent();
    }
}

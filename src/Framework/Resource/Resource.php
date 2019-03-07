<?php

namespace Romano\Framework\Resource;

class Resource
{
    private $scopes = [];
    private $blocks = [];
    private $baseFile = 'default.twig';
    private $blockName;
    private $lock = false;

    public function block(string $name): self
    {
        $this->blockName = $name;

        return $this;
    }

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function hasBlocks(): bool
    {
        return \count($this->blocks) > 0;
    }

    public function setBaseFile(string $baseFile): self
    {
        $this->baseFile = $baseFile;

        return $this;
    }

    public function getBaseFile(): string
    {
        return $this->baseFile;
    }

    public function scope(string $controller): void
    {
        $this->scopes[$this->blockName][] = $controller;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function html($path): self
    {
        $this->blocks[$this->blockName][] = $path;

        return $this;
    }

    public function getHtmlBlocks(): array
    {
        return $this->blocks;
    }

    public function lock(): void
    {
        $this->lock = true;
    }

    public function unlock(): void
    {
        $this->lock = false;
    }

    public function isLocked(): bool
    {
        return $this->lock;
    }
}

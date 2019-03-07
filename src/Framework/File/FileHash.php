<?php

namespace Romano\Framework\File;

class FileHash
{
    private $hash;

    public static function generate(string $content): self
    {
        $fileHash = new self();
        $fileHash->hash = hash('crc32b', $content);

        return $fileHash;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function __toString(): string
    {
        return $this->getHash();
    }

    public function is(string $hash): bool
    {
        return $this->hash === $hash;
    }

    public function isGeneratedFrom(string $content): bool
    {
        return self::generate($content)->is($this->hash);
    }

    public function equal(FileHash $fileHash): bool
    {
        return $fileHash->is($this->hash);
    }
}
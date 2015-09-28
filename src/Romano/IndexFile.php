<?php

class IndexFile
{
    private $index;
    public $filename = '.index.json';
    private $indexedFiles;

    public function __construct($root, $directory)
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $this->root = rtrim($root, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $this->index = new File($this->root.$this->filename);
        $this->indexedFiles = (array) json_decode($this->index->getContent(), true);
    }

    public function find()
    {
        $foundFiles = [];
        // @TODO filter
        foreach ($this->indexedFiles as $indexedFile) {
            $file = $this->unlockFile($indexedFile);
            $foundFiles[$file->getHash()] = $file;
        }
        return $foundFiles;
    }

    public function getFile($filename)
    {
        foreach ($this->indexedFiles as $indexedFile) {
            $file = $this->unlockFile($indexedFile);
            if ($file->getBasename() === $filename) {
                return $file;
            }
        }
    }

    public function save()
    {
        $this->index->setContent($this->getContent());
        $this->index->save();
    }

    public function add(File $file)
    {
        $this->indexedFiles[$file->getHash()] = $this->indexKey($file);
    }

    public function getContent()
    {
        return json_encode($this->indexedFiles);
    }

    private function indexKey(File $file)
    {
        return join(
            '|||',
            [
                $file->getHash(),
                $this->directory,
                $file->getBasename()
            ]
        );
    }

    private function unlockFile($indexedFile)
    {
        list($nBitHash, $directory, $basename) = explode('|||', $indexedFile);
        return new File(
            $this->root.$basename,
            null,
            $nBitHash
        );
    }
}

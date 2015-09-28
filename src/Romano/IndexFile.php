<?php

class IndexFile
{
    private $index;
    private $filename = '.index.json';
    private $indexedFiles;

    function __construct($rootDirectory, $root)
    {
        $this->directory = rtrim($root, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $this->index = new File($rootDirectory.$this->filename);
        $this->indexedFiles = (array) json_decode($this->index->getContent(), true);
    }

    public function find()
    {
        $foundFiles = [];
        // @TODO filter
        foreach ($this->indexedFiles as $indexedFile) {
            $file = $this->indexUnlock($indexedFile);
            $foundFiles[$file->getHash()] = $file;
        }
        return $foundFiles;
    }

    public function getFile($filename)
    {
        foreach ($this->indexedFiles as $indexedFile) {
            $file = $this->indexUnlock($indexedFile);
            if ($file->getBasename() === $filename) {
                return $file;
            }
        }
    }

    public function add(File $file)
    {
        $this->indexedFiles[$file->getHash()] = $this->indexKey($file);
    }

    public function save()
    {
        $this->index->save(json_encode($this->indexedFiles));
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

    private function indexUnlock($indexedFile)
    {
        list($nBitHash, $directory, $basename) = explode('|||', $indexedFile);
        return new File(
            $directory.DIRECTORY_SEPARATOR.$basename,
            null,
            $nBitHash
        );
    }
}

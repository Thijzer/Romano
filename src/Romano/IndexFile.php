<?php

class IndexFile
{
    private $index;
    public $filename = '.index.json';
    private $indexedFiles;

    public function __construct($directory)
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $this->index = new File($this->directory.$this->filename);
        $this->index->setHash();
    }

    public function getIndexedFiles()
    {
        if (!$this->indexedFiles) {
            $foundFiles = [];
            $indexFiles = (array) @json_decode($this->index->getContent(), true);
            foreach ($indexFiles as $key => $indexFile) {
                $file = $this->unlockFile($key, $indexFile);
                $foundFiles[$this->indexKey($file)] = $file;
            }
            $this->indexedFiles = $foundFiles;
        }
        return $this->indexedFiles;
    }

    public function getFile($filename)
    {
        foreach ($this->getIndexedFiles() as $file) {
            if ($file->getBasename() === $filename) {
                return $file;
            }
        }
    }

    public function find($query)
    {
        $result = [];
        foreach ($this->getIndexedFiles() as $file) {
            if (strpos($file->basename, $query)) {
                $result[] = $file;
            }
        }
        return $result;
    }

    public function save()
    {
        $this->index->setContent($this->getContent())->save();
    }

    public function add(File $file)
    {
        $this->indexedFiles[$this->indexKey($file)] = $file;
    }

    public function getContent()
    {
        return json_encode($this->getIndexedFiles());
    }

    private function indexKey(File $file)
    {
        return join(
            '|||',
            [
                $file->getHash(),
                $file->basename,
            ]
        );
    }

    private function unlockFile($key, $indexedFile)
    {
        list($nBitHash, $basename) = explode('|||', $key);
        return new File(
            $this->directory.$basename,
            null,
            $indexedFile+['oldHash' => $nBitHash]
        );
    }
}

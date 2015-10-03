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
    }

    public function getIndexedFiles()
    {
        if (!$this->indexedFiles) {
            $this->index->setHash(); # we need to set it's previous hash
            $this->indexedFiles = (array) @json_decode($this->index->getContent(), true);
        }
        return $this->indexedFiles;
    }

    public function getFile($filename, $type = 'filename')
    {
        $fullPathHash = nBitHash($this->directory.$filename);
        return (isset($this->getIndexedFiles()[$fullPathHash])) ?
            $this->getIndexedFiles()[$fullPathHash]:
            ''; # exception file not found
    }

    public function find($needles, $sensitive = true, $offset = 0)
    {
        $result = [];
        foreach ($this->getIndexedFiles() as $fileInfo) {
            foreach ($needles as $needle) {
                $isFound = ($sensitive) ?
                    (strpos($fileInfo['filename'], $needle, $offset) !== false) :
                    (stripos($fileInfo['filename'], $needle, $offset) !== false);
                if ($isFound) {
                    $result[] =  $this->returnFile($fileInfo);
                }
            }
        }
        return $result;
    }

    public function save()
    {
        $this->index->setContent(json_encode($this->getIndexedFiles()))->save();
    }

    public function add(File $file)
    {
        # convert obj to array and store
        $this->indexedFiles[$file->getFullPathHash()] = json_decode(json_encode($file), true);
    }

    private function returnFile(array $fileInfo)
    {
        return new File(
            $this->directory.$fileInfo['filename'],
            null,
            $fileInfo
        );
    }
}

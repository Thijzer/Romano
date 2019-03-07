<?php

class IndexFile
{
    private $index;
    private $files;

    public $filename = '.index.json';
    public $isChanged = false;
    public $changedFiles;

    public function __construct($directory)
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $this->index = new File($this->directory.$this->filename);
    }

    public function getFiles()
    {
        if (!$this->files) {
            $this->files = (array) @json_decode($this->index->getContent(), true);
        }
        return $this->files;
    }

    public function getFile($filename)
    {
        $fullPathHash = crc32b($this->directory.$filename);
        return (isset($this->getFiles()[$fullPathHash])) ?
            $this->returnFile($this->getFiles()[$fullPathHash]):
            ''; # exception file not found
    }

    public function find($needles, $sensitive = true, $offset = 0)
    {
        $result = [];
        foreach ($this->getFiles() as $fileInfo) {
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
        $this->index->setContent(json_encode($this->getFiles()))->save();
    }

    public function add(File $file)
    {
        # convert obj to array and store
        $hash = $file->getFullPathHash();
        $this->isChanged = true;
        $this->changedFiles[$hash] = $file;
        $file->getFileSize();
        $this->files[$hash] = json_decode(json_encode($file), true);
    }

    public function remove(File $file)
    {
        $hash = $file->getFullPathHash();
        $this->isChanged = true;
        unset($this->files[$hash]);
    }

    public function returnFile(array $fileInfo)
    {
        return new File(
            $this->directory.$fileInfo['filename'],
            null,
            $fileInfo
        );
    }
}

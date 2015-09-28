<?php

class FileSystem
{
    private $indexFile;
    private $directory;
    private $rootDirectory;
    private $files;
    private $systemFiles = array('.', '..', '.index.json');

    function __construct($rootDirectory, $directory)
    {
        $this->rootDirectory = rtrim($rootDirectory, DIRECTORY_SEPARATOR);
        $this->directory = $this->rootDirectory.DIRECTORY_SEPARATOR;
        $this->directory .= rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        if (!is_dir($this->directory)) {
            $this->mkdir($this->directory);
        }
        $this->indexFile = new IndexFile($this->directory, $directory);
        return $this;
    }

    public function scan()
    {
        foreach (array_diff(scandir($this->directory), $this->systemFiles) as $filename) {
            $file = new File($this->directory.$filename);
            $this->files[$filename] = $file;
            $this->indexFile->add($file);
        }
        return $this->files;
    }

    public function find($query)
    {
        return $this->indexFile->find($query);
    }

    public function get($filename)
    {
        return (isset($this->files[$filename])) ?
            $this->files[$filename]:
            $this->indexFile->getFile($filename);
    }

    public function exists($filename)
    {
        return (strpos($this->indexFile->getContent(), $filename) !== false);
    }

    public function move($directory)
    {
        if (!is_dir($directory)) {
            return;
        }
        // directory
        $this->directory = $directory;
        $this->store();
    }

    public function mkdir($directory)
    {
        if (!is_dir($directory)) {
            return;
        }
        mkdir($directory);
        return $this;
    }

    public function add($filename, $content)
    {
        $file = new File($this->directory.$filename, $content);
        $this->files[$filename] = $file;
        $this->indexFile->add($file);
    }

    public function store()
    {
        foreach ($this->files as $file) {
            $file->save();
            $this->indexFile->add($file);
        }
        $this->indexFile->save();
    }

    public function compare(File $file1, File $file2)
    {
        return ($file1->getHash() === $file2->getHash());
    }
}


//
// public function buildPath(...$segments)
// {
//     return join(DIRECTORY_SEPARATOR, $segments);
// }
// public function filter($query)
// {
//     // todo syntax check
//     $this->filters[] = $query;
//     # code...
//     return $this;
// }

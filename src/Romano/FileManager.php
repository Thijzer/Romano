<?php

class FileManager
{
    private $indexFile;
    private $directory;
    private $rootDirectory;
    private $files = [];
    private $systemFiles = ['.DS_Store', '@eaDir'];

    public function __construct($rootDirectory, $directory)
    {
        $this->rootDirectory = rtrim($rootDirectory, DIRECTORY_SEPARATOR);
        $this->directory = $this->rootDirectory.DIRECTORY_SEPARATOR;
        $this->directory .= rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        if (!is_dir($this->directory)) {
            $this->mkdir($this->directory);
        }
        $this->indexFile = new IndexFile($this->directory);

        // add your index file filename to the system Files
        $this->systemFiles[] = $this->indexFile->filename;
        return $this;
    }

    public function scan()
    {
        $foundFiles = array_diff(array_filter(scandir($this->directory), function($item) {
            return !is_dir($this->directory . $item);
        }), $this->systemFiles);

        foreach ($foundFiles as $filename) {
            $file = new File($this->directory.$filename);
            $file->getFilesize();
            $file->getMimeType();
            $this->files[$filename] = $file;
            $this->indexFile->add($file);
        }
        return $this;
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
        if (is_dir($directory) && strpos($directory, $this->$rootDirectory) !== false) {
            return rename($this->directory, $directory);
        }
    }

    public function mkdir($directory)
    {
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
        echo "store";
        foreach ($this->files as $file) {
            $file->save();
            $this->indexFile->add($file);
        }
        $this->indexFile->save();
    }

    public function isIndentical(File $file1, File $file2)
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

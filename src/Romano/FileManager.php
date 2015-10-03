<?php

class FileManager
{
    private $indexFile;
    private $directory;
    private $fileChanged = [];
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
        return $this;
    }

    public function indexFile()
    {
        if (!$this->indexFile) {
            $this->indexFile = new IndexFile($this->directory);

            // add your index file filename to the system Files
            $this->systemFiles[] = $this->indexFile->filename;
        }
        return $this->indexFile;
    }

    public function scan()
    {
        $indexFile = $this->indexFile();
        $foundFiles = array_diff(array_filter(scandir($this->directory), function ($item) {
            return !is_dir($this->directory . $item);
        }), $this->systemFiles);

        foreach ($foundFiles as $filename) {
            $file = new File($this->directory.$filename);
            $file->getFilesize(); # index the files as well
            $this->files[$filename] = $file;
            $indexFile->add($file);
        }
        return $this;
    }

    public function find(...$query)
    {
        return $this->indexFile()->find($query);
    }

    public function get($filename)
    {
        $file = new File($this->directory . $filename);
        if ($file->exists()) {
            return $file;
        }
        return (isset($this->files[$filename])) ?
            $this->files[$filename]:
            $this->indexFile()->getFile($filename);
    }

    public function exists($filename)
    {
        $file = new File($this->directory . $filename);
        return ($file->exists());
    }

    public function move($directory)
    {
        if (is_dir($directory)) {
            return rename($this->directory, $directory);
        }
    }

    public function sortBy($newIndex)
    {
        foreach ($this->files as $value) {
            $tmp[$value[$newIndex]] = $value;
        }
        return $tmp;
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
        $this->fileChanged[] = $filename;
        $this->indexFile()->add($file);
    }

    public function store()
    {
        if ($this->fileChanged) {
            foreach ($this->files as $file) {
                if (in_array($file->filename, array_keys($this->fileChanged))) {
                    $this->indexFile()->add($file);
                    $file->save();
                }
            }
            $this->indexFile()->save();
        }
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

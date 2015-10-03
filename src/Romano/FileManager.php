<?php

class FileManager
{
    private $indexFile;
    private $directory;
    private $systemFiles = ['.DS_Store', '@eaDir'];

    public function __construct($directory)
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        if (!is_dir($this->directory)) {
            mkdir($this->directory);

            # prep the directory
            #$this->scan()->store();
        }
    }

    private function indexFile()
    {
        if (!$this->indexFile) {
            $this->indexFile = new IndexFile($this->directory);

            // add your indexfile filename to the system Files
            $this->systemFiles[] = $this->indexFile->filename;
        }
        return $this->indexFile;
    }

    public function scan()
    {
        if (!$indexFile = $this->indexFile()) {
            $foundFiles = array_diff(array_filter(scandir($this->directory), function ($item) {
                return !is_dir($this->directory.$item);
            }), $this->systemFiles);

            $files = Arrays::indexBy('filename', $indexFile->getFiles());
            $newFiles = array_diff($foundFiles, array_keys($files));
            $removedFiles = array_diff(array_keys($files), $foundFiles);

            foreach ($newFiles as $filename) {
                $indexFile->add(new File($this->directory.$filename));
            }
            foreach ($removedFiles as $filename) {
                $indexFile->remove(new File($this->directory.$filename));
            }
        }
        return $this;
    }

    public function find(...$query)
    {
        return $this->indexFile()->find($query);
    }

    public function get($filename)
    {
        if ($file = $this->indexFile()->getFile($filename)) {
            return $file;
        }
        $file = new File($this->directory . $filename);
        if ($file->exists()) {
            return $file;
        }
        # not found
    }

    public function exists($filename)
    {
        return !empty($this->get($filename));
    }

    public function move($directory)
    {
        if (is_dir($directory) && !$this->indexFile()->isChanged) {
            return rename($this->directory, $directory);
        }
    }

    public function add($filename, $content)
    {
        $file = new File($this->directory.$filename, $content);
        $this->indexFile()->add($file);
    }

    public function remove($filename)
    {
        if ($file = $this->get($filename)) {
            $file->remove();
            $this->indexFile()->remove($file);
        }
    }

    public function store()
    {
        if ($this->indexFile()->isChanged) {
            $files = $this->indexFile()->changedFiles;
            foreach ($files as $file) {
                $file->save();
            }
            $this->indexFile()->save();
        }
        return $this;
    }

    // File System

    public function addFile(File $file)
    {
        $this->indexFile()->add($file);
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

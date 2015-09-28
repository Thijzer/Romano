<?php

/**
 * Cache system Losely based on the PSR6 standard
 *
 */
class Cache
{
    private $directory;
    private $cacheDirectory;
    private $file;
    private $parkedFiles;
    private $index;

    function __construct($directory) {
        if (!in_array($directory, array('images'))) {
            # throw the Exception biatch
        }
        $tis->cacheDirectory = path('Cache');
        $this->file = new File();
    }

    public function setCacheDirectoy($newdirectory)
    {
        if (is_dir($newdirectory)) {
            $this->cacheDirectory = $newdirectory;
        }
    }

    public function parkFile($item)
    {
        # drop file in memory
        $this->index[md5($item)];
    }

    public function getItem($item)
    {
        # get one item
        if ($this->isParked($item)) {
            # code...
        }
    }

    public function getItems($item)
    {
        # get a selection
        if ($this->isParked($item)) {
            # code...
        }
    }

    public function save()
    {
        # presist index and file(s)
        $this->file->store($this->parkedFiles);
    }

    public function deleteItems(array $files)
    {
        # delete file & and index
        foreach ($files as $file) {
            if (isParked($file)) {
                $this->file->delete($file);
                $this->deleteIndexPoint($file);
            }
        }
    }

    public function isCached($file)
    {
        # index & file check
        return $this->file->exists($file);
    }

    public function isParked($item)
    {
        # index check
        return in_array($item, $this->index);
    }

    private function deleteIndexPoint($file)
    {
        unset($this->index[$file]);
    }
}

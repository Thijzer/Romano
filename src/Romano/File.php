<?php

class File extends SPLFileInfo
{
    private $fullPath;
    private $content;
    private $filesizeFormat;
    private $mimetype;

    public $filesize;
    public $filename;

    public function __construct($fullPath, $content = null, $properties = null)
    {
        parent::__construct($fullPath);

        if (is_array($properties)) {
            foreach ($properties as $key => $value) {
                $this->{$key} = $value;
            }
        }
        $this->filename = $this->getFilename();
        $this->fullPath = $fullPath;
        $this->content = $content;
    }

    public function exists()
    {
        return $this->isfile();
    }

    public function getFullPath()
    {
        return $this->fullPath;
    }

    public function getFullPathHash()
    {
        return crc32b($this->fullPath);
    }

    public function getContent()
    {
        return (!$this->content) ? @file_get_contents($this->fullPath) : $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getHash()
    {
        return crc32b($this->getContent());
    }

    public function getMimeType()
    {
        if (!$this->mimetype && $this->exsists()) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $this->mimetype = finfo_file($finfo, $this->fullPath);
            finfo_close($finfo);
        }
        return $this->mimetype;
    }

    public function getSizeInBytes()
    {
        if (!$this->exists()) {
            return; # File is still in memory
        }
        if (!$this->filesize) {
            clearstatcache(); # required
            $this->filesize = filesize($this->fullPath);
        }
        return $this->filesize;
    }

    public function getDirectory()
    {
        return pathinfo($this->fullPath, PATHINFO_DIRNAME);
    }

    public function getFilesize($decimals = 2)
    {
        if (!$this->filesizeFormat) {
            $bytes = $this->getSizeInBytes();
            $size = array("Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
            $factor = floor((strlen($bytes) - 1) / 3);
            $this->filesizeFormat = sprintf("%.{$decimals}f", $bytes / pow(1024, $factor));
            $this->filesizeFormat .= ' ' . @$size[$factor];
        }
        return $this->filesizeFormat;
    }

    public function remove($filename)
    {
        $this->content = null;
        unlink($this->fullPath);
        return null;
    }

    public function save()
    {
        if (!empty($this->content)) {
            try {
                $localFile = fopen($this->fullPath, 'w+');
                fwrite($localFile, $this->getContent());
                fclose($localFile);
            } catch (Exception $e) {
                die($e);
            }
        }
    }
}

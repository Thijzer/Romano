<?php

class File
{
    private $fullPath;
    private $directory;
    private $extension;
    private $filename;
    private $content;
    /* filename + extension */
    public $basename;
    public $mimetype;
    private $hash;
    private $oldHash;
    private $filesizeFormat;
    public $filesize;
    private $isFile;

    public function __construct($fullPath, $content = null, $properties = null)
    {
        if (is_array($properties)) {
            foreach ($properties as $key => $value) {
                $this->{$key} = $value;
            }
        }

        $pathinfo = pathinfo($fullPath);
        $this->fullPath = $fullPath;
        $this->directory = @$pathinfo['dirname'];
        $this->extension = @$pathinfo['extension'];
        $this->basename = @$pathinfo['basename'];
        $this->filename = @$pathinfo['filename'];
        $this->isFile = ($this->oldHash !== null);
        $this->content = $content;
    }

    public function exsists()
    {
        if (!$this->isFile) {
            $this->isFile = is_file($this->fullPath);
        }
        return $this->isFile;
    }

    public function getContent()
    {
        if (!$this->content) {
            return @file_get_contents($this->fullPath);
        }
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setHash()
    {
        if (!$this->oldHash) {
            $this->oldHash = nBitHash($this->getContent());
        }
    }

    public function getHash()
    {
        if (!$this->hash && $this->exsists()) {
            return $this->oldHash;
        }
        $this->hash = nBitHash($this->getContent());
        return $this->hash;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getFullPath()
    {
        return $this->fullPath;
    }

    public function getBasename()
    {
        return $this->basename;
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
        if (!$this->exsists()) {
            return; # File is still in memory
        }
        if (!$this->filesize) {
            clearstatcache(); # required
            $this->filesize = filesize($this->fullPath);
        }
        return $this->filesize;
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
        return trim($this->filesizeFormat);
    }

    public function save()
    {
        if ($this->content && $this->oldHash !== $this->gethash()) {
            echo $this->filename;
            dump($this->oldHash);
            dump($this->hash);
            // $localFile = fopen($this->getFullPath(), "w+");
            // if (!$localFile) {
            //     return; # no access
            // }
            // fwrite($localFile, $this->getContent());
            // fclose($localFile);
        }
    }
}

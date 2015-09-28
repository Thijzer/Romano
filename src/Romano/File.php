<?php

class File
{
    private $fullPath;
    private $directory;
    private $extension;
    private $filename;
    private $content;
    /* filename + extension */
    private $basename;
    private $mimetype;
    private $hash;
    private $oldHash;
    private $filesizeFormat;
    private $filesize;
    private $isFile;

    public function __construct($fullPath, $content = null, $oldHash = null)
    {
        $pathinfo = pathinfo($fullPath);
        $this->fullPath = $fullPath;
        $this->directory = @$pathinfo['dirname'];
        $this->extension = @$pathinfo['extension'];
        $this->basename = @$pathinfo['basename'];
        $this->filename = @$pathinfo['filename'];
        $this->oldHash = $oldHash;
        $isFile = ($oldHash !== null);
        $this->content = $content;
    }

    public function getContent()
    {
        if (!$this->content) {
            $this->content = @file_get_contents($this->fullPath);
        }
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getHash()
    {
        if (!$this->hash) {
            $this->hash = nBitHash($this->getContent());
        }
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
        if (!$this->mimetype) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $this->mimetype = finfo_file($this->fullPath);
            finfo_close($finfo);
        }
        return $this->mimetype;
    }

    public function getSizeInBytes()
    {
        if (!is_file($this->fullPath)) {
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
            $this->filesizeFormat .= ' '.@$size[$factor];
        }
        return $this->filesizeFormat;
    }

    public function save()
    {
        if ($this->oldHash !== $this->gethash()) {
            $localFile = fopen($this->getFullPath(), "w+");
            if (!$localFile) {
                return; # no access
            }
            fwrite($localFile, $this->getContent());
            fclose($localFile);
        }
    }
}

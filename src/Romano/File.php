<?php

class File extends SPLFileInfo
{
    private $fullPath;
    private $content;
    private $hash;
    private $filesizeFormat;
    private $mimetype;
    private $filesize;

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
        return nbitHash($this->fullPath);
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
        if (!$this->hash) {
            $this->getHash();
        }
        return $this;
    }

    public function getHash()
    {
        // hashes of memory content should not be returned
        if ($this->hash && $this->exists()) {
            return $this->hash;
        }
        $this->hash = nBitHash($this->getContent());
        return $this->hash;
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

    public function remove($filename)
    {
        unlink($filename);
        return null;
    }

    public function save()
    {
        $oldHash = $this->hash;
        $newHash = $this->gethash();
        if (!empty($this->content) && ($oldHash !== $newHash)) {
            # try block
            $localFile = fopen($this->fullPath, 'w+');
            if (!$localFile) {
                return; # no access
            }
            fwrite($localFile, $this->getContent());
            fclose($localFile);
        }
    }
}

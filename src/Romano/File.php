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

    function __construct($fullPath, $content = null, $hash = null)
    {
        $file = pathinfo($fullPath);
        $this->fullPath = $fullPath;
        $this->directory = $file['dirname'];
        $this->extension = (isset($file['extension']))? $file['extension']: '';
        $this->basename = $file['basename'];
        $this->filename = $file['filename'];
        $this->content = $content;
        $this->oldHash = $hash;
        if ($content) {
            $this->getHash();
        }
    }

    public function getContent()
    {
        if (!$this->content) {
            $this->content = @file_get_contents($this->fullPath);
            $this->hash = nBitHash($this->content);
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

    public function moveTo($location)
    {
        if (!is_dir($location)) {
            return;
        }
        $this->fullPath = $location;
        rename(
            $this->fullPath,
            DIRECTORY_SEPARATOR.trim($location, '/').DIRECTORY_SEPARATOR.$this->basename
        );
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

    public function save($content = null)
    {
        // ovewrite
        if ($content !== null) {
            $this->setContent($content);
        }

        if ($this->oldHash !== nBitHash($this->getContent())) {
            $file = fopen($this->fullPath, "w+");
            if (!$file) {
                return; # no access
            }
            fwrite($file, $this->getContent());
            fclose($file);
        }
    }
}

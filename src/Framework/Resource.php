<?php

class Resource
{
    private $storePath = '';
    private $scope = array();
    private $render;
    private $blocks;
    private $caviar = array();
    private $baseFile = 'default.twig';
    private $name;
    private $lock = false;
    private $options = array(
        'twig' => array(
            'extends' => '{% extends "$1" %}',
            'block' => "{% block $1 %}\n$2{% endblock %}",
            'include' => '{% include "$1" %}',
            'comment' => "{# $1 #}\n\n",
        )
    );

    public function __construct($pathView, $engine)
    {
        if (!isset($this->options[$engine])) {
            leave('select a proper render engine like twig');
        }
        $this->isDev = (DEV_ENV !== true);
        $this->storePath = $pathView;
        $this->options = $this->options[$engine];
        $comment = "Generated file from Resource";
        $comment .= ' :: '.date('F Y');
        $this->render = str_replace('$1', $comment, $this->options['comment']);
    }

    public function block($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setBaseFile($baseFile)
    {
        $this->baseFile = $baseFile;
        return $this;
    }

    public function scope($controller)
    {
        if (isset($this->scope[$controller])) {
            return $this->scope[$controller];
        }

        list($ctrl, $method) = explode('@', $controller);
        if (is_callable($class = ucfirst($ctrl), $method)) {
            $class = new $class();
            $this->index[$ctrl] = $class;
            $this->scope[$controller] = (array) $class->$method();
            $this->caviar = array_merge($this->caviar, $this->scope[$controller]);
            return $this;
        }
        leave('undefined scope '.$controller.' passed');
    }

    public function addToScope($name, $scope)
    {
        $this->caviar = array_merge($this->caviar, array($name => $scope));
    }

    public function html($path)
    {
        $blockPart = new File(path('view').$path.'.twig');
        $this->blocks[$this->name][] = $blockPart;
        return $this;
    }

    public function store($path)
    {
        $this->storePath = $path;
    }

    public function render()
    {
        $baseCacheFile = new File(path('view_cache'). $this->storePath);
        if ($this->isDev && $baseCacheFile->exists()) {
            return $this->storePath;
        }

        if (!$this->blocks) {
            leave('no html blocks defined');
        }

        $this->render .= str_replace('$1', $this->baseFile, $this->options['extends']);

        if ($this->lock === true) {
            $this->render .= str_replace('$1', 'locked', $this->options['comment']);
        }

        foreach ($this->blocks as $key => $block) {
            $tmp = '';
            foreach ($block as $blockPart) {
                if (!$blockPart->exists()) {
                    leave($blockPart->filename.' is not a real block');
                }
                $tmp .= $blockPart->getContent();
            }
            $this->render .= str_replace(
                ['$1', '$2'],
                [$key, $tmp],
                $this->options['block']
            ) . "\n";
        }

        if (!$baseCacheFile->exists()) {
            if (!is_dir($baseCacheFile->getDirectory())) {
                mkdir($baseCacheFile->getDirectory());
            }
            $baseCacheFile->setContent($this->render)->save();
        } elseif ($baseCacheFile->getHash() !== crc32b($this->render)) {
            $baseCacheFile->setContent($this->render)->save();
        }

        return $this->storePath;
    }

    public function getScope()
    {
        return $this->caviar;
    }

    public function lock()
    {
        $this->lock = true;
    }
}

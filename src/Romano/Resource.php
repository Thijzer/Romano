<?php

class Resource
{
    private $storePath = '', $route = array(), $scope = array(), $block, $caviar = array(), $path, $baseFile = 'base.twig', $name, $lock = false;
    private $options = array(
        'twig' => array(
            'extends' => '{% extends "$1" %}',
            'block' => "{% block $1 %}\n$2{% endblock %}",
            'include' => '{% include "$1" %}',
            'comment' => "{# $1 #}\n\n",
        )
    );

    public function __construct($route)
    {
        $this->route = $route;
        $this->storePath = $this->route['path_view'];
    }

    public function block($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setBaseFile($baseFile)
    {
        $this->baseFile = $baseFile;
    }

    public function scope($re) // we need to move it to render
    {
        if(isset($this->scope[$re])) {
          return $this->scope[$re];
        }

        list($ctrl, $method) = explode('@', $re);
        if (is_callable($class = ucfirst($ctrl), $method)) {
            $class = new $class();
            $this->index[$ctrl] = $class;
            $this->scope[$re] = (array) $class->$method();
            $this->caviar = array_merge($this->caviar, $this->scope[$re]);
            return $this;
        }
        die('resoure@scope undefined method passed');
    }

    public function addToScope($name, $scope)
    {
        $this->caviar = array_merge($this->caviar, array($name => $scope));
    }

    public function html($path)
    {
        $this->block[$this->name][] = $path;
        return $this;
    }

    public function store($path)
    {
        $this->storePath = $path;
    }

    public function getRender($engine, $comment = "Generated file from Resource")
    {
        $root = path('cache') . path('theme_name').'/';
        $store = $root . $this->storePath;

        if (DEV_ENV !== true && file_exists($store)) {
            return $this->storePath;
        }

        if ($options = $this->options[$engine]) {

            $comment .= ' :: '.date('F Y');
            $render = str_replace('$1', $comment, $options['comment']);

            if ($this->baseFile) {
                $render .= str_replace('$1', $this->baseFile, $options['extends']);
            }
            if (!$this->block) {
                exit('Resource :: we are missing html blocks');
            }

            foreach ($this->block as $key => $block) {

                $tmp = '';
                foreach ($block as $segment) {
                    $blok = new File(path('theme_view').$segment.'.twig');
                    $tmp .= $blok->getContent();
                }
                $render .= str_replace(
                    ['$1', '$2'],
                    [$key, $tmp],
                    $options['block']
                ) . "\n";
            }
            if ($this->lock === true) {
                $render .= str_replace('$1', 'locked', $options['comment']);;
            }
        } else {
            exit('Select a proper render engine');
        }

        $file = new file($root. $this->storePath);
        if (!$file->exists()) {
            mkdir($file->getDirectory());
            $file->setContent($render)->save();
        } elseif ($file->getHash() !== crc32b($render)) {
            $file->setContent($render)->save();
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

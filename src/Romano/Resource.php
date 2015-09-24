<?php


class Resource
{
    private $storePath = '', $route = array(), $scope = array(), $block, $caviar = array(), $path, $baseFile = 'base.twig', $name, $lock = false;
    private $options = array(
        'twig' => array(
            'extends' => '{% extends "$1" %}',
            'block' => "{% block $1 %}\n$2{% endblock %}",
            'include' => '{% include "$1" %}'
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

    public function getRender($engine, $render = "{# Generated file from Resource #}\n")
    {
        $root = path('cache') . path('theme_name').'/';
        $store = $root . $this->storePath;
        $render .= "{# ".date('l jS \of F Y h:i:s A')." #}\n\n";

        if (DEV_ENV !== true && file_exists($store)) {
            return $this->storePath;
        }

        if ($options = $this->options[$engine]) {
            if ($this->baseFile) {
                $render .= str_replace('$1', $this->baseFile, $options['extends']);
            }
            if (!$this->block) {
                exit('Resource :: we are missing html blocks');
            }

            foreach ($this->block as $key => $block) {
                $A = array('$1', '$2');
                $B = array($key, Files::get($block, path('theme_view'), 'twig'));
                $render .= str_replace($A, $B, $options['block']) . "\n";
            }
            //return $render;
            if ($this->lock === true) $render .= "\n" . '{# locked #}';
        }
        else exit('Select a proper render engine');

        if (md5(Files::get($this->storePath, $root, 'twig')) !== md5($render)) {
            Files::root($root);
            Files::collect($render);
            Files::set($this->storePath);
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

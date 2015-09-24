<?php



class Html
{
    protected $example = array('input' => "<input *>", 'elem'  => "<%elem% *></%elem%>");
    protected $elem, $start, $args = array();

    static function elem($elem)
    {
        if (is_string($elem)) {
            $instance = new Html();
            $instance->start = ($elem == 'input') ?
                $instance->example['input'] :
                str_replace('%elem%', $elem, $instance->example['elem']);
            return $instance;
        }
    }

    function __call($method, $args)
    {
        if ($method == 'type' && count($args) > 1) return $this;
        $method = str_replace('__', '-', $method);
        $this->args[$method] = $args;
        return $this;
    }

    function end($val = '')
    {
        $this->build();
        return str_replace(' *>', '>' . $val, $this->elem);
    }

    function options($name)
    {
        if (is_array($name)) $name = implode(' ', $name);
        $this->elem = str_replace('*', "$name *", $this->elem);
        return $this;
    }

    private function build()
    {
        $this->elem = $this->start;
        foreach($this->args as $name => $arg)
        {
            $arg = implode(' ', $arg);
            $this->elem = str_replace('*', "$name=\"$arg\" *", $this->elem);
        }
    }
}

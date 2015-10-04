<?php



class Request
{
    private $req = array();

    public function __construct(array $server, array $resquest)
    {
        $this->req = array_merge($server, $resquest);
        $this->req['URI'] = trim(str_replace('?'.$server['QUERY_STRING'], '', $server['REQUEST_URI']), '/');
        $this->req['SECTIONS'] = explode('/', $this->req['URI']);
        $this->req['HOST_SECTIONS'] = explode('.', $this->req['HTTP_HOST']);
        $this->req['LANGUAGE'] = '';
        $this->req['VIEW'] = '';
        $parts = pathinfo($this->req['URI']);
        if (isset($parts['extension'])) {
            $this->req['URI'] = str_replace('.'.$parts['extension'], '', $this->req['URI']);
            $this->req['VIEW'] = $parts['extension'];
            $this->req['SECTIONS'] = explode('/', $this->req['URI']);
        }

        parse_str($server['QUERY_STRING'], $this->req['PARAMS']);
    }

    public function get($name)
    {
        return $this->req[(string) $name];
    }

    public function set($name, $value)
    {
        return $this->req[(string) $name] = $value;
    }
    public function getURLSection($section)
    {
        return (!is_integer($section))?: $this->req['SECTIONS'][$section];
    }

    public function getHostSection($section)
    {
        return (!is_integer($section))?: $this->req['HOST_SECTION'][$section];
    }

    public function count($name)
    {
        return count($this->get($name));
    }

    public function removeURLSection($section)
    {
        unset($this->req['SECTIONS'][$section]);
        $this->req['SECTIONS'] = array_values($this->req['SECTIONS']);
        $this->req['URI'] = implode('/', $this->req['SECTIONS']);
    }

    public function isMethod($method)
    {
        return (strtoupper($method) === $this->get('REQUEST_METHOD'));
    }

    public function isSubmitted($name = 'submit')
    {
        if ($this->count('REQUEST_METHOD') > 0) {
            return isset($this->req['REQUEST_METHOD'][$name]);
        }
    }
}

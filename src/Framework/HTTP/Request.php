<?php

namespace Romano\Framework\HTTP;

use Romano\Component\Common\ContainerInterface;
use Romano\Component\Common\Matroska;

class Request
{
    private $parameters;

    public function __construct()
    {
        $this->parameters = new Matroska();
        $this->parameters->addAll(array_merge($_SERVER, $_REQUEST));
    }

    public function getParameters(): ContainerInterface
    {
        return $this->parameters;
    }

    public function get(string $key)
    {
        return $this->parameters->get($key);
    }

    public function has(string $key): bool
    {
        return $this->parameters->has($key);
    }

    public function set(string $key, $value): void
    {
        $this->parameters->add($key, $value);
    }

    public function getURLSections(): array
    {
        return $this->parameters->get('SECTIONS');
    }

    public function getURLSection(int $section)
    {
        return $this->parameters->get('SECTIONS', $section);
    }

    public function getHostSection(string $section)
    {
        return $this->parameters->get('HOST_SECTION', $section);
    }

    public function removeURLSection($section): void
    {
        // todo removing source parts is not save, deprecate this part
        $this->parameters->remove('HOST_SECTION.'.$section);
        $this->parameters['SECTIONS'] = array_values($this->parameters['SECTIONS']);
        $this->parameters['URI'] = implode('/', $this->parameters['SECTIONS']);
    }

    public function isMethod($method): bool
    {
        return strtoupper($method) === strtoupper($this->parameters->get('REQUEST_METHOD'));
    }

    public function isSubmitted($name = null): bool
    {
        return (null !== $name) ?
            $this->parameters->has('REQUEST_METHOD', $name):
            $this->parameters->has('REQUEST_METHOD')
        ;
    }
}

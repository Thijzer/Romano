<?php

namespace Romano\Framework\Router;

class Route
{
    /** @var string */
    private $url;
    /** @var Resource */
    private $resource;
    /** @var string */
    private $templatePath;

    public function __construct(string $url, Resource $resource, string $templatePath)
    {
        $this->url = $url;
        $this->resource = $resource;
        $this->templatePath = $templatePath;
    }

    /** @return string */
    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function getResource()
    {
        return $this->resource;
    }
}
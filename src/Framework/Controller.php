<?php

namespace Romano\Framework;

abstract class Controller
{
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function param($name)
    {
        return $this->params[$name];
    }

//    public function getTemplateResponse(): Response
//    {
//        return new Response($this->template);
//    }
//
//    public function getResourceResponse(): Response
//    {
//        return new Response($this->resource->render(), $this->resource->getScope());
//    }
}

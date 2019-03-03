<?php

namespace Framework;

abstract class Controller
{
    public function __construct()
    {
        $this->route = Matroska::getAll('route');
        $this->params = $this->route['parameter'];
    }

    public function param($name)
    {
        return $this->params[$name];
    }

    public function pagination($rowCount, $offset, $limit, $page = '?page=')
    {
        $requestedPage = 1;
        if (!isset($this->params['page'])) {
            $this->params['page'] = 1;
        }
        $options['offset'] = $offset;
        $options['limit'] = $limit;

        $options['num_items'] = $rowCount;
        $requestedPage = (int) $this->params['page'];
        $options['num_pages'] = (int) ceil($options['num_items'] / $options['limit']);

        if (0 === $options['num_pages']) {
            $options['num_pages'] = 1;
        }
        if ($requestedPage > $options['num_pages'] || $requestedPage < 1) {
            Output::page(404);
        }

        $options['requested_page'] = $requestedPage;
        $options['prev'] = $requestedPage - 1;
        $options['next'] = $requestedPage + 1;
        $options['url'] = '/';
        if (false !== strpos($page, '?')) {
            $options['url'] .= $this->route['url'];
        }
        $options['page'] = $page;
        $options['next_lbl'] = Lang::get('lbl.next');
        $options['prev_lbl'] = Lang::get('lbl.prev');
        $options['offset'] = ($options['requested_page'] * $options['limit']) - $options['limit'];

        return $options;
    }
}

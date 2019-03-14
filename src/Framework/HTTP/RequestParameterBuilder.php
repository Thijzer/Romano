<?php

namespace Romano\Framework\HTTP;

use Romano\Component\Common\ContainerInterface;
use Romano\Component\Common\Matroska;

class RequestParameterBuilder
{
    public static function buildParameters(array $server, array $resquest): ContainerInterface
    {
        $parameters = array_merge($server, $resquest);
        $parameters['URI'] = trim(str_replace('?'.$server['QUERY_STRING'], '', $server['REQUEST_URI']), '/');
        $parameters['SECTIONS'] = explode('/', $parameters['URI']);
        $parameters['HOST_SECTIONS'] = explode('.', $parameters['HTTP_HOST']);
        $parameters['LANGUAGE'] = '';
        $parameters['VIEW'] = '';
        $parts = pathinfo($parameters['URI']);
        if (isset($parts['extension'])) {
            $parameters['URI'] = str_replace('.'.$parts['extension'], '', $parameters['URI']);
            $parameters['VIEW'] = $parts['extension'];
            $parameters['SECTIONS'] = explode('/', $parameters['URI']);
        }

        parse_str($server['QUERY_STRING'], $parameters['PARAMS']);

        return new Request(Matroska::create($parameters));
    }
}

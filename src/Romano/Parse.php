<?php



Class Parse
{
    static $rule = array('key' => 'parser_cache'),
    $content,
    $single,
    $regex = array(),
    $match = array();

    static function grab($value)
    {
        if (!self::$single)
        {
            self::$single = new self;
        }
        self::setContent($value, self::$rule['key']);

        return self::$single;
    }

    static function setup($settings)
    {
        foreach ($settings as $key => $rule)
        {
            if ($key === 'key' OR $key === 'site' OR $key === 'action')
            {
                self::$rule[$key] = $rule;
            }
            elseif ($key === 'regex' AND is_array($key))
            {
                self::$regex = $rule;
            }
        }
    }

    public function find($keywords = null)
    {
        if (self::$rule['lookFor'])
        {
            return $this->looper($keywords, self::$regex[self::$rule['lookFor']]);
        }
        else
        {
            foreach (self::$regex as $key => $regex)
            {
                $array[$key] = $this->looper($keywords,$regex);
            }
            return $array;
        }
    }

    public function fetch()
    {
        foreach (self::$regex as $key => $regex)
        {
            $array[$key] = $this->looper(null ,$regex);
        }
        return $array;
    }

    public function lookFor($regexName)
    {
        self::$rule['lookFor'] = $regexName;
        return $this;
    }

    private function looper($fields = '',$regex = '')
    {
        $result = array();
        $new = array();
        // we need to check for a match if (!$match = self::$match[self::$rule['key']])

        if (!isset(self::$match[self::$rule['key']]) AND isset($regex))
        {
            preg_match_all($regex, self::$content[self::$rule['key']], $match);
            self::$match[self::$rule['key']] = $match;
        }
        if (isset($match[2]))
        {
            foreach ($match[1] as $key => $value)
            {
                $result[$value] = $match[2][$key];
            }
        }
        else $result = $match[1];

        if ($fields)
        {
            if (is_array($fields))
            {
                $new = array();
                foreach ($fields as $value)
                {
                    $new[$value] = $result[$value];
                }
                return $new;
            }
            elseif ($result[$fields])
            {
                return $result[$fields];
            }
        }
        return $result;
    }

    private static function setContent($site, $cache)
    {
        if (!isset(self::$content[$cache])) self::$content[$cache] = file_get_contents(self::$rule[$site]);
    }

    public static function smallXml($url = null)
    {
        if (self::checkUrl($url)) {
            $xml = simplexml_load_file($url);

            function toArray($xml)
            {
                $array = json_decode(json_encode($xml), TRUE);

                foreach ( array_slice($array, 0) as $key => $value ) {
                    if ( empty($value) ) $array[$key] = NULL;
                    elseif ( is_array($value) ) $array[$key] = toArray($value);
                }
                return $array;
            }

            return toArray($xml);
        }
    }

    public static function json($url)
    {
        if ($url = @file_get_contents(trim($url))) {

            // option self::$http_response_header; // keep save the headers for filetype check and 200 check
            return json_decode($url, true);
        }
    }

    /**
    * this is a slow but useful tool,
    * it's best not to use this to frequent or
    * on first if's better rather a if false checkUrl if
    *
    * @return boolean
    */
    public static function checkUrl($url = null)
    {
        if ($url) {
            $url = @file_get_contents(trim($url));
            // option self::$http_response_header; // keep save the headers for filetype check and 200 check
            return (strpos($http_response_header[0],'200') == true) ? true : false;
        }
    }
}

/*
public function index()
{
echo timestamp(2);

// we zoeken specificaties bij tweakers
$keyword = 'thinkpad';
// eerst de zoekopdracht
Parser::setup(array('key'   => 'find_'.$keyword,
'site'  => 'http://tweakers.net/pricewatch/zoeken/?keyword='.$keyword,
'regex' = array(
'specs' => '/<tr>\s*<td class="pwimage">\s*<a href="(.*)" title=".*?" rel="nofollow" class="thumb product">/i'
)));
$result = Parser::grab('site')->lookFor('specs')->fetch();

// result is een url voor specs die we bij de volgende crawl nodig hebben
Parser::set(array('key'   => $keyword,
'site'  => str_replace('.html', '/specificaties/',$result[0]),
'specs' => '/<td class="spec-index-column">(.*)<\/td>\s*<td class="spec-column">(.*)<\/td>/i'
));
dump( Parser::grab('site')->from('specs')->find('Snelheid') );
dump( Parser::grab('site')->find('Snelheid') );
dump( Parser::grab('site')->find(array('Snelheid', 'Product')) );

echo timestamp(2);
}


*/

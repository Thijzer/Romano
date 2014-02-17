<?php
namespace App\Library;

Class Parser
{
  static $rule = array('var' => 'parser_cache'),
        $content,
        $single,
        $regex,
        $match = array();

  static function grab($value)
  {
    if (!self::$single) {
      self::$single = new self;
    }
    self::setContent($value,self::$rule['var']);
    return self::$single;
  }
  static function set($settings)
  {
    foreach ($settings as $key => $value) {
      if ($key === 'var' OR $key === 'html' OR $key === 'action') {
        self::$rule[$key] = $value;
      } else {
        self::$regex[$key] = $value;
      }   
    }
  }
  public function find($fields = null)
  {
    if (self::$rule['from']) {
      return $this->looper($fields,self::$regex[self::$rule['from']]);
    }elseif (is_array(self::$regex)) {
      foreach (self::$regex as $key => $regex) {
        $array[$key] = $this->looper($fields,$regex);
      }
      return $array;
    }
    return false;
  }
  public function from($regex)
  {
    self::$rule['from'] = $regex;
    return $this;
  }
  private function looper($fields = '',$regex = '')
  {
    $result = array();
    $new = array();
    // we need to check for a match if (!$match = self::$match[self::$rule['var']])

    if (!isset(self::$match[self::$rule['var']]) AND isset($regex)) {
      preg_match_all($regex, self::$content[self::$rule['var']], $match);
      self::$match[self::$rule['var']] = $match;
    }
    if (isset($match[2])) {
      foreach ($match[1] as $key => $value) {
        $result[$value] = $match[2][$key]; 
      }
    } else {
      $result = $match[1];
    }

    if ($fields) {
      if (is_array($fields)) {
        $new = array();
        foreach ($fields as $value) {
          $new[$value] = $result[$value];
        }
        return $new;
      } elseif ($result[$fields]) {
        return $result[$fields];
      }
    }
    return $result;
  }
  private static function setContent($html, $var)
  {
    if (!isset(self::$content[$var])) {
      self::$content[$var] = file_get_contents(self::$rule[$html]);
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
    Parser::set(array('var'   => 'find_'.$keyword,
                      'html'  => 'http://tweakers.net/pricewatch/zoeken/?keyword='.$keyword,
                      'specs' => '/<tr>\s*<td class="pwimage">\s*<a href="(.*)" title=".*?" rel="nofollow" class="thumb product">/i'
                      ));
    $result = Parser::grab('html')->from('specs')->find();
    // result is een url voor specs die we bij de volgende crawl nodig hebben
    Parser::set(array('var'   => $keyword,
                      'html'  => str_replace('.html', '/specificaties/',$result[0]),
                      'specs' => '/<td class="spec-index-column">(.*)<\/td>\s*<td class="spec-column">(.*)<\/td>/i'
                      ));
    dump( Parser::grab('html')->from('specs')->find('Snelheid') );
    dump( Parser::grab('html')->find('Snelheid') );
    dump( Parser::grab('html')->find(array('Snelheid', 'Product')) );

    echo timestamp(2);
  }


*/
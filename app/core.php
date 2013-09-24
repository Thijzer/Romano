<?php
class Route
{
  var $r = array();

  public function __construct()
  {
    $this->r['section'] = explode('/', url);
    $pos = count($this->r['section']);
    list($this->r['section'][$pos-1], $this->r['action']) = explode('.', $this->r['section'][$pos-1]);

    if (!$this->r['section'][1]) {
      if (!$ctrlr = $this->r['section'][0]) {
        $this->autoRoute('home', 'index');
      } elseif (file_exists(VIEW.$ctrlr.'/index.php')) {
        $this->autoRoute($ctrlr, 'index');
      } else {
        $this->autoRoute('home', $ctrlr);
      }
    }
    $this->autoRoute($this->r['section'][0], $this->r['section'][1]);
  }
  private function autoRoute($ctrlr, $method)
  {
    $this->r['path'] = $ctrlr.'/'.$method;
    $this->r['section'][0] = $ctrlr;
    $this->r['section'][1] = $method;
    if (file_exists (CONTROLLER.$ctrlr.'.php')) {
      require (CONTROLLER.$ctrlr.'.php');
      $class = ucfirst($ctrlr);
      $init = new $class();
      if (method_exists($init, $method) && $method !== '__construct' && $method !== '_init_') {
        $init->{$method}($this->r);
        exit();
      }
    }
    $view = new View();
    if (file_exists (VIEW.$this->r['path'].'.php')) {
      $view->render($this->r,['title' => $method]);
    }
    $view->error(404,'from autoRoute, no page found');
  }
}
class View
{
  public function render($data,$arg = array())
  {
    $arg = array_merge(array('title' => ucfirst($data['section'][1]), 'path' => $data['path'], 'theme' => null),$arg);
    require_once (VIEW.$arg['path'].'.php');
    require_once (TMPL.'theme_library.php');

    head($arg['title']); css(); notice($data['msg']); if(DEV_ENV === true){echo timestamp(6);}
    echo "\n  </head>\n  <body>\n";
    if (is_null($arg['theme'])) {
      nav(); content($data); footer(); js();
      echo "\n  </body>\n</html>";
      $this->track(null, timestamp());
    } else {
      content($data);
    }
      echo "\n  </body>\n</html>";
      die();
  }
  public function error($page,$msg = null)
  {
    require_once (TMPL.'theme_library.php');
    require_once (VIEW.'error/'.$page.'.php');
    $this->track($page.': '.$msg, timestamp());
    die();
  }
  private function track($msg = null,$timestamp)
  {
    if ($_SESSION['current'] !== url) {
      $_SESSION['last'] = $_SESSION['current'];
      $_SESSION['current'] = url;
      if ($msg) {
        $slip = '-error';
        $msg  = '; msg: '.substr($msg,0,80);
      }
      if ($_SESSION['uid']) { $uid = '; uid: '.$_SESSION['uid'];}
      $track = 'date: '.date('j/m H:i:s').'; page: /'.url.$uid.'; speed: '.$timestamp.'ms'.$msg."\r\n";
      if (DEV_ENV !== true OR $msg) {
        $file = fopen(PROJECT.'logs/'.date('MY').$slip.'.log', 'a+');
        fwrite($file,$track);
        fclose($file);
      } else {
        echo $track;
      }
    }
  }
}
class Model
{
}
class Ctrlr
{
  protected function _init_($i)
  {
    require (MODEL.$i.'.php');
    $class = ucfirst($i);
    $init = new $class();
    return $init;
  }
}
New Route;
?>
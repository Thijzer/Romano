<?php



class Track
{
    private $client = array();
    private $ipList = array('HTTP_CLIENT_IP', 'REMOTE_ADDR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED');
    private $os = array(
    'phone' => array(
    'iPhone' => 'iPhone;', 'iPod' => 'Apple-iPod',
    'android' => 'Android.*(Chrome.*Mobile)|(Mobile.*Firefox)'
    ),
    'desktop' => array(
    'Windows 7' => '(Windows NT 6.1)', 'Windows 8' => '(Windows NT 6.2)',
    'Windows Vista' => '(Windows NT 6.0)', 'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
    'Linux' => '(Linux)|(X11)'
    ),
    'tablet' => array(
    'iPad' => 'iPad', 'android' => 'Android.*(Chrome)|(Firefox).*(?!Mobile)'
    ),
    'spiders' => array(
    'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves\/Teoma)|(ia_archiver)',
    'Search Bot2' => '(Yahoo)|(Lycos)|(Scooter)|(AltaVista)|(Teoma)|(Gigabot)|(Googlebot-Mobile)'
    ),
    'legacy' => array(
    'Windows 3.11' => 'Win16', 'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
    'Windows 98' => '(Windows 98)|(Win98)', 'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
    'Windows XP' => '(Windows NT 5.1)|(Windows XP)', 'Windows Server 2003' => '(Windows NT 5.2)',
    'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)', 'Windows ME' => 'Windows ME',
    'Open BSD' => 'OpenBSD', 'Sun OS' => 'SunOS', 'QNX' => 'QNX', 'BeOS' => 'BeOS', 'OS\/2' => 'OS\/2'
    )
    );

    public static function get()
    {
        return Singleton::getInstance(get_class());
    }

    public function IP()
    {
        foreach ($this->ipList as $key) {
            if (isset($_SERVER[$key])) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if(!filter_var(trim($ip), FILTER_VALIDATE_IP | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                        $this->client['env'] = 'local';
                        $this->client['ip'] = $ip;
                        return $this;
                    }
                }
                $this->client['env'] = 'global';
                $this->client['ip'] = $ip;
                return $this;
            }
        }
    }

    public function OS()
    {
        foreach ($this->os as $type => $osTypes) {
            foreach($osTypes as $current0S => $match) {
                if (preg_match('/' . $match . '/i', $_SERVER['HTTP_USER_AGENT'])) {
                    $this->client['device'] = $type;
                    $this->client['os'] = $current0S;
                    return $this;
                }
            }
        }
    }

    public function fromClient()
    {
        if(!$this->client) {
            $this->OS();
            $this->IP();
        }
        return $this->client;
    }
}

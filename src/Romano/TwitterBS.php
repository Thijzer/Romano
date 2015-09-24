<?php



Class Bootstrap
{
    function __construct()
    {
        // elements
        $this->h1 = html::elem('h1');
        $this->li = html::elem('li');
        $this->a = html::elem('a');
        $this->ul = html::elem('ul');
        $this->div = html::elem('div');
        $this->header = html::elem('header');
    }

    function Nav($nav)
    {
        function loopOver($nav, $li, $a, $ul = '')
        {
            $tmp = '';
            foreach ($nav as $main) {
                $tmp .= $li->end($a->href('{{ meta.site }}'.$main['url'])->end($main['label']));
                if(isset($main['sibs'])) $tmp .= $li->end($ul->end(loopOver2($main['sibs'], $li, $a, $ul) ) );
            }
            return $tmp;
        }

        return $this->ul->end(loopOver($nav, $this->li, $this->a, $this->ul));
    }
}

Class twitterBS extends Bootstrap
{
    function __construct()
    {
        parent::__construct();
        $this->ulDrop = html::elem('ul')->class('dropdown-menu');
        $this->aDrop = html::elem('a')->class('dropdown-toggle')->data__toggle('dropdown');
        $this->liDrop = html::elem('li')->class('dropdown');
        $this->ulNav = html::elem('ul')->class('navcontainer', 'lead');
        $this->b = html::elem('b')->class('caret')->end();
    }

    function BootstrapNav($nav)
    {
        function loopOver($nav, $li, $a, $liDrop = '', $aDrop = '', $ulDrop ='', $b = '', $fill = '')
        {
            $tmp = '';
            foreach ($nav as $main) {
                $tmp .= $li->end($a->href('{{ meta.site }}'.$main['url'])->end($main['label']));
                if(isset($main['sibs'])) $tmp .= $liDrop->end( $aDrop->end($b) . $ulDrop->end(loopOver($main['sibs'], $li, $a) ) );
                $tmp .=  $fill;
            }
            return $tmp;
        }

        return $this->header->class('header')->end(
            $this->div->class('container')->end(
                $this->h1->end('something') .
                $this->ulNav->end(loopOver($nav, $this->li, $this->a, $this->liDrop, $this->aDrop, $this->ulDrop, $this->b, ' //'))
                )
            );
    }
}

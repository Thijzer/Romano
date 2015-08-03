<?php

/* nav.html_build */
class __TwigTemplate_0cb127aa24b30b264f0d1077034dd881ad56cfdfcd4c0b57f061db8c8b5d1c8a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"container\">
    <h1>something</h1>
    <ul class=\"navcontainer lead\">
        <li><a href=\"/\">blog</a></li> //
        <li><a href=\"/collections\">collections</a></li>
        <li class=\"dropdown\">
            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></a>
            <ul class=\"dropdown-menu\">
                <li><a href=\"/movies\">movies</a></li>
                <li><a href=\"/tvshows\">tvshows</a></li>
            </ul>
        </li> //
        <li><a href=\"/contact\">contact</a></li> //
        <li><a href=\"/about\">about</a></li>
    </ul>
</div>
<HR>
";
    }

    public function getTemplateName()
    {
        return "nav.html_build";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}

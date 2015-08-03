<?php

/* ga.html */
class __TwigTemplate_ee09c1d10f90829f9fe914c6e64be73b5fe5c1b0051fc9577a20a288ab729b7f extends Twig_Template
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
        echo "    <!-- Google analitics -->
<!--    <script type=\"text/javascript\">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-7118296-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script> -->";
    }

    public function getTemplateName()
    {
        return "ga.html";
    }

    public function getDebugInfo()
    {
        return array (  67 => 29,  60 => 25,  52 => 20,  43 => 14,  35 => 9,  31 => 8,  27 => 7,  19 => 1,);
    }
}

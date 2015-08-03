<?php

/* ga.html */
class __TwigTemplate_6c19328fc4238b14961ed555ce6aaf4557b73caba20c83272396b652fd77e050 extends Twig_Template
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
        return array (  19 => 1,);
    }
}

<?php

/* base_bs.twig */
class __TwigTemplate_2a33a246a9f582c020270dc3cdc9239a2dba3397323e895319abd873149e24eb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'sidebar' => array($this, 'block_sidebar'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html ng-app=\"myModule\">
  <head>
    <meta charset=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "charset"), "html", null, true);
        echo "\">
    <title>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "title"), "html", null, true);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "description"), "html", null, true);
        echo "\">
    <meta name=\"author\" content=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "author"), "html", null, true);
        echo "\">
    <!-- Fav and touch icons -->
    <link rel=\"shortcut icon\" href=\"/favicon.ico\">

    <!-- CSS styles -->
    <link rel=\"stylesheet\" href=\"/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"/css/default.css\">
  </head>
  <body>
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-8 col-xl-8\" role=\"main\">
                ";
        // line 20
        $this->displayBlock('content', $context, $blocks);
        // line 22
        echo "            </div>
            <div class=\"col-md-4 col-xl-4 hidden-xs\">
                <div class=\"sidebar\" role=\"complementary\">
                    ";
        // line 25
        $this->displayBlock('sidebar', $context, $blocks);
        // line 27
        echo "                </div>
            </div>
        </div>
    </div>
  </body>
</html>
";
    }

    // line 20
    public function block_content($context, array $blocks = array())
    {
        // line 21
        echo "                ";
    }

    // line 25
    public function block_sidebar($context, array $blocks = array())
    {
        // line 26
        echo "                    ";
    }

    public function getTemplateName()
    {
        return "base_bs.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  83 => 26,  80 => 25,  76 => 21,  73 => 20,  63 => 27,  61 => 25,  56 => 22,  54 => 20,  39 => 8,  35 => 7,  30 => 5,  26 => 4,  21 => 1,);
    }
}

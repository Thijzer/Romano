<?php

/* base-simple.twig */
class __TwigTemplate_9ac7301fd8f973268cb18d576a0c88021f276c46cbd967190f33af3b872cbe82 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'css' => array($this, 'block_css'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"utf-8\">
    <title>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "title", array()), "html", null, true);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">
    <!-- Fav and touch icons -->
    <link rel=\"shortcut icon\" href=\"/favicon.ico\">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src=\"//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js\"></script>
      <script src=\"//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js\"></script>
    <![endif]-->

    <!-- CSS styles -->
    <link rel=\"stylesheet\" href=\"//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"/css/default.css\">
    ";
        // line 20
        $this->displayBlock('css', $context, $blocks);
        // line 22
        echo "    <div id=\"bootstrapCssTest\" class=\"hide\"></div>
  </head>
  <body>
  ";
        // line 25
        $this->env->loadTemplate("messages.html")->display($context);
        // line 26
        echo "  ";
        $this->displayBlock('content', $context, $blocks);
        // line 28
        echo "  ";
        $this->env->loadTemplate("ga.html")->display($context);
        // line 29
        echo "  </body>
  ";
        // line 30
        $this->env->loadTemplate("js.html")->display($context);
        // line 31
        echo "</html>
";
    }

    // line 20
    public function block_css($context, array $blocks = array())
    {
        // line 21
        echo "    ";
    }

    // line 26
    public function block_content($context, array $blocks = array())
    {
        // line 27
        echo "  ";
    }

    public function getTemplateName()
    {
        return "base-simple.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 27,  77 => 26,  73 => 21,  70 => 20,  65 => 31,  63 => 30,  60 => 29,  57 => 28,  54 => 26,  52 => 25,  47 => 22,  45 => 20,  27 => 5,  21 => 1,);
    }
}

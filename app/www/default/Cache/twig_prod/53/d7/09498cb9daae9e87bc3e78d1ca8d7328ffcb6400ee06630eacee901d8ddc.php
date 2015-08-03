<?php

/* base.twig */
class __TwigTemplate_53d709498cb9daae9e87bc3e78d1ca8d7328ffcb6400ee06630eacee901d8ddc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'css' => array($this, 'block_css'),
            'content' => array($this, 'block_content'),
            'sidebar' => array($this, 'block_sidebar'),
            'js' => array($this, 'block_js'),
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
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "charset", array()), "html", null, true);
        echo "\">
    <title>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "title", array()), "html", null, true);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "description", array()), "html", null, true);
        echo "\">
    <meta name=\"author\" content=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "author", array()), "html", null, true);
        echo "\">
    <!-- Fav and touch icons -->
    <link rel=\"shortcut icon\" href=\"/favicon.ico\">

    <!-- CSS styles -->
    <link rel=\"stylesheet\" href=\"/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"/css/default.css\">
    ";
        // line 15
        $this->displayBlock('css', $context, $blocks);
        // line 17
        echo "  </head>
  <body>
    ";
        // line 19
        $this->env->loadTemplate("messages.html")->display($context);
        // line 20
        echo "    ";
        $this->env->loadTemplate("nav.html_build")->display($context);
        // line 21
        echo "    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-8 col-xl-8\" role=\"main\">
                ";
        // line 24
        $this->displayBlock('content', $context, $blocks);
        // line 26
        echo "            </div>
            <div class=\"col-md-4 col-xl-4 hidden-xs\">
                <div class=\"sidebar\" role=\"complementary\">
                    ";
        // line 29
        $this->displayBlock('sidebar', $context, $blocks);
        // line 31
        echo "                </div>
            </div>
        </div>
    ";
        // line 34
        $this->env->loadTemplate("footer.html")->display($context);
        // line 35
        echo "    ";
        $this->env->loadTemplate("ga.html")->display($context);
        // line 36
        echo "    </div>
  </body>
  ";
        // line 38
        $this->env->loadTemplate("js.html")->display($context);
        // line 39
        echo "  ";
        $this->displayBlock('js', $context, $blocks);
        // line 41
        echo "</html>
";
    }

    // line 15
    public function block_css($context, array $blocks = array())
    {
        // line 16
        echo "    ";
    }

    // line 24
    public function block_content($context, array $blocks = array())
    {
        // line 25
        echo "                ";
    }

    // line 29
    public function block_sidebar($context, array $blocks = array())
    {
        // line 30
        echo "                    ";
    }

    // line 39
    public function block_js($context, array $blocks = array())
    {
        // line 40
        echo "  ";
    }

    public function getTemplateName()
    {
        return "base.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 40,  121 => 39,  117 => 30,  114 => 29,  110 => 25,  107 => 24,  103 => 16,  100 => 15,  95 => 41,  92 => 39,  90 => 38,  86 => 36,  83 => 35,  81 => 34,  76 => 31,  74 => 29,  69 => 26,  67 => 24,  62 => 21,  59 => 20,  57 => 19,  53 => 17,  51 => 15,  41 => 8,  37 => 7,  32 => 5,  28 => 4,  23 => 1,);
    }
}

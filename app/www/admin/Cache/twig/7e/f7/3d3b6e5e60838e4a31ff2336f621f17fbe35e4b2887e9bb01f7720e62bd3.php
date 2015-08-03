<?php

/* base.twig */
class __TwigTemplate_7ef73d3b6e5e60838e4a31ff2336f621f17fbe35e4b2887e9bb01f7720e62bd3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'css' => array($this, 'block_css'),
            'content' => array($this, 'block_content'),
            'js' => array($this, 'block_js'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<html lang=\"en\" ng-app=\"Dashboard\">
<head>
  <meta charset=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "charset"), "html", null, true);
        echo "\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <title>Dashboard</title>
  <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/dashboard.min.css\">
  ";
        // line 8
        $this->displayBlock('css', $context, $blocks);
        // line 10
        echo "  <script type=\"text/javascript\" src=\"/js/vendors.min.js\"></script>
  <script type=\"text/javascript\" src=\"/js/dashboard.min.js\"></script>
  <!-- <script type=\"text/javascript\" src=\"/js/dashboard/module.js\"></script> -->
  <script type=\"text/javascript\" src=\"/js/dashboard/controllers/master-ctrl.js\"></script>
</head>
  <body ng-controller=\"MasterCtrl\">
      <div id=\"page-wrapper\" ng-class=\"{'active': toggle}\" ng-cloak>
      <!-- Sidebar -->
      ";
        // line 18
        $this->env->loadTemplate("nav.html")->display($context);
        // line 19
        echo "      <!-- End Sidebar -->
        <div id=\"content-wrapper\">
          <div class=\"page-content\">
            <!-- Header Bar -->
            ";
        // line 23
        $this->env->loadTemplate("header.html")->display($context);
        // line 24
        echo "            <!-- End Header Bar -->
            <!-- Main Content -->
            <section data-ui-view></section>
            ";
        // line 28
        echo "            <!-- End Main Content -->
            ";
        // line 29
        $this->displayBlock('content', $context, $blocks);
        // line 31
        echo "            ";
        $this->env->loadTemplate("footer.html")->display($context);
        // line 32
        echo "            ";
        $this->env->loadTemplate("js.html")->display($context);
        // line 33
        echo "          </div><!-- End Page Content -->
        </div><!-- End Content Wrapper -->
      </div><!-- End Page Wrapper -->
    ";
        // line 36
        $this->displayBlock('js', $context, $blocks);
        // line 38
        echo "  </body>
</html>
";
    }

    // line 8
    public function block_css($context, array $blocks = array())
    {
        // line 9
        echo "  ";
    }

    // line 29
    public function block_content($context, array $blocks = array())
    {
        // line 30
        echo "            ";
    }

    // line 36
    public function block_js($context, array $blocks = array())
    {
        // line 37
        echo "    ";
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
        return array (  102 => 37,  99 => 36,  95 => 30,  92 => 29,  88 => 9,  85 => 8,  79 => 38,  77 => 36,  72 => 33,  69 => 32,  66 => 31,  64 => 29,  61 => 28,  56 => 24,  54 => 23,  48 => 19,  46 => 18,  36 => 10,  34 => 8,  27 => 4,  22 => 1,);
    }
}

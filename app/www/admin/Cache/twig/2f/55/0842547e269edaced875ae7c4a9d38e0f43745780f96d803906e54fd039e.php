<?php

/* base-dashboard.twig */
class __TwigTemplate_2f550842547e269edaced875ae7c4a9d38e0f43745780f96d803906e54fd039e extends Twig_Template
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
        echo "<!DOCTYPE html>
<html ng-app=\"myModule\">
  <head>
    <meta charset=\"utf-8\">
    <title>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "title"), "html", null, true);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">
    <!-- Fav and touch icons -->
    <link rel=\"shortcut icon\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site"), "html", null, true);
        echo "favicon.ico\">

    <!-- CSS styles -->
    <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site"), "html", null, true);
        echo "css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site"), "html", null, true);
        echo "css/dashboard.css\">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
      <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>
    <![endif]-->
  </head>

  <body>
    <div class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">
      <div class=\"container-fluid\">
        <div class=\"navbar-header\">
          <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
            <span class=\"sr-only\">Toggle navigation</span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
          </button>
          <a class=\"navbar-brand\" href=\"#\">Project name</a>
        </div>
        <div class=\"navbar-collapse collapse\">
          <ul class=\"nav navbar-nav navbar-right\">
            <li><a href=\"#\">Dashboard</a></li>
            <li><a href=\"#\">Settings</a></li>
            <li><a href=\"#\">Profile</a></li>
            <li><a href=\"#\">Help</a></li>
          </ul>
          <form class=\"navbar-form navbar-right\">
            <input type=\"text\" class=\"form-control\" placeholder=\"Search...\">
          </form>
        </div>
      </div>
    </div>

    <div class=\"container-fluid\">
      <div class=\"row\">
        <div class=\"col-sm-3 col-md-2 sidebar\">
          <ul class=\"nav nav-sidebar\">
            <li class=\"active\"><a href=\"#\">Overview</a></li>
            <li><a href=\"#\">Reports</a></li>
            <li><a href=\"#\">Analytics</a></li>
            <li><a href=\"#\">Export</a></li>
          </ul>
          <ul class=\"nav nav-sidebar\">
            <li><a href=\"\">Nav item</a></li>
            <li><a href=\"\">Nav item again</a></li>
            <li><a href=\"\">One more nav</a></li>
            <li><a href=\"\">Another nav item</a></li>
            <li><a href=\"\">More navigation</a></li>
          </ul>
          <ul class=\"nav nav-sidebar\">
            <li><a href=\"\">Nav item again</a></li>
            <li><a href=\"\">One more nav</a></li>
            <li><a href=\"\">Another nav item</a></li>
          </ul>
        </div>
        <div class=\"col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main\">
          <h1 class=\"page-header\">Dashboard</h1>

          <div class=\"row placeholders\">
            <div class=\"col-xs-6 col-sm-3 placeholder\">
              <img data-src=\"holder.js/200x200/auto/sky\" class=\"img-responsive\" alt=\"Generic placeholder thumbnail\">
              <h4>Label</h4>
              <span class=\"text-muted\">Something else</span>
            </div>
            <div class=\"col-xs-6 col-sm-3 placeholder\">
              <img data-src=\"holder.js/200x200/auto/vine\" class=\"img-responsive\" alt=\"Generic placeholder thumbnail\">
              <h4>Label</h4>
              <span class=\"text-muted\">Something else</span>
            </div>
            <div class=\"col-xs-6 col-sm-3 placeholder\">
              <img data-src=\"holder.js/200x200/auto/sky\" class=\"img-responsive\" alt=\"Generic placeholder thumbnail\">
              <h4>Label</h4>
              <span class=\"text-muted\">Something else</span>
            </div>
            <div class=\"col-xs-6 col-sm-3 placeholder\">
              <img data-src=\"holder.js/200x200/auto/vine\" class=\"img-responsive\" alt=\"Generic placeholder thumbnail\">
              <h4>Label</h4>
              <span class=\"text-muted\">Something else</span>
            </div>
          </div>

          <h2 class=\"sub-header\">Section title</h2>
          <div class=\"table-responsive\">
            <table class=\"table table-striped\">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Header</th>
                  <th>Header</th>
                  <th>Header</th>
                  <th>Header</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1,001</td>
                  <td>Lorem</td>
                  <td>ipsum</td>
                  <td>dolor</td>
                  <td>sit</td>
                </tr>
                <tr>
                  <td>1,002</td>
                  <td>amet</td>
                  <td>consectetur</td>
                  <td>adipiscing</td>
                  <td>elit</td>
                </tr>
                <tr>
                  <td>1,003</td>
                  <td>Integer</td>
                  <td>nec</td>
                  <td>odio</td>
                  <td>Praesent</td>
                </tr>
                <tr>
                  <td>1,003</td>
                  <td>libero</td>
                  <td>Sed</td>
                  <td>cursus</td>
                  <td>ante</td>
                </tr>
                <tr>
                  <td>1,004</td>
                  <td>dapibus</td>
                  <td>diam</td>
                  <td>Sed</td>
                  <td>nisi</td>
                </tr>
                <tr>
                  <td>1,005</td>
                  <td>Nulla</td>
                  <td>quis</td>
                  <td>sem</td>
                  <td>at</td>
                </tr>
                <tr>
                  <td>1,006</td>
                  <td>nibh</td>
                  <td>elementum</td>
                  <td>imperdiet</td>
                  <td>Duis</td>
                </tr>
                <tr>
                  <td>1,007</td>
                  <td>sagittis</td>
                  <td>ipsum</td>
                  <td>Praesent</td>
                  <td>mauris</td>
                </tr>
                <tr>
                  <td>1,008</td>
                  <td>Fusce</td>
                  <td>nec</td>
                  <td>tellus</td>
                  <td>sed</td>
                </tr>
                <tr>
                  <td>1,009</td>
                  <td>augue</td>
                  <td>semper</td>
                  <td>porta</td>
                  <td>Mauris</td>
                </tr>
                <tr>
                  <td>1,010</td>
                  <td>massa</td>
                  <td>Vestibulum</td>
                  <td>lacinia</td>
                  <td>arcu</td>
                </tr>
                <tr>
                  <td>1,011</td>
                  <td>eget</td>
                  <td>nulla</td>
                  <td>Class</td>
                  <td>aptent</td>
                </tr>
                <tr>
                  <td>1,012</td>
                  <td>taciti</td>
                  <td>sociosqu</td>
                  <td>ad</td>
                  <td>litora</td>
                </tr>
                <tr>
                  <td>1,013</td>
                  <td>torquent</td>
                  <td>per</td>
                  <td>conubia</td>
                  <td>nostra</td>
                </tr>
                <tr>
                  <td>1,014</td>
                  <td>per</td>
                  <td>inceptos</td>
                  <td>himenaeos</td>
                  <td>Curabitur</td>
                </tr>
                <tr>
                  <td>1,015</td>
                  <td>sodales</td>
                  <td>ligula</td>
                  <td>in</td>
                  <td>libero</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body> 
  ";
        // line 228
        $this->env->loadTemplate("js.html")->display($context);
        // line 229
        echo "</html>";
    }

    public function getTemplateName()
    {
        return "base-dashboard.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  262 => 229,  260 => 228,  43 => 14,  39 => 13,  33 => 10,  25 => 5,  19 => 1,  31 => 3,  28 => 2,);
    }
}

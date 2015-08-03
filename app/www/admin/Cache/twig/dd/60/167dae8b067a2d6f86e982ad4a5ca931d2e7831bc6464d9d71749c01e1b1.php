<?php

/* messages.html */
class __TwigTemplate_dd60167dae8b067a2d6f86e982ad4a5ca931d2e7831bc6464d9d71749c01e1b1 extends Twig_Template
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
        // line 8
        if ((isset($context["notice"]) ? $context["notice"] : null)) {
            // line 9
            echo "<div class=\"alert alert-success\">
    <p>";
            // line 10
            echo twig_escape_filter($this->env, (isset($context["notice"]) ? $context["notice"] : null), "html", null, true);
            echo "</p>
</div>
";
        }
        // line 13
        echo "
<div class=\"row alerts-container\" data-ng-controller=\"AlertsCtrl\" data-ng-show=\"alerts.length\">
  <div class=\"col-xs-12\">
    <alert data-ng-repeat=\"alert in alerts\" type=\"[[alert.type]]\" close=\"closeAlert(\$index)\">[[alert.msg]]</alert>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "messages.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 13,  24 => 10,  21 => 9,  19 => 8,  85 => 23,  82 => 22,  78 => 19,  75 => 18,  71 => 9,  68 => 8,  62 => 24,  59 => 22,  56 => 21,  53 => 20,  51 => 18,  48 => 17,  45 => 16,  43 => 15,  36 => 10,  34 => 8,  27 => 4,  22 => 1,  31 => 4,  28 => 3,);
    }
}

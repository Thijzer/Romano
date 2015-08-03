<?php

/* messages.html */
class __TwigTemplate_377296826c0658e567753d143ad68a55a8bc0f2f4f7d8f23223bb85f330c79b9 extends Twig_Template
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
        return array (  30 => 13,  24 => 10,  21 => 9,  19 => 8,  124 => 40,  121 => 39,  117 => 30,  114 => 29,  110 => 25,  107 => 24,  103 => 16,  100 => 15,  95 => 41,  92 => 39,  90 => 38,  86 => 36,  83 => 35,  81 => 34,  76 => 31,  74 => 29,  69 => 26,  62 => 21,  59 => 20,  57 => 19,  53 => 17,  51 => 15,  41 => 8,  37 => 7,  32 => 5,  23 => 1,  67 => 24,  46 => 16,  31 => 3,  28 => 4,);
    }
}

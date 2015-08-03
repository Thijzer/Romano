<?php

/* nav.html */
class __TwigTemplate_f63e46554336fa5c5f740b00f388732e42ef81ec65926d3539216e669de7852d extends Twig_Template
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
        echo "  <div id=\"sidebar-wrapper\">
    <ul class=\"sidebar\">
      <li class=\"sidebar-main\">
        <a href=\"#\" ng-click=\"toggleSidebar()\">
          Dashboard
          <span class=\"menu-icon glyphicon glyphicon-transfer\"></span>
        </a>
      </li>
      <li class=\"sidebar-title\"><span>NAVIGATION</span></li>
      <li class=\"sidebar-list\">
        <a href=\"#/ooj\">Dashboard <span class=\"menu-icon fa fa-tachometer\"></span></a>
      </li>
      <li class=\"sidebar-list\">
        <a href=\"#/tables\">Tables <span class=\"menu-icon fa fa-table\"></span></a>
      </li>
    </ul>
    <div class=\"sidebar-footer\">
      <div class=\"col-xs-4\">
        <a href=\"https://github.com/Ehesp/Responsive-Dashboard\" target=\"_blank\">
          Github
        </a>
      </div>
      <div class=\"col-xs-4\">
        <a href=\"#\" target=\"_blank\">
          About
        </a>
      </div>
      <div class=\"col-xs-4\">
        <a href=\"#\">
          Support
        </a>
      </div>
    </div>
  </div>
";
    }

    public function getTemplateName()
    {
        return "nav.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}

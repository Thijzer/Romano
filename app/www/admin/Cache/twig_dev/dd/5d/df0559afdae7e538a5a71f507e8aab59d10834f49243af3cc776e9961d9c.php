<?php

/* header.html */
class __TwigTemplate_dd5ddf0559afdae7e538a5a71f507e8aab59d10834f49243af3cc776e9961d9c extends Twig_Template
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
        echo "<div class=\"row header\">
  <div class=\"col-xs-12\">
    <div class=\"user pull-right\">
      <div class=\"item dropdown\">
        <a href=\"#\" class=\"dropdown-toggle\">
          <img src=\"/img/avatar.jpg\">
        </a>
        <ul class=\"dropdown-menu dropdown-menu-right\">
          <li class=\"dropdown-header\">
            Joe Bloggs
          </li>
          <li class=\"divider\"></li>
          <li class=\"link\">
            <a href=\"#\">
              Profile
            </a>
          </li>
          <li class=\"link\">
            <a href=\"#\">
              Menu Item
            </a>
          </li>
          <li class=\"link\">
            <a href=\"#\">
              Menu Item
            </a>
          </li>
          <li class=\"divider\"></li>
          <li class=\"link\">
            <a href=\"#\">
              Logout
            </a>
          </li>
        </ul>
      </div>
      <div class=\"item dropdown\">
       <a href=\"#\" class=\"dropdown-toggle\">
          <i class=\"fa fa-bell-o\"></i>
        </a>
        <ul class=\"dropdown-menu dropdown-menu-right\">
          <li class=\"dropdown-header\">
            Notifications
          </li>
          <li class=\"divider\"></li>
          <li>
            <a href=\"#\">Server Down!</a>
          </li>
        </ul>
      </div>
    </div>
    <div class=\"meta\">
      <div class=\"page\">
        Dashboard
      </div>
      <div class=\"breadcrumb-links\">
        Home / Dashboard
      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "header.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}

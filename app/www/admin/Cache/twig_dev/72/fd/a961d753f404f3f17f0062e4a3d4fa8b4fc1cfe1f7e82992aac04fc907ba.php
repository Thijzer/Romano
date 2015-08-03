<?php

/* home/index.twig */
class __TwigTemplate_72fda961d753f404f3f17f0062e4a3d4fa8b4fc1cfe1f7e82992aac04fc907ba extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 3
        try {
            $this->parent = $this->env->loadTemplate("base.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(3);

            throw $e;
        }

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"row\">
  <div class=\"col-lg-6\">
      <rd-widget>
        <rd-widget-header icon=\"fa-tasks\" title=\"Servers\">
          <a href=\"#\" class=\"pull-right\">Manage</a>
        </rd-widget-header>
        <rd-widget-body classes=\"medium no-padding\">
          <div class=\"table-responsive\">
            <table class=\"table\">
              <tbody>
                ";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["track"]) ? $context["track"] : null), "env", array()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["track"]) ? $context["track"] : null), "device", array()), "html", null, true);
        echo "  ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["track"]) ? $context["track"] : null), "os", array()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["track"]) ? $context["track"] : null), "ip", array()), "html", null, true);
        echo "
                <tr><td>RDVMPC001</td><td>238.103.133.37</td><td><span class=\"text-success\"><i class=\"fa fa-check\"></i></span></td></tr>
                <tr><td>RDVMPC002</td><td>68.66.63.170</td><td><span class=\"text-success\"><i class=\"fa fa-check\"></i></span></td></tr>
                <tr><td>RDVMPC003</td><td>76.117.212.33</td><td><span tooltip=\"Server Down!\" class=\"text-danger\"><i class=\"fa fa-warning\"></i></span></td></tr>
                <tr><td>RDPHPC001</td><td>91.88.224.5</td><td><span class=\"text-success\"><i class=\"fa fa-check\"></i></span></td></tr>
                <tr><td>RDESX001</td><td>197.188.15.93</td><td><span class=\"text-success\"><i class=\"fa fa-check\"></i></span></td></tr>
                <tr><td>RDESX002</td><td>168.85.154.251</td><td><span class=\"text-success\"><i class=\"fa fa-check\"></i></span></td></tr>
                <tr><td>RDESX003</td><td>209.25.191.61</td><td><span tooltip=\"Server Down!\" class=\"text-danger\"><i class=\"fa fa-warning\"></i></span></td></tr>
                <tr><td>RDESX004</td><td>252.37.192.235</td><td><span class=\"text-success\"><i class=\"fa fa-check\"></i></span></td></tr>
                <tr><td>RDTerminal01</td><td>139.71.18.207</td><td><span class=\"text-success\"><i class=\"fa fa-check\"></i></span></td></tr>
                <tr><td>RDTerminal02</td><td>136.80.122.212</td><td><span tooltip=\"Could not connect!\" class=\"text-warning\"><i class=\"fa fa-flash\"></i></span></td></tr>
                <tr><td>RDDomainCont01</td><td>196.80.245.33</td><td><span class=\"text-success\"><i class=\"fa fa-check\"></i></span></td></tr>
              </tbody>
            </table>
          </div>
        </rd-widget-body>
      </rd-widget>
  </div>
</div>


";
    }

    public function getTemplateName()
    {
        return "home/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 14,  38 => 4,  11 => 3,);
    }
}

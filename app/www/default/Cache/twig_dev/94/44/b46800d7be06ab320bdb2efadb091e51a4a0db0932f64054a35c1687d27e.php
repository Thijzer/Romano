<?php

/* js.html */
class __TwigTemplate_9444b46800d7be06ab320bdb2efadb091e51a4a0db0932f64054a35c1687d27e extends Twig_Template
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
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "js/blog.min.js\"></script>
    <script src=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "js/base.js\"></script>";
    }

    public function getTemplateName()
    {
        return "js.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 2,  19 => 1,);
    }
}

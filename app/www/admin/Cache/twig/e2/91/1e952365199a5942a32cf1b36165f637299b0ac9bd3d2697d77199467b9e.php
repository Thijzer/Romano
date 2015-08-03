<?php

/* js.html */
class __TwigTemplate_e2911e952365199a5942a32cf1b36165f637299b0ac9bd3d2697d77199467b9e extends Twig_Template
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
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site"), "html", null, true);
        echo "js/blog.min.js\"></script>
    <script src=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site"), "html", null, true);
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
        return array (  24 => 2,  262 => 229,  260 => 228,  43 => 14,  39 => 13,  33 => 10,  25 => 5,  19 => 1,  31 => 3,  28 => 2,);
    }
}

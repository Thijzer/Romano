<?php

/* footer.html */
class __TwigTemplate_3c6d6a0f017914227f23e7b34be5dd57022be241321f4f755bb9220868b3ab1e extends Twig_Template
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
        echo "      <!--=== Copyright ===-->
      <footer>
        <HR>
        <div class=\"container\">
          <div class=\"pull-right hidden-xs\">
            <ul class=\"navcontainer pull-right\">
              <li><a href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "\">blog </a>//</li>
              <li><a href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "contact\">contact </a>//</li>
              <li><a href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "about\">about </a></li>
            </ul>
          </div>
          <div>
            <p>&copy; title | 
              <a href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "about#framework\">Romano.Framework</a>
            </p>
          </div>
          <ul class=\"navcontainer pull-center icons\">
            <li>
              <a href=\"https://twitter.com/Thijzer\" target=\"_blank\">
                <img src=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "img/twitter.png\">
              </a>
            </li>
            <li>
              <a href=\"https://www.facebook.com/thijzer\" target=\"_blank\">
                <img src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "img/facebook.png\"></a>
            </li>
            <li>
              <a href=\"https://plus.google.com/108354583103011120629/posts\" target=\"_blank\">
                <img src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "img/google.png\">
              </a>
            </li>
          </ul>
        </div>
      </footer>";
    }

    public function getTemplateName()
    {
        return "footer.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 29,  60 => 25,  52 => 20,  43 => 14,  35 => 9,  31 => 8,  27 => 7,  19 => 1,);
    }
}

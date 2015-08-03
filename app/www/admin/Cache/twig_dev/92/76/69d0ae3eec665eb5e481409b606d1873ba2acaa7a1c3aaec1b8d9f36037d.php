<?php

/* footer.html */
class __TwigTemplate_927669d0ae3eec665eb5e481409b606d1873ba2acaa7a1c3aaec1b8d9f36037d extends Twig_Template
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
    <section class=\"section\">
      <footer>
        <HR>
            <p>&copy; title |
              <a href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "admin\">Romano.Framework</a>
            </p>
      </footer>
    </section>
";
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
        return array (  26 => 6,  19 => 1,);
    }
}

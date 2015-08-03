<?php

/* footer.html */
class __TwigTemplate_dc3742c948304c85a111d4f5e3a8309caa11acae3786f5fceb3509843999de0e extends Twig_Template
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
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site"), "html", null, true);
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
        return array (  26 => 6,  19 => 1,  31 => 4,  28 => 3,);
    }
}

<?php

/* footer.html */
class __TwigTemplate_486fea7d4043f9ef002858178a82fa546f77072aa9b6f226b4c2ed61237ff70d extends Twig_Template
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
        return array (  26 => 6,  19 => 1,  102 => 37,  99 => 36,  95 => 30,  92 => 29,  88 => 9,  85 => 8,  79 => 38,  77 => 36,  72 => 33,  69 => 32,  66 => 31,  64 => 29,  61 => 28,  56 => 24,  54 => 23,  48 => 19,  46 => 18,  36 => 10,  34 => 8,  27 => 4,  22 => 1,  73 => 24,  63 => 20,  59 => 19,  55 => 18,  51 => 17,  47 => 15,  43 => 14,  31 => 4,  28 => 3,);
    }
}

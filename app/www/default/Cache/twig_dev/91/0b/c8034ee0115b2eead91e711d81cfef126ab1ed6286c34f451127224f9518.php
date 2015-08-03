<?php

/* messages.html */
class __TwigTemplate_910bc8034ee0115b2eead91e711d81cfef126ab1ed6286c34f451127224f9518 extends Twig_Template
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
        if ((isset($context["errors"]) ? $context["errors"] : null)) {
            // line 2
            echo "<div class=\"alert alert-danger\">
";
            // line 3
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["errors"]) ? $context["errors"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 4
                echo "    <p>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</p>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 6
            echo "</div>
";
        }
        // line 8
        echo "
";
        // line 9
        if ((isset($context["error"]) ? $context["error"] : null)) {
            // line 10
            echo "<div class=\"alert alert-danger\">
    <p>";
            // line 11
            echo twig_escape_filter($this->env, (isset($context["error"]) ? $context["error"] : null), "html", null, true);
            echo "</p>
</div>
";
        }
        // line 14
        echo "
";
        // line 15
        if ((isset($context["notice"]) ? $context["notice"] : null)) {
            // line 16
            echo "<div class=\"alert alert-success\">
    <p>";
            // line 17
            echo twig_escape_filter($this->env, (isset($context["notice"]) ? $context["notice"] : null), "html", null, true);
            echo "</p>
</div>
";
        }
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
        return array (  63 => 17,  60 => 16,  58 => 15,  55 => 14,  49 => 11,  46 => 10,  44 => 9,  41 => 8,  37 => 6,  28 => 4,  24 => 3,  21 => 2,  19 => 1,);
    }
}

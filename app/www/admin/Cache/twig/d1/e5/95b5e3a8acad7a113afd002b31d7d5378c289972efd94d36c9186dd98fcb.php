<?php

/* blog/index.twig */
class __TwigTemplate_d1e595b5e3a8acad7a113afd002b31d7d5378c289972efd94d36c9186dd98fcb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base.twig");

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

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<section class=\"section\">
    <table>
        <thead>
          <tr>
            <th>id #</th>
            <th>title</th>
            <th>date</th>
            <th>public</th>
          </tr>
        </thead>
        ";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["posts"]) ? $context["posts"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 15
            echo "          <tbody>
            <tr>
              <td>";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "id"), "html", null, true);
            echo "</td>
              <td>";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "title"), "html", null, true);
            echo "</td>
              <td>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "date"), "html", null, true);
            echo "</td>
              <td>";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "public"), "html", null, true);
            echo "</td>
            </tr>
          </tbody>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "    </table>
</section>
";
    }

    public function getTemplateName()
    {
        return "blog/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 24,  63 => 20,  59 => 19,  55 => 18,  51 => 17,  47 => 15,  43 => 14,  31 => 4,  28 => 3,);
    }
}

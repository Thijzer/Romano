<?php

/* collection/index.twig */
class __TwigTemplate_f4c4a1cc282491f7553d88976a49b7062f6d7d29ab02f4a5c6e386e3f3f818e2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("base.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

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

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "    <div class=\"container\">
    \t<ul>
\t\t<div class=\"row\">
    \t";
        // line 6
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["collection"]) ? $context["collection"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 7
            echo "    \t";
            if ($this->getAttribute($context["item"], "url", array())) {
                // line 8
                echo "  \t\t\t<li><a href=\"";
                echo twig_escape_filter($this->env, (isset($context["site"]) ? $context["site"] : null), "html", null, true);
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "url", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
                echo "</a></li>
  \t\t";
            }
            // line 10
            echo "  \t\t";
            if ($this->getAttribute($context["item"], "title_id", array())) {
                // line 11
                echo "  \t\t\t<div class=\"col-lg-4 col-md-3 col-xs-6 thumb\">
                <a class=\"thumbnail\" href=\"";
                // line 12
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
                echo "movie/";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title_id", array()), "html", null, true);
                echo "\">
                    <img class=\"img-responsive\" src=\"/";
                // line 13
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "pic_path", array()), "html", null, true);
                echo "\">
                    <p>";
                // line 14
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
                echo " (";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "release_date", array()), "html", null, true);
                echo ")</p>
                </a>
        </div>
      ";
            }
            // line 18
            echo "    \t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "    \t</div>
    \t</ul>
    </div>
";
    }

    public function getTemplateName()
    {
        return "collection/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 19,  85 => 18,  76 => 14,  72 => 13,  66 => 12,  63 => 11,  60 => 10,  51 => 8,  48 => 7,  44 => 6,  39 => 3,  36 => 2,  11 => 1,);
    }
}

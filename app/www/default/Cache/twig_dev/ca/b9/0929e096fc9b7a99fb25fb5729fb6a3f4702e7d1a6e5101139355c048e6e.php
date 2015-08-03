<?php

/* collection/details.twig */
class __TwigTemplate_cab90929e096fc9b7a99fb25fb5729fb6a3f4702e7d1a6e5101139355c048e6e extends Twig_Template
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

\t\t\t<div class=\"col-lg-4 col-md-3 col-xs-6 thumb\">
\t\t\t\t<img class=\"img-responsive\" src=\"/";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["movie"]) ? $context["movie"] : null), "pic_path", array()), "html", null, true);
        echo "\">
\t\t\t</div>
\t\t\t<h3>";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["movie"]) ? $context["movie"] : null), "title", array()), "html", null, true);
        echo "</h3>
\t\t\t<div class=\"col-lg-4 col-md-3 col-xs-6\">
\t\t\t<ul>
\t\t\t\t<li>category : ";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["movie"]) ? $context["movie"] : null), "category", array()), "html", null, true);
        echo "</li>
\t\t\t\t<li>release date : ";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["movie"]) ? $context["movie"] : null), "release_date", array()), "html", null, true);
        echo "</li>
\t\t\t\t<li>produced : ";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["movie"]) ? $context["movie"] : null), "owner", array()), "html", null, true);
        echo "</li>
\t\t\t\t<li>owns it : ";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "own", array()), "html", null, true);
        echo "</li>
\t\t\t</ul>
\t\t\t</div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "collection/details.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 14,  63 => 13,  59 => 12,  55 => 11,  49 => 8,  44 => 6,  39 => 3,  36 => 2,  11 => 1,);
    }
}

<?php

/* blog/article.twig */
class __TwigTemplate_03bef5eea74d8a72c7535cca553d6af950464fbc2a0731eff3595650f36f33c5 extends Twig_Template
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
        echo "<div class=\"container\">
  <div class=\"row\">
    <div class=\"col-sm-8\">
      <div class=\"well\">
        <header class=\"page-header\">
          <h1>";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "title", array()), "html", null, true);
        echo "</h1>
          <p>by ";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "user", array()), "html", null, true);
        echo " published on ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "date", array()), "html", null, true);
        echo "</p>
        </header>
        <p>";
        // line 11
        echo $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "body", array());
        echo "</p>
      </div>
      <hr>
        <label class=\"btn btn-danger\" data-toggle=\"collapse\" data-target=\"#demo\">count comments</label>
        <div id=\"demo\" class=\"collapse in\">
          <form action='' method='post'>
            <label for='user'>your comment</label>
            <p>
              <textarea name='body' rows='5' cols='50' maxlength=\"128\" required></textarea>
            </p>
            <label for='user'>username</label>
            <p>
              <input type='text' name='user' id='user' required/>
              <input type='submit' name='post' value='add Comment'/>
            </p>
          </form>

          <div>
            ";
        // line 29
        if ($this->getAttribute((isset($context["comment"]) ? $context["comment"] : null), "title_id", array())) {
            // line 30
            echo "            <div id=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["comment"]) ? $context["comment"] : null), "title_id", array()), "html", null, true);
            echo "\"><h5>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["comment"]) ? $context["comment"] : null), "title_user", array()), "html", null, true);
            echo "</h5>
              <p>";
            // line 31
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["comment"]) ? $context["comment"] : null), "title_body", array()), "html", null, true);
            echo "</p>
                <p>posted on : ";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["comment"]) ? $context["comment"] : null), "date", array()), "html", null, true);
            echo "</p>
            </div>
            <hr class=\"dotted\">
            ";
        }
        // line 36
        echo "          </div>
        </div>
    </div>
  </div>
</div>

";
    }

    public function getTemplateName()
    {
        return "blog/article.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 36,  91 => 32,  87 => 31,  80 => 30,  78 => 29,  57 => 11,  50 => 9,  46 => 8,  39 => 3,  36 => 2,  11 => 1,);
    }
}

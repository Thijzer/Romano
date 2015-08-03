<?php

/* users/register.twig */
class __TwigTemplate_98cc8ab048a5811b16a398628344af0aae8a6f39193a3809e16aa5e08cb62c70 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 3
        try {
            $this->parent = $this->env->loadTemplate("base-simple.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(3);

            throw $e;
        }

        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'css' => array($this, 'block_css'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base-simple.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"container\">
  <form class=\"form-signin well\" action='' method='post'>
    <h2 class=\"form-signin-heading\">Please Register</h2>

    <!-- <div id=\"form-group\" ";
        // line 8
        echo ((($this->getAttribute((isset($context["username"]) ? $context["username"] : null), "has", array()) - (isset($context["error"]) ? $context["error"] : null))) ? ("class=\"has-error\"") : (""));
        echo ">
        <label class=\"control-label has-feedback\" for=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["username"]) ? $context["username"] : null), "input", array()), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["username"]) ? $context["username"] : null), "input", array()), "html", null, true);
        echo "</label>
        <input class=\"form-control\" id=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["username"]) ? $context["username"] : null), "input", array()), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["username"]) ? $context["username"] : null), "input", array()), "html", null, true);
        echo "\" placeholder=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["username"]) ? $context["username"] : null), "input", array()), "html", null, true);
        echo "\" value=\"\" type=\"text\">
    </div> -->
    ";
        // line 12
        echo $this->getAttribute((isset($context["form"]) ? $context["form"] : null), "username", array());
        echo "
    <br>
    ";
        // line 14
        echo $this->getAttribute((isset($context["form"]) ? $context["form"] : null), "email", array());
        echo "
    <br>
    ";
        // line 16
        echo $this->getAttribute((isset($context["form"]) ? $context["form"] : null), "email2", array());
        echo "
    <br>
    ";
        // line 18
        echo $this->getAttribute((isset($context["form"]) ? $context["form"] : null), "password", array());
        echo "
    ";
        // line 19
        echo $this->getAttribute((isset($context["form"]) ? $context["form"] : null), "button", array());
        echo "
    <input type='button' class=\"btn btn-lg btn-primary btn-block\" name='cancel' value='Cancel' onclick='location.href=\\\"index\\\";' />

  </form>
</div> <!-- /container -->
";
    }

    // line 25
    public function block_css($context, array $blocks = array())
    {
        // line 26
        echo "<link href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "css/login.css\" rel=\"stylesheet\" type=\"text/css\">
";
    }

    public function getTemplateName()
    {
        return "users/register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 26,  93 => 25,  83 => 19,  79 => 18,  74 => 16,  69 => 14,  64 => 12,  55 => 10,  49 => 9,  45 => 8,  39 => 4,  11 => 3,);
    }
}

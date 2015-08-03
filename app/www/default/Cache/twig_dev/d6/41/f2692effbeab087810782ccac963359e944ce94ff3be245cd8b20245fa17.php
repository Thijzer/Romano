<?php

/* users/login.twig */
class __TwigTemplate_d641f2692effbeab087810782ccac963359e944ce94ff3be245cd8b20245fa17 extends Twig_Template
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
            'css' => array($this, 'block_css'),
            'content' => array($this, 'block_content'),
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

    public function block_css($context, array $blocks = array())
    {
        // line 4
        echo "<link href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "css/login.css\" rel=\"stylesheet\" type=\"text/css\">
";
    }

    // line 6
    public function block_content($context, array $blocks = array())
    {
        // line 7
        echo "<div class=\"container\">
  <form class=\"form-signin\" action=\"\" method=\"post\">
    <h2 class=\"form-signin-heading\">Please sign in</h2>
    <input type=\"hidden\" name=\"token\" value=\"\">
    <input type=\"text\" class=\"form-control\" placeholder=\"Username\" pattern=\"[a-zA-Z0-9]{6,20}\" value=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["input"]) ? $context["input"] : null), "username", array()), "html", null, true);
        echo "\" title=\"6 to 20 characters minimum\" name=\"username\" autofocus r_equired>
    <input type=\"password\" class=\"form-control\" placeholder=\"Password\" pattern=\"[a-zA-Z0-9]{6,20}\" title=\"6 to 20 characters minimum\" name=\"password\">
    <label class=\"checkbox\">
      <input type=\"checkbox\" value=\"remember-me\"> Remember me
      <a href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "lost\">password lost?</a>
    </label>
    <button class=\"btn btn-lg btn-primary btn-block\" name=\"login\" type=\"submit\">Login</button>
  </form>
</div>

";
        // line 21
        echo twig_escape_filter($this->env, (isset($context["errors"]) ? $context["errors"] : null), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "users/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 21,  62 => 15,  55 => 11,  49 => 7,  46 => 6,  39 => 4,  11 => 3,);
    }
}

<?php

/* clock/addTime.twig */
class __TwigTemplate_2ddcbbb229a3c52a9778a526cec50175b9e9415204ba902956dc69436eb07315 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base_bs.twig");

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base_bs.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "
<a href=\"addTime\">add a timer</a>
<a href=\"addProject\">add a project</a>

<div class=\"container\">
  <form class=\"form-signin\" action=\"\" method=\"post\">
    <h2 class=\"form-signin-heading\">Add a Timer</h2>

    <div class=\"nf-field\">
      <label for=\"Project\">Projects</label>
      <select class=\"js-tasks chzn-done\" name=\"tasks\">
        <optgroup label=\"Billable\">
            <option value=\"2797158\">ascento</option>
        </optgroup>
      </select>
    </div>

    <div class=\"nf-field\">
      <label for=\"tasks\">Tasks</label>
      <select class=\"js-tasks chzn-done\" name=\"tasks\">
        <optgroup label=\"Billable\">
            <option value=\"2797158\">ascento</option>
        </optgroup>
      </select>
    </div>

    <input type=\"text\" class=\"form-control\" placeholder=\"00:00\">
    <input type=\"textarea\" class=\"form-control\" placeholder=\"notes...\">
    <button class=\"btn btn-small btn-primary js-confirm-start-timer\" href=\"#\">Start Timer</button>
    <button class=\"btn btn-small btn-cancel js-cancel-start-timer\" href=\"#\">Cancel</button>
  </form>
</div>



";
        // line 38
        echo twig_escape_filter($this->env, (isset($context["errors"]) ? $context["errors"] : null), "html", null, true);
        echo "


";
    }

    public function getTemplateName()
    {
        return "clock/addTime.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 38,  31 => 3,  28 => 2,);
    }
}

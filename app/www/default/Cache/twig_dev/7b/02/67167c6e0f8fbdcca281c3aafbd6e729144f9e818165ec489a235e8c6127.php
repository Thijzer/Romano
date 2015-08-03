<?php

/* home/contact.twig */
class __TwigTemplate_7b0267167c6e0f8fbdcca281c3aafbd6e729144f9e818165ec489a235e8c6127 extends Twig_Template
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

      <h3>Find me on the web</h3>
      <ul>
        <li><a href=\"https://plus.google.com/108354583103011120629/posts\">Google+</a></li>
        <li><a href=\"https://www.facebook.com/Thijzer\">Facebook</a></li>
        <li><a href=\"http://www.linkedin.com/in/thijsdp\">Linkedin</a></li>
        <li><a href=\"https://twitter.com/Thijzer\">Twitter</a></li>
      </ul>
      <p>Or send me a message</p>
      <form name=\"getintouch\" method=\"post\" action=\"\">

        <label>name *</label>
        <p>
          <input name=\"name\" type=\"text\" alt=\"Your Name\" value=\"\" tabindex=\"6\" required>
        </p>

        <label>email *</label>
        <p>
          <input name=\"email\" type=\"text\" alt=\"Your Email\" value=\"\" tabindex=\"7\" required>
        </p>
        <label>message *</label>
        <p>
          <textarea name=\"Fmessage\" cols=\"25\" rows=\"3\" tabindex=\"8\" required></textarea>
        </p>
        <p>
          <input name=\"emails\" class=\"emails\"></input>
        </p>
        <p>
          <small>*All Fields Are Required</small>
        </p>

        <button class=\"btn btn-primary ng-pristine ng-valid active\" >Submit</button>
      </form>

    </div>
";
    }

    public function getTemplateName()
    {
        return "home/contact.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 3,  36 => 2,  11 => 1,);
    }
}

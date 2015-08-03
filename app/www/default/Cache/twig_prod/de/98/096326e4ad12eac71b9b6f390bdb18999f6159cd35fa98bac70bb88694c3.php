<?php

/* home/index.twig */
class __TwigTemplate_de98096326e4ad12eac71b9b6f390bdb18999f6159cd35fa98bac70bb88694c3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 3
        try {
            $this->parent = $this->env->loadTemplate("base.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(3);

            throw $e;
        }

        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'sidebar' => array($this, 'block_sidebar'),
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

    public function block_content($context, array $blocks = array())
    {
        // line 4
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["post"]) ? $context["post"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 5
            echo "  <div class=\"well\">
    <h3>
      <a href=\"";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
            echo "blog/article/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "id", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uri", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
            echo "</a>
    </h3>
    <span>";
            // line 9
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('lng')->getCallable(), array("lbl.poston")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "date", array()), "html", null, true);
            echo " by <a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
            echo "blog/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "user", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "user", array()), "html", null, true);
            echo "</a>
    with ";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "total_comments", array()), "html", null, true);
            echo " comments
    </span>
    <HR>
    <p>";
            // line 13
            echo $this->getAttribute($context["item"], "preview", array());
            echo "<a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
            echo "blog/article/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "id", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uri", array()), "html", null, true);
            echo ".html\"> ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('lng')->getCallable(), array("lbl.more.post")), "html", null, true);
            echo "...</a></p>
  </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "<nav>
  <ul class=\"pagination\">

    <li ";
        // line 19
        if (($this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "prev", array()) < 1)) {
            echo "class=\"disabled\">";
        } else {
            echo ">
      <a href=\"";
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "url", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "prev", array()), "html", null, true);
            echo "\" aria-label=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "prev_lbl", array()), "html", null, true);
            echo "\">";
        }
        // line 21
        echo "        <span aria-hidden=\"true\">&laquo;</span>
      </a>
    </li>

    ";
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(range(1, $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "num_pages", array())));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 26
            echo "        ";
            if (($context["page"] == 1)) {
                // line 27
                echo "            <li><a href=\"/\">";
                echo twig_escape_filter($this->env, $context["page"], "html", null, true);
                echo "</a></li>
        ";
            } elseif ((            // line 28
$context["page"] == $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "requested_page", array()))) {
                // line 29
                echo "            <li class=\"active\"><a href=\"";
                echo twig_escape_filter($this->env, $context["page"], "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $context["page"], "html", null, true);
                echo "</a></li>
        ";
            } else {
                // line 31
                echo "            <li><a href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "url", array()), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $context["page"], "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $context["page"], "html", null, true);
                echo "</a></li>
        ";
            }
            // line 33
            echo "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "
    <li ";
        // line 35
        if (($this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "next", array()) > $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "num_pages", array()))) {
            echo "class=\"disabled\">";
        } else {
            echo ">
      <a href=\"";
            // line 36
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "url", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "next", array()), "html", null, true);
            echo "\" aria-label=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["pages"]) ? $context["pages"] : null), "next_lbl", array()), "html", null, true);
            echo "\">";
        }
        // line 37
        echo "        <span aria-hidden=\"true\">&raquo;</span>
      </a>
    </li>

  </ul>
</nav>
";
    }

    // line 44
    public function block_sidebar($context, array $blocks = array())
    {
        // line 45
        echo "<div>
  <h3 class=\"widget-title\">";
        // line 46
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, call_user_func_array($this->env->getFilter('lng')->getCallable(), array("lbl.recent.post"))), "html", null, true);
        echo "</h3>

  <ul>
    ";
        // line 49
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["titles"]) ? $context["titles"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 50
            echo "        <li><a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
            echo "blog/article/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "id", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uri", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
            echo "</a></li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 52
        echo "  </ul>

</div>
<div>
  <h3 class=\"widget-title\">";
        // line 56
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, call_user_func_array($this->env->getFilter('lng')->getCallable(), array("lbl.categories"))), "html", null, true);
        echo "</h3>
  <ul>
    <li>";
        // line 58
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, call_user_func_array($this->env->getFilter('lng')->getCallable(), array("lbl.await.update"))), "html", null, true);
        echo "</li>
  </ul>
</div>
";
        // line 61
        if ( !$this->getAttribute((isset($context["session"]) ? $context["session"] : null), "user", array(), "any", true, true)) {
            // line 62
            echo "<div>
  <h3 class=\"widget-title\">";
            // line 63
            echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, call_user_func_array($this->env->getFilter('lng')->getCallable(), array("nav.login"))), "html", null, true);
            echo "</h3>
  <ul>
    <li><a href=\"";
            // line 65
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
            echo "login\">";
            echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, call_user_func_array($this->env->getFilter('lng')->getCallable(), array("nav.login"))), "html", null, true);
            echo "</a></li>
    <li><a href=\"";
            // line 66
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
            echo "register\">";
            echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, call_user_func_array($this->env->getFilter('lng')->getCallable(), array("nav.register"))), "html", null, true);
            echo "</a></li>
  </ul>
</div>
";
        }
    }

    public function getTemplateName()
    {
        return "home/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  247 => 66,  241 => 65,  236 => 63,  233 => 62,  231 => 61,  225 => 58,  220 => 56,  214 => 52,  199 => 50,  195 => 49,  189 => 46,  186 => 45,  183 => 44,  173 => 37,  165 => 36,  159 => 35,  156 => 34,  150 => 33,  140 => 31,  132 => 29,  130 => 28,  125 => 27,  122 => 26,  118 => 25,  112 => 21,  104 => 20,  98 => 19,  93 => 16,  76 => 13,  70 => 10,  58 => 9,  47 => 7,  43 => 5,  39 => 4,  11 => 3,);
    }
}

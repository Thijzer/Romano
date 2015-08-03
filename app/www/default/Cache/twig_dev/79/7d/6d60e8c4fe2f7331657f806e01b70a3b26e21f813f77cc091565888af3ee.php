<?php

/* home/about.twig */
class __TwigTemplate_797d6d60e8c4fe2f7331657f806e01b70a3b26e21f813f77cc091565888af3ee extends Twig_Template
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
        echo "  <div class=\"container\">
<!-- Docs nav ================================================== -->
      <div class=\"row\">
        <div class=\"col-md-2\">
          <h4>About</h4>
          <ul class=\"nav\">
            <li><a href=\"#me\">me</a></li>
            <li><a href=\"#blog\">the.blog</a></li>
            <li><a href=\"#framework\">the.framework</a></li>
            <li><a href=\"#stats\">statistics</a></li>
            <li><a href=\"#projects\">Projects</a></li>
          </ul>
          <BR>
          <img src=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "/img/thijsdp.jpg\" alt=\"Thijs De Paepe\" class=\"img-thumbnail\">
        </div>

<!-- main section ================================================== -->
        <div class=\"col-md-10\">
          <div class=\"well\">

        <section id=\"blog\">
          <div class=\"page-header\">
            <h3>thijzer</h3>
             <p class=\"lead\">Who am I</p>

             <p>
              I am passionate about many things but mostly about the web, software-development specificly PHP, UX and also gadgets.
              I worked for 7 years in a retail store @ Media-Markt, leveled up till department/retail manager, 
              many of my managment, sales and communictation/relationship skills I learned in Media-Markt.

              Currently I develop <a href=\"http://frankkie.nl/baxy\">the Baxy launcher</a>, an OUYA replacment launcher together with Frank and Michel.
              I also develop on other projects, read more about it in <a href=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["meta"]) ? $context["meta"] : null), "site", array()), "html", null, true);
        echo "about#projects\">the project</a> section. 
              All these efforts are done to reposition myself on the market.
             </p>
          </div>
        </section>

        <section id=\"blog\">
          <div class=\"page-header\">
            <h3>the.blog</h3>
             <p class=\"lead\">technology.UX.PHP.gaming.linux.unix.js.photos</p>
             <p>
             \tAspect lots of blogposts about these categories as they represent the things I love the most.
             \tTo me this blog will be a personal agenda and an open notebook to my findings.
             \tI hope you will enjoy it as much as I will enjoy making it.
             </p>
          </div>
        </section>

        <section id=\"framework\">
          <div class=\"page-header\">
            <h3>the.framework</h3>
             <p class=\"lead\">let's build software together</p>
             <p>the source code is available on Github for however wants it. The framework has no limitations, you can use it, copy it, reproduce it, fork it, do whatever you like with it. 
             \tIt was build from ground up the be free for all who wants.
             \tIt's main featuree are fast, simple, modular and easy to learn setup code. Specificly for smaller projects.
             \tThe framework has been developed and tested on a 35 dollar Raspberry Pi. 
             \tIt makes a big difference to static and dynamic pages unlike a lot of other CMS software out there. Be sure to check out the stats for a comparison.
             </p>
          </div>
        </section>

        <section id=\"stats\">
          <div class=\"page-header\">
            <h3>statistics</h3>
             <p class=\"lead\">The Raspberry Pi stats</p>
             <p>One of the advantages of developing on a super lowend platform is you constantly mind the speed and resources your using.
              As an example, here is a Siege test for 60 seconds on different pages. <BR>I used this Siege command : \"siege -b -t60S local.hostname\" 
              All tests are done on the Raspberry Pi with the latest debian version of NGINX/PHP5-fpm+APC/Mysql</p>
              <table class=\"table table-striped\">
                <thead>
                  <tr>
                    <th>page</th>
                    <th>type</th>
                    <th>framework</th>
                    <th># of Transactions</th>
                    <th>response time/page</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>index</td>
                      <td>dynamic</td>
                      <td>wordpress 3.6</td>
                      <td>79</td>
                      <td>10 secs</td>
                    </tr>
                    <tr>
                      <td>index</td>
                      <td>dynamic</td>
                      <td>Romano</td>
                      <td>3410</td>
                      <td>0.26 secs</td>
                    </tr>
                    <tr>
                      <td>about</td>
                      <td>static</td>
                      <td>Romano</td>
                      <td>5158</td>
                      <td>0.17 secs</td>
                    </tr>
                  </tbody>
              </table>
              <p>
                Pretty scary numbers huh, I'm sure with better caching and plugins and different config files wordpress 3.6 would get much better results
                but that's not really the point, since the average wordpress user doesn't know about these things.
                Also Romano isn't that feature rich atm, it doesn't have tag support, good skin support, a decent commenting system and a category filter.
              </p>


          </div>
        </section>

        <section id=\"projects\">
          <div class=\"page-header\">
            <h3>Projects</h3>
             <p class=\"lead\">The projects I am working on</p>
             <p>At the moment 3 projects are in development all based on the same framework. These projects are very different but all share the same course code.
             \tIf you like to take a look.
             </p>
             <ul>
             \t<li><a href=\"http://frankkie.nl/baxy\">Baxy Launcher</a></li>
             \t<li><a href=\"http://thijzer.dyndns.org:8081\">The Asinmo real estate</a></li>
             \t<li><a href=\"http://thijzer.com\">This Blog</a></li>
             </ul>
          </div>
        </section>

        </div> <!-- end of well -->
      </div> <!-- end of row -->
    </div> <!-- end of span9 -->
  </div> <!-- end of container -->
";
    }

    public function getTemplateName()
    {
        return "home/about.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 34,  54 => 16,  39 => 3,  36 => 2,  11 => 1,);
    }
}

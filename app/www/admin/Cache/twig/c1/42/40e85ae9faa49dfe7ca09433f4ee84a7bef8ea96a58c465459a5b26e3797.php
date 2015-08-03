<?php

/* overview/test2.twig */
class __TwigTemplate_c14240e85ae9faa49dfe7ca09433f4ee84a7bef8ea96a58c465459a5b26e3797 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
     <meta name=\"viewport\" content=\"width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes\">
    <title>Dashboard</title>
    <script src=\"/components/platform/platform.js\" register></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
    <link rel=\"stylesheet\" href=\"/style.css\" shim-shadowdom>
    <link rel=\"import\" href=\"/components/core-component-page/core-component-page.html\">
    <link rel=\"import\" href=\"/layout.html\">
    <link rel=\"import\" href=\"/dialog.html\">
    <link rel=\"import\" href=\"/element-query.html\">


</head>
<body unresolved>
    <bs-drawer>
        <div drawer parallax>
            <h2>User Interface</h2>
            <ul>
                <li>
                    <a href=\"../dialog/index.html\">
                        <span>
                            dialog
                            <b>akyral-dialog</b>
                        </span>
                    </a>
                </li>
                <li>
                    <a href=\"../layout/index.html\">
                        <span>
                            layout
                            <b>akyral-layout</b>
                        </span>
                    </a>

                </li>
                <li class=\"drawer__dev\">
                    <span>
                        toaster
                        <b>[ in development ]</b>
                    </span>
                </li>
            </ul>
            <h2>Utility</h2>
            <ul>
                    <li>
                        <a href=\"../element-query/index.html\">
                            <span>
                                element-query
                                <b>akyral-element-query</b>
                            </span>
                        </a>
                    </li>
            </ul>
        </div>

        <div main demo=\"layout\" >
            <header class=\"page__header page__header--compressed\">
                <button name=\"menu\" class=\"button__preview icon icon-menu\">menu</button>
                <h1>

                        <a href=\"../index.html\">Akyral</a>

                    <span>alpha</span>
                </h1>
                <h2>Responsive, highly customizable web components built on Polymer.</h2>
            </header>

            <h2>[ Drawer ]  <span>Configuration</span></h2>

            <section class=\"section\">
                <h3>Type</h3>
                <p>
                    Type will define the visual effect given to the drawer on exiting and entering.
                    This value only applies to viewports smaller than 944 pixels
                    <span class=\"resize\">, so go ahead and resize down your browser</span>.
                </p>
                <div class=\"demo__type\">
                    <core-selector data-attribute=\"type\" selected=\"1\" selectedClass=\"button__config--selected\">
                        <button class=\"button__config\" data-type=\"pan\">pan</button>
                        <button class=\"button__config\" data-type=\"parallax\">parallax</button>
                        <button class=\"button__config\" data-type=\"reveal\">reveal</button>
                        <button class=\"button__config\" data-type=\"slide\">slide</button>
                    </core-selector>
                </div>
            </section>

            <section class=\"section\">
                <h3>Position</h3>
                <p>
                    Position will define on what side the sidebar is positioned in the viewport.
                </p>
                <button class=\"button__preview icon-lab\">toggle sidebar</button>
                <div class=\"demo__position\">
                    <core-selector data-attribute=\"position\" selected=\"0\" selectedClass=\"button__config--selected\">
                        <button class=\"button__config\" data-position=\"left\">left</button>
                        <button class=\"button__config\" data-position=\"right\">right</button>
                    </core-selector>
                </div>
            </section>

            <a name=\"review\"></a>
            <section class=\"section__review\">
                <h3>Config Review</h3>
                <demo-configuration type=\"parallax\" position=\"left\"></demo-configuration>
                <button class=\"button__preview icon-lab\">toggle sidebar</button>
            </section>

            <a name=\"install\"></a>
            <section class=\"section__install\">
                <h3>Install</h3>
                <p>
                    If you haven't used Polymer before you can checkout out the
                    <a href=\"http://www.polymer-project.org/docs/start/getting-the-code.html\">Getting the Code</a>
                    and <a href=\"http://www.polymer-project.org/docs/start/usingelements.html\">Using the Elements</a>
                    guides for a quick introduction to Polymer.
                </p>
                <p>
                    Once your all setup with Polymer, you can install it directly into your project with <a href=\"http://bower.io/\">Bower</a>.
                </p>
                <code>
                    \$ bower install akyral-layout --save
                </code>
            </section>

            <a name=\"gotchas\"></a>
            <section class=\"section__gotchas\">
                <h3 class=\"icon-chat\">Helpful Gotchas</h3>
                <p>
                    <b>akyral-layout</b> should be placed immediately inside the body tag, this will allow
                    to fully fit the viewport.
                </p>
            </section>


            <polymer-element name=\"demo-configuration\" attributes=\"type position\">
                <template>
                    <style>
                        :host {
                            display: block;
                        }
                    </style>
                    This page's layout is currently configured with <code>";
        // line 145
        echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : null), "html", null, true);
        echo "</code> positioned
                    drawer that is positioned on the <code>";
        // line 146
        echo twig_escape_filter($this->env, (isset($context["position"]) ? $context["position"] : null), "html", null, true);
        echo "</code>

                </template>
                <script>
                    Polymer('demo-configuration', {
                        position: null,
                        type: null
                    });
                </script>
            </polymer-element>


            <script charset=\"utf-8\">
                (function(){
                    var sidebars = {
                            position: ['left', 'right'],
                            type: ['pan', 'parallax', 'reveal', 'slide']
                        },
                        ui = document.querySelector('bs-drawer'),
                        previewBtns = ui.querySelectorAll('.button__preview'),
                        demoConfig = document.querySelector('demo-configuration');

                    ui.querySelector('core-selector[data-attribute=\"position\"]')
                        .addEventListener('core-activate', setProperty('position'));

                    ui.querySelector('core-selector[data-attribute=\"type\"]')
                        .addEventListener('core-activate', setProperty('type'));

                    [].forEach.call(previewBtns, function(button){
                        button.addEventListener('click', function(){
                            ui.toggleDrawer();
                        });
                    });

                    function setProperty(prop){
                        return function(e){
                            var drawer = ui.shadowRoot.querySelector('#drawer'),
                                currentProp = this.querySelectorAll('button')[this.selected].getAttribute('data-'+prop);

                            drawer.classList.add('adjusting');
                            console.log(drawer)

                            sidebars[prop].forEach(function(p){
                                drawer.removeAttribute(p);
                            })

                            drawer.setAttribute(currentProp, '');
                            demoConfig.setAttribute(prop, currentProp);

                            ga('send', 'event', 'bs-drawer', 'set '+prop, currentProp);

                            // prevent FOC
                            setTimeout(function(){
                                drawer.classList.remove('adjusting');
                            }, 300);
                        }
                    }
                }());
            </script>

            <footer class=\"page__footer\">
                maintained and built by
            </footer>

        </div>
    </bs-drawer>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "overview/test2.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  169 => 146,  165 => 145,  19 => 1,);
    }
}
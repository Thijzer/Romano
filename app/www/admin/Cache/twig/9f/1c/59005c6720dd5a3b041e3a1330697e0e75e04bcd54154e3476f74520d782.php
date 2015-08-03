<?php

/* overview/test3.twig */
class __TwigTemplate_9f1c59005c6720dd5a3b041e3a1330697e0e75e04bcd54154e3476f74520d782 extends Twig_Template
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
    <!-- <link rel=\"import\" href=\"/element-query.html\"> -->

</head>
<body unresolved>
    <bs-drawer>
        <div drawer parallax>
            <h2>Module</h2>
            <ul>
                <li>
                    <a href=\"../blog/index\">
                        <span>
                            blog
                            <b>blog</b>
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
            <h2>Settings</h2>
            <ul>
                <li>
                    <a href=\"../settings/index\">
                        <span>
                            index
                            <b>index</b>
                        </span>
                    </a>
                </li>
            </ul>
            <h2>Dashboard</h2>
        </div>

        <div main demo=\"layout\">

            <header class=\"page__header page__header--compressed\">
                <h1>Romano</h1>
                <button data-attribute=\"type\" selected=\"2\" name=\"menu\" class=\"button__preview icon icon-menu\">menu</button>
                <core-selector data-attribute=\"position\" selected=\"0\"></core-selector>
            </header>

            <h2>Page Name</h2>

            <section class=\"section\">
                <h3>Type</h3>
                <p>paragraph</p>
            </section>

            <footer class=\"page__footer\">
                maintained and built by
            </footer>
        </div>
    </bs-drawer>
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

        ui.querySelector('button[data-attribute=\"type\"]')
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
            }
        }
    }());
</script>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "overview/test3.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}

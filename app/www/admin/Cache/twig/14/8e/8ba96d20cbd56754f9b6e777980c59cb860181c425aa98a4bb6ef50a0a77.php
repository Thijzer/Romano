<?php

/* overview/test.twig */
class __TwigTemplate_148e8ba96d20cbd56754f9b6e777980c59cb860181c425aa98a4bb6ef50a0a77 extends Twig_Template
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
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Dashboard</title>
    <script src=\"/components/platform/platform.js\" register></script>
    <link rel=\"import\" href=\"/components/font-roboto/roboto.html\">
<link rel=\"import\" href=\"/components/core-icon-button/core-icon-button.html\">
<link rel=\"import\" href=\"/components/core-toolbar/core-toolbar.html\">
<link rel=\"import\" href=\"/components/core-header-panel/core-header-panel.html\">
<link rel=\"import\" href=\"/components/core-scaffold/core-scaffold.html\">
<link rel=\"import\" href=\"/components/core-menu/core-menu.html\">
<link rel=\"import\" href=\"/components/core-item/core-item.html\">
<link rel=\"import\" href=\"/components/core-field/core-field.html\">
<link rel=\"import\" href=\"/components/core-icon/core-icon.html\">
<link rel=\"import\" href=\"/components/core-input/core-input.html\">
<link rel=\"import\" href=\"/components/core-icons/core-icons.html\">
<link rel=\"import\" href=\"/components/core-menu/core-submenu.html\">
<link rel=\"import\" href=\"/components/core-range/core-range.html\">
<link rel=\"import\" href=\"/components/core-tooltip/core-tooltip.html\">
<link rel=\"import\" href=\"/components/core-menu-button/core-menu-button.html\">
<link rel=\"import\" href=\"/components/core-collapse/core-collapse.html\">
<link rel=\"import\" href=\"/components/core-splitter/core-splitter.html\">
<!-- polymer UI stuff -->
<link rel=\"import\" href=\"/components/polymer-ui-menu-button/polymer-ui-menu-button.html\">
<link rel=\"import\" href=\"/components/polymer-ui-menu-item/polymer-ui-menu-item.html\">
<link rel=\"import\" href=\"/components/polymer-ui-toolbar/polymer-ui-toolbar.html\">
<link rel=\"import\" href=\"/components/polymer-flex-layout/polymer-flex-layout.html\">
<link rel=\"import\" href=\"/components/polymer-ui-breadcrumbs/polymer-ui-breadcrumbs.html\">
<!-- <link rel=\"import\" href=\"/components/polymer-ui-weather/polymer-ui-weather.html\">
--> <link rel=\"stylesheet\" href=\"/components/polymer-ui-base-css/base.css\">
<!-- paper elements -->
<link rel=\"import\" href=\"/components/paper-input/paper-input.html\">
<link rel=\"import\" href=\"/components/paper-button/paper-button.html\">
<link rel=\"import\" href=\"/components/paper-ripple/paper-ripple.html\">
<link rel=\"import\" href=\"/components/paper-toggle-button/paper-toggle-button.html\">
<link rel=\"import\" href=\"/components/paper-slider/paper-slider.html\">
<link rel=\"import\" href=\"/components/paper-radio-group/paper-radio-group.html\">
<link rel=\"import\" href=\"/components/paper-progress/paper-progress.html\">
<link rel=\"import\" href=\"/components/paper-fab/paper-fab.html\" >
<link rel=\"import\" href=\"/components/paper-checkbox/paper-checkbox.html\">
<link rel=\"import\" href=\"/components/paper-radio-group/paper-radio-group.html\">
<link rel=\"import\" href=\"/components/paper-dialog/paper-dialog.html\" >
<link rel=\"import\" href=\"/components/paper-dialog/paper-dialog-transition.html\">
<link rel=\"import\" href=\"/components/paper-toast/paper-toast.html\">
<link rel=\"import\" href=\"/components/paper-tabs/paper-tabs.html\">
<link rel=\"import\" href=\"/components/paper-icon-button/paper-icon-button.html\">
<!-- Others -->
<!-- <link rel=\"import\" href=\"/components/canvas-piechart/canvas-piechart.html\">
<link rel=\"import\" href=\"/components/chart-js/chart-js.html\">
<link rel=\"import\" href=\"/components/google-map/google-map.html\"> -->
<link rel=\"import\" href=\"/components/component-load/component-loader.html\">
<style>
/* toolbar custom theme (would work even if toolbar is inside n-levels of Shadow DOM) */
body /deep/ polymer-ui-toolbar #themeTitle {
color:#f3f3f3;
}
body /deep/ polymer-ui-toolbar.my-custom-theme {
background-color: none;
color: black;
}
body /deep/ polymer-ui-icon-button.my-custom-theme {
background-color: #f3f3f3;
}
body /deep/ polymer-ui-icon-button.my-custom-theme:hover {
background-color: white;
}
/* Not working */
body /deep/ polymer-ui-icon-button.my-custom-theme > polymer-ui-icon {
background-position-x: -24px;
}
body /deep/ h1 {
padding-left: 10px;
}
/*body /deep/ #core_card div {
background-color: white
} */
</style>
<polymer-element name=\"admin-theme\">
<template>
<style>
:host {
position: absolute;
width: 100%;
height: 100%;
box-sizing: border-box;
}
#core_header_panel {
width: 100%;
height: 100%;
left: 0px;
top: 0px;
position: absolute;
}
#core_scaffold {
right: 0px;
bottom: 0px;
}
#core_scaffold::shadow core-toolbar {
background-color: #776E64;
}
#core_header_panel1 {
background-color: rgb(255, 255, 255);
}
#core_toolbar {
color: rgb(255, 255, 255);
background-color: #000;
}
#core_menu {
font-size: 16px;
}
#core_card {
width: 100%;
height: 100%;
border-top-left-radius: 2px;
border-top-right-radius: 2px;
border-bottom-right-radius: 2px;
border-bottom-left-radius: 2px;
box-shadow: rgba(0, 0, 0, 0.0980392) 0px 2px 4px, rgba(0, 0, 0, 0.0980392) 0px 0px 3px;
/*position: absolute;
top: 0px;
left: 0px;*/
background-color: rgb(255, 255, 255);
}
#core_field {
background-color: rgb(255, 255, 255);
}
#core_icon {
height: 24px;
width: 24px;
}
#loadArea {
padding:10px;
}
polymer-ui-breadcrumbs {
padding-left: 20px;
}
#breadCrumbsToolBar {
background-color: white;
}
</style>
<core-scaffold id=\"core_scaffold\">
<core-header-panel mode=\"seamed\" id=\"core_header_panel1\" navigation flex>
<core-toolbar id=\"core_toolbar\">
<core-field id=\"core_field\" icon=\"search\" theme=\"core-light-theme\" center horizontal layout>
<core-icon icon=\"search\" id=\"core_icon\"></core-icon>
<core-input placeholder=\"Search\" id=\"core_input\" flex></core-input>
</core-field>
</core-toolbar>
<core-menu valueattr=\"id\" id=\"core_menu\" theme=\"core-light-theme\"
on-core-select=\"";
        // line 152
        echo twig_escape_filter($this->env, (isset($context["setMenuPath"]) ? $context["setMenuPath"] : null), "html", null, true);
        echo "\" >
<core-item href=\"menu/dashboard-elements.html\" label=\"Dashboard\" icon=\"view-module\" id=\"dashboard\" horizontal center layout active>
</core-item>
<core-submenu valueattr=\"id\" label=\"Core Elements\" icon=\"explore\" id=\"core-elements\">
<core-item label=\"Form Elements\" id=\"core-form-elements\" href=\"menu/menu-core-form.html\" horizontal center layout></core-item>
<core-item label=\"UI Elements\" id=\"core-ui-elements\" href=\"menu/menu-core-ui.html\" horizontal center layout></core-item>
<core-item label=\"Icons\" id=\"core-icons\" href=\"menu/menu-core-icon.html\" horizontal center layout></core-item>
</core-submenu>
<core-submenu valueattr=\"id\" label=\"Paper Elements\" icon=\"attachment\" id=\"paper-elements\">
<core-item label=\"Form Elements\" id=\"paper-form-elements\" href=\"menu/menu-paper-form.html\" horizontal center layout></core-item>
<core-item label=\"UI Elements\" id=\"paper-ui-elements\" href=\"menu/menu-paper-ui.html\" horizontal center layout></core-item>
</core-submenu>
<!-- <core-item label=\"Core Elements\" icon=\"view-module\" id=\"core_item\" href=\"menu/menu-core-elements.html\" horizontal center layout active></core-item>
<core-item label=\"Paper Elements\" icon=\"view-module\" id=\"core_item\" href=\"menu/menu-paper-elements.html\" horizontal center layout active></core-item> -->
<core-item label=\"Polymer UI Elements\" icon=\"view-module\" id=\"polymer-ui-elements\" href=\"menu/menu-polymer-ui.html\" horizontal center layout active></core-item>
<core-submenu valueattr=\"id\" label=\"Pages\" icon=\"tab\" id=\"page-all\">
<core-item label=\"Login Page\" id=\"page-login\" href=\"menu/menu-page-login.html\" horizontal center layout></core-item>
<core-item label=\"Signup Page\" id=\"page-signup\" href=\"menu/menu-page-signup.html\" horizontal center layout></core-item>
</core-submenu>
<core-submenu valueattr=\"id\" label=\"Multi-Level Menu\" id=\"multi-main-1\" icon=\"tab\">
<core-item label=\"Menu 1\" id=\"multi-1\" horizontal center layout></core-item>
<core-item label=\"Menu 2\" id=\"multi-2\" horizontal center layout></core-item>
<core-submenu label=\"2nd-Level Menu\" id=\"multi-main-2\">
<core-item label=\"Menu 1\" id=\"multi-2-1\" horizontal center layout></core-item>
<core-item label=\"Menu 2\" id=\"multi-2-2\" horizontal center layout></core-item>
<core-submenu label=\"3rd-Level Menu\" id=\"multi-main-3\">
<core-item label=\"Menu 1\" id=\"multi-3-1\" horizontal center layout></core-item>
<core-item label=\"Menu 2\" id=\"multi-3-2\" horizontal center layout></core-item>
</core-submenu>
</core-submenu>
</core-submenu>
</core-menu>
</core-header-panel>
<div tool flex>
<polymer-ui-toolbar theme=\"my-custom-theme\" >
<div flex id=\"themeTitle\">Polymer Admin Starter Template</div>
<polymer-ui-icon-button icon=\"refresh\"></polymer-ui-icon-button>
<polymer-ui-toolbar responsive >
<polymer-ui-menu-button selected=\"0\" halign=\"right\" icon=\"account\">
<polymer-ui-menu-item icon=\"settings\" label=\"Settings\"></polymer-ui-menu-item>
<polymer-ui-menu-item icon=\"dialog\" label=\"Profile\"></polymer-ui-menu-item>
<polymer-ui-menu-item icon=\"search\" label=\"Search\"></polymer-ui-menu-item>
</polymer-ui-menu-button>
<polymer-ui-icon-button icon=\"dots\"></polymer-ui-icon-button>
</polymer-ui-toolbar>
</polymer-ui-toolbar>
</div>
<core-card id=\"core_card\" layout vertical>
<polymer-ui-toolbar id=\"breadCrumbsToolBar\">
<polymer-ui-breadcrumbs id=\"breadCrumbs\" crumbs=\"";
        // line 201
        echo twig_escape_filter($this->env, (isset($context["crumbs"]) ? $context["crumbs"] : null), "html", null, true);
        echo "\" selected=\"";
        echo twig_escape_filter($this->env, (isset($context["selectedCrumbIndex"]) ? $context["selectedCrumbIndex"] : null), "html", null, true);
        echo "\" selectedCrumb=\"";
        echo twig_escape_filter($this->env, (isset($context["selectedCrumb"]) ? $context["selectedCrumb"] : null), "html", null, true);
        echo "\"></polymer-ui-breadcrumbs>
</polymer-ui-toolbar>
<component-load id=\"loadArea\" path=\"";
        // line 203
        echo twig_escape_filter($this->env, (isset($context["menuPath"]) ? $context["menuPath"] : null), "html", null, true);
        echo "\" data=\"{'attr':'value'}\" if=\"true\" layout vertical flex/>
<core-card>
</core-scaffold>
</template>
<script>
Polymer('admin-theme', {
ready: function() {
//console.log(window.location.hash);
this.crumbs = [
{label: 'Dashboard'},
];
window.addEventListener('popstate', this.popMenu.bind(this));
//see if #page-id is set
if(window.location.hash !== '') {
var menuID = window.location.hash.substr(1);
this.selectMenu(menuID);
} else {
this.\$.core_menu.selected = 'dashboard';
}
},
publish: {
menuPath : \"\"
},
selectMenu : function(menuID) {
coreitem = this.shadowRoot.querySelector('#' + menuID);
console.log(menuID);
//see if the core item has parent menu, then select it.
//TODO: Make it work with multi level menu. Looks like core-menu is broken 
//  it should automatically select all the parent menus based on current core-item.
if(coreitem.parentElement.localName == 'core-submenu') {
this.\$.core_menu.selected = coreitem.parentElement.attributes.id.value;
coreitem.parentElement.selected = menuID;
} else {
this.\$.core_menu.selected = menuID;
}
},
popMenu : function(event) {
//console.log(this.menuPath);
this.selectMenu(event.state.menu);
//this.menuPath = event.state.menu;
},
setMenuPath : function(e, detail, sender) {
if(detail.isSelected && detail.item.attributes.href !== undefined) {
console.log(detail);
this.menuPath = detail.item.attributes.href.value;
if(detail.item.parentElement.localName == 'core-submenu') {
this.crumbs[0].label = detail.item.parentElement.label;
if(this.crumbs.length === 1) {
this.crumbs.push({label: ''});
}
this.crumbs[1].label = detail.item.label;
} else {
this.crumbs[0].label = detail.item.label;
this.crumbs.splice(1, 1);
}
history.pushState({menu: detail.item.attributes.id.value}, document.title, '#' + detail.item.attributes.id.value);
e.preventDefault();
e.stopPropagation();
}
},
});
</script>
</polymer-element>
\t<style>
html { height: 100% }
body {
margin: 0;
height: 100%;
transform: translateZ(0);
-webkit-transform: translateZ(0);
font-size: 14px;
font-family: \"Helvetica Neue\", \"Roboto\", \"Arial\", sans-serif;
-webkit-tap-highlight-color: rgba(0,0,0,0);
}
#loading {
-webkit-align-items: center;
align-items: center;
color: #333;
display: block;
display: -webkit-flex;
display: flex;
font-family: \"Times New Roman\", serif;
font-size: 36px;
font-weight: bold;
height: 100%;
-webkit-justify-content: center;
justify-content: center;
position: absolute;
text-align: center;
width: 100%;
z-index: -1;
}
</style>

</head>
<body>
 <div id=\"loading\">
<div>Loading theme</div>
</div>
<admin-theme></admin-theme>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "overview/test.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  233 => 203,  224 => 201,  172 => 152,  19 => 1,);
    }
}

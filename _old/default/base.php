<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $arg['title'].' - '.title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

<!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo site;?>favicon.ico">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
      <script src="/js/respond.min.js"></script>
    <![endif]-->

<!-- CSS styles -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo site;?>css/default.css">
<?php if (function_exists('css_after')){css_after();}
      if (function_exists('ga')) {ga();}
?>
  </head>
  <body>
<?php if (function_exists('nav')) {nav(); }
      if (function_exists('content')) {content($data); }
      if (function_exists('footer')) {footer(); }
?>
  </body>
<!-- JS WITH LOCAL and IE FALLBACK -->
    <script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/lib/jquery-2.0.0.min.js"><\/script>')</script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

    <script type="text/javascript">
      var url = window.location;
        $('ul.nav a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');
    </script>
<?php if (function_exists('js')) {js(); }?>
</html>
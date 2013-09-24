<?php
function head($title)
{ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title.' - '.title; ?></title>
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

<?php if(DEV_ENV !== true){ ?>
<!-- Google analitics -->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-7118296-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
<?php }

}
function css()
{ ?>
<!-- CSS styles -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo site;?>css/default.css">
    <?php if(function_exists('css_after')){css_after();}
}
function js()
{ ?>
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
    <?php if(function_exists('js_after')){js_after();}
}
function nav()
{ ?>
<!-- Subhead ================================================== -->
    <header class="header">
      <div class="container">
        <h1>thijzer.blog</h1>
          <ul class="navcontainer lead">
            <li><a href="<?php echo site;?>">blog </a> //</li>
            <li><a href="<?php echo site;?>contact">contact </a>//</li>
            <li><a href="<?php echo site;?>about">about </a></li>
<?php if(!empty($_SESSION['username'])) { ?>
            <li class="dropdown">//
              <a href="<?php echo site;?>admin/" class="dropdown-toggle" data-toggle="dropdown">admin<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href='<?php echo site;?>logout'>logout</a></li>
                <li><a href='<?php echo site;?>admin/settings'>settings</a></li>
                <li><a href='<?php echo site;?>admin/add'>add</a></li>
              </ul>
            </li>
<?php } ?>
          </ul>
          <HR>
      </div>
    </header>

<?php }
function footer()
{ ?>
<!--=== Copyright ===-->
    <footer>
      <HR>
      <div class="container">
        <div class="pull-right hidden-xs">
          <ul class="navcontainer pull-right">
            <li><a href="<?php echo site;?>">blog </a>//</li>
            <li><a href="<?php echo site;?>contact">contact </a>//</li>
            <li><a href="<?php echo site;?>about">about </a></li>
          </ul>
        </div>
        <div>
          <p>&copy; <?php echo title;?> | <a href="<?php echo site;?>about#framework">Romano.Framework</a></p>
        </div>
        <ul class="navcontainer pull-center icons">
          <li><a href="https://twitter.com/Thijzer" target="_blank"><img src="<?php echo site;?>img/twitter.png"></a></li>
          <li><a href="https://www.facebook.com/thijzer" target="_blank"><img src="<?php echo site;?>img/facebook.png"></a></li>
          <li><a href="https://plus.google.com/108354583103011120629/posts" target="_blank"><img src="<?php echo site;?>img/google.png"></a></li>
        </ul>
      </div>
    </footer>

<?php }
function notice($msg)
{
  if(($msg['notice']))
  { ?>
    <div class="alert alert-success">
      <?php echo $msg['notice']; ?>
    </div>
<?php }

  if(($msg['errors']))
  { ?>
    <div class="alert alert-danger">
      <?php
      if (is_array($msg['errors'])) {
        foreach ($msg['errors'] as $error)
        {
          echo $error;
        }
      } else {
        echo $msg['errors'];
      }?>
    </div>
<?php }

}
?>
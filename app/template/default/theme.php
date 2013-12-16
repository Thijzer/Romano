<?php
function ga()
{
 if (DEV_ENV !== true){ ?>
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
function nav()
{ ?>
<!-- Subhead ================================================== -->
    <header class="header">
      <div class="container">
        <h1>thijzer.blog</h1>
          <ul class="navcontainer lead">
            <li><a href="<?php echo site;?>">blog </a> //</li>
            <li><a href="<?php echo site;?>gallery/">gallery </a>//</li>
            <li><a href="<?php echo site;?>contact">contact </a>//</li>
            <li><a href="<?php echo site;?>about">about </a></li>
<?php if(!empty($_SESSION['username'])) { ?>
            <li class="dropdown">//
              <a href="<?php echo site;?>admin/" class="dropdown-toggle" data-toggle="dropdown">admin<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href='<?php echo site;?>logout'>logout</a></li>
                <li><a href='<?php echo site;?>admin/settings'>settings</a></li>
                <li><a href='<?php echo site;?>admin/add'>add post</a></li>
                <li><a href='<?php echo site;?>gallery/manage'>manage gallery</a></li>
                <li><a href='<?php echo site;?>gallery/create'>create album</a></li>
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
<?php } ?>
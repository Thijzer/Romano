<?php
function css_after()
{
?>
      <link href="<?php echo site;?>css/login.css" rel="stylesheet" type="text/css">
<?php
}
function content($data)
{
?>
    <div class="container">
      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="text" class="form-control" placeholder="Username" pattern="[a-zA-Z0-9]{6,20}" value="<?php echo input::get('username'); ?>" title="6 to 20 characters minimum" name="username" autofocus required>
        <input type="password" class="form-control" placeholder="Password" pattern="[a-zA-Z0-9]{6,20}" title="6 to 20 characters minimum" name="password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        	<a href="<?php echo site;?>users/lost">password lost?</a>
        </label>
        <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Login</button>
      </form>
    </div> <!-- /container -->
<?php
}
?>
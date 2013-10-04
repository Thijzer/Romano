<?php
function css_after(){?>
      <link href="<?echo site?>css/login.css" rel="stylesheet" type="text/css">
<?}
function content($data){
extract($data);
?>
    <div class="container">

      <form class="form-signin" action="/users/login" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" placeholder="Username" pattern="[a-zA-Z0-9]{6,20}" value="<?echo $user['username']?>" title="6 to 20 characters minimum" name="username" autofocus>
        <input type="password" class="form-control" placeholder="Password" pattern="[a-zA-Z0-9]{6,20}" title="6 to 20 characters minimum" name="password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        	<a href="<?echo site?>users/lost">password lost?</a>
          <div style="color: red"><?echo $user['errors']?></div>
        </label>
        <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Login</button>
      </form>

    </div> <!-- /container -->
<?}?>
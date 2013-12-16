<?php
function css_after()
{
?>
<link href="<?php echo site;?>css/login.css" rel="stylesheet" type="text/css">
<?php
}
function content(){
?>
<div class="container">
  <form class="form-signin well" action='' method='post'>
    <h2 class="form-signin-heading">Please Register</h2>
    <input type='text' class="form-control" placeholder="username" pattern='[a-zA-Z0-9]{6,20}' value='<?php echo Input::get('username');?>' title='6 to 20 characters minimum' name='username' r_equired>
    <br>
    <input type='password' class="form-control" placeholder="password" pattern='[a-zA-Z0-9]{6,20}' title='6 to 20 characters minimum'  name='password' r_equired>
    <input type='password' class="form-control" placeholder="password check" pattern='[a-zA-Z0-9]{6,20}' title='6 to 20 characters minimum' name='password2' r_equired>
    <br>
    <input type='email' class="form-control" placeholder="email" id='email' value='<?php echo Input::get('email');?>' title='email address r_equired' name='email' r_equired>

    <input type='submit' class="btn btn-lg btn-primary btn-block" name='register' value='Register' />
    <input type='button' class="btn btn-lg btn-primary btn-block" name='cancel' value='Cancel' onclick='location.href=\"index\";' />
  </form>
</div>

<?php } ?>
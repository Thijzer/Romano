<?php
function css_after()
{
?>
  		<link href="<?php echo site;?>css/login.css" rel="stylesheet" type="text/css">
<?php
}
function content($data){
extract($data);
?>
<div class="container">
<form class="form-signin well" action='' class="form-control" method='post'>
	<h2 class="form-signin-heading">Please Register</h2>
	<input class="form-control" placeholder="type in your new password" type='password' size='10' name='password'>
	<input class="form-control" placeholder="retype your new password" type='password' size='10' name='password2'>
	<input type='submit' name='reset' value='Reset password'>
</form>
<?}?>
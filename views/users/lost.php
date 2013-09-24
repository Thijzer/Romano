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
		<form class="form-signin well" action='lost' method='post'>
			<h2 class="form-signin-heading">User lost</h2>
			<input type='text' size='20' class="form-control" placeholder="type email here" name='email' value='<?echo $email?>' title='6 to 20 characters minimum'>
			<br>
			<input type='submit' class="btn btn-lg btn-primary btn-block" name='lost' value='Reset password'>
			<input type='button' class="btn btn-lg btn-primary btn-block" name='cancel' value='Cancel' onclick='location.href=\"index\";' />
		</form>
	</div>

<?php } ?>
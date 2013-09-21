<?php
function content($data){
extract($data);
?>
<div class="container">
	<form action='register' method='post'>
		<p>Username : <input type='text' size='20' pattern='[a-zA-Z0-9]{6,20}' value='<?php echo $data['username'];?>'
		title='6 to 20 characters minimum' name='username' r_equired></p>
		<p>Password : <input type='password' size='10' pattern='[a-zA-Z0-9]{6,20}'
		title='6 to 20 characters minimum'  name='password' r_equired></p>
		<p>Confirm Password :<input type='password' size='10' pattern='[a-zA-Z0-9]{6,20}'
		title='6 to 20 characters minimum' name='password2' r_equired></p>
		<p>E-mail : <input type='email' id='email' size='25' value='<?php echo $data['email'];?>'
		title='email address r_equired' name='email' r_equired></p>
		<p><input type='submit' name='register' value='Register' />
		<input type='button' name='cancel' value='Cancel' onclick='location.href=\"index\";' /></p>
	</form>
</div>
<div style="color: red">
	<?php if($errors) {
		foreach ($errors as $error) {
	echo $error.'<br>';
}
} ?>
</div>

<?php } ?>
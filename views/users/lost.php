<form action='lost' method='post'>
	<p>email:<input type='text' size='20' name='email' value='<?echo $email?>' title='6 to 20 characters minimum'></p>
	<p><input type='submit' name='lost' value='Reset password'><input type='button' name='cancel' value='Cancel' onclick='location.href=\"index\";' /></p>
</form>
<div style="color: red"><?echo $errors?><?echo $email?></div>
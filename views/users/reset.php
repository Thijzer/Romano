<?php
function content($data){
extract($data);
?>
<div class="container">
<form action='' method='post'>
	<p>type in your new password:<input type='password' size='10' name='password'></p>
	<p> retype your new password:<input type='password' size='10' name='password2'></p>
	<p><input type='submit' name='reset' value='Reset password'>
</form>
<?}?>
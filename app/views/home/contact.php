<?php
function content($data){
extract($data);
?>

<div class="container">

	<h3>Find me on the web</h3>
	<ul>
		<li><a href="https://plus.google.com/108354583103011120629/posts">Google+</a></li>
		<li><a href="https://www.facebook.com/Thijzer">Facebook</a></li>
		<li><a href="http://www.linkedin.com/in/thijsdp">Linkedin</a></li>
		<li><a href="https://twitter.com/Thijzer">Twitter</a></li>
	</ul>
	<p>Or send me a message</p>
	<form name="getintouch" method="post" action="">
		<label>name *</label>
		<p>
			<input name="name" type="text" alt="Your Name" value="" tabindex="6" required>
		</p>

		<label>email *</label>
		<p>
			<input name="email" type="text" alt="Your Email" value="" tabindex="7" required>
		</p>

		<label>message *</label>
		<p>
			<textarea name="Fmessage" cols="25" rows="3" tabindex="8" required></textarea>
		</p>
		<p>
			<small>*All Fields Are Required</small>
			<input type="submit" name="submit" title="Submit" value="Submit">
		</p>
	</form>
</div>

<?php } ?>
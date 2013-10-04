<?php
function css_after() {
?>
<style>
  body {
    padding-top: 100px;
    padding-bottom: 40px;
    color: #5a5a5a;
  }
  .container {
    width: 500px;
    text-align: center;
  }
</style>

<?php }
function content($data) {

$error = 'Error '.$data['code'];
switch ($data['code']) {
  case '404':
    $error .= ' : Page Not Found';
    $info = "We couldn't find the page you requested on our servers.";
    $button = "return to the homepage";
    break;
  case '500':
    $error .= ' : Server error';
    $info = "We need you to sign in again, in order to access this page.";
    $button = "return to the homepage";
    break;
  case '1337':
    $error .= ' : No Acces';
    $info = "We need you to sign in again, in order to access this page.";
    $button = "Please Log in";
    $butloc = 'login';
    break;
}

?>
	<div class="container">
				<h1><?php echo $error; ?></h1>
        <hr>
				<p><?php echo $info; ?></p>
				<a class="btn btn-large btn-success" href="<?php echo site.$butloc; ?>"><?php echo $button; ?></a>
	</div>
<?php } ?>
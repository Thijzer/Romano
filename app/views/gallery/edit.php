<?php
function js_after() { ?>

<?php }
function css_after() { ?>

<?php }
function content($data) {
extract($data);
?>

<div class="container">
	<form action="" method="post">
		<div class="row">
			<div>
			title: <input name="title" type="text" value="<?php echo $list['title']; ?>">
			keycode: <input name="keycode" type="text" value="<?php echo $list['keycode']; ?>">
			description: <textarea name="description"><?php echo $list['description']; ?></textarea>
			public: <input type="checkbox" name="public" <?php if ($list['public'] == '1') {echo "checked disabled";} ?>>
			guest url: <a href="<?php echo site.'gallery/album/'.$list['id'].'?guest='.$list['guestcode']; ?>">link guestcode</a>
				<input type="submit" name="edit"  value="Edit">
				<input type="button" name="back" value="Back" onclick="location.href='/gallery/manage/'">
		</div>
		<BR>
		<div class="row">
<?php
if (!empty($pics)) {
  $c = count($pics);
  for ($i=0; $i < $c; $i++) { ?>
	  	<div class="col-sm-2 col-md-2">
		  	<div class="thumbnail">
		  		<img src="<?php echo site.$pics[$i]['path'].$pics[$i]['filename']; ?>s.jpg">
		  		<p><input type="checkbox" name="<?php echo $pics[$i]['id']; ?>" <?php if ($pics[$i]['public'] == '1') {echo "checked";} ?>>public</p>
		  	</div>
		  </div>
<?php } }?>
		</div>
	</div>
	</form>
</div>

<?php } ?>
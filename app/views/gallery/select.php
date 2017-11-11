<?php
function js_after() { ?>

<?php }
function css_after() { ?>

<?php }
function content($data) {
extract($data);
$url = site.'gallery/album/'.$list['id'].'/'.str_replace(' ','-', $list['title']);
?>

<div class="container">
	<div class="well">
		<h3>Selection : <?php echo $list['title']; ?></h3>
		<p class="help-block">select the pictures you wish to share</p>
		<input type="text" size="60" value="<?php echo $url.'?guest='.$list['guestcode']; ?>">
		<p class="help-block">copy this link to share your pictures with friends</p>
		<form action="" method="post">
			<input class="btn" type="submit" name="edit"  value="Edit selection">
			<input class="btn" type="button" name="cancel" value="Back to gallery" onclick="location.href='<?php echo $url; ?>'">
	</div>
	<div class="row">
<?php
if (!empty($pics)) {
  $c = count($pics);
  for ($i=0; $i < $c; $i++) { ?>
  		<div class="col-sm-2 col-md-2">

		  	<div class="thumbnail">
		  		<img src="<?php echo site.$pics[$i]['path'].$pics[$i]['filename']; ?>s.jpg">
		  		<p><input type="checkbox" name="<?php echo $pics[$i]['id']; ?>" <?php if ($pics[$i]['cust_select'] == '1') {echo "checked";} ?>>select</p>
		  	</div>
		  </div>
<?php } }?>
		</div>
	</form>
</div>

<?php } ?>
<?php
function js_after() { ?>

<?php }
function css_after() { ?>

<?php }
function content($data) {
extract($data);
?>
   <div class="container">
<?php
$c = count($albums);
for ($i = 0; $i < $c; $i++) {
	$title = str_replace(' ', '-', $albums[$i]['title']); ?>
	  	<div class="col-sm-2 col-md-2">
	  		<a href="<?php echo site; ?>gallery/album/<?php echo $albums[$i]['id'].'/'.$title; ?>">
		  	<div class="thumbnail">
		  		<h4><?php echo $albums[$i]['title']; ?></h4>
		  		<img src="<?php echo site.$albums[$i]['path'].$albums[$i]['cover']; ?>s.jpg">
		  	</div>
		  	</a>
		  </div>
<?php } ?>
		</div>

<?php } ?>
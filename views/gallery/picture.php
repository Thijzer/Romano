<?php
function js_after() { ?>

<?php }
function css_after() { ?>

<?php }
function content($data) {
extract($data);
?>

<div class="container">
	<img style="display:inline-block;max-width:80%" src="<?php echo site.$pic['path'].$pic['filename']; ?>m.jpg">
</div>

<?php } ?>
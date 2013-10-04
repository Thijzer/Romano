<?php
function js_after() { ?>

<?php }
function css_after() { ?>

<?php }
function content($data) {
extract($data);
?>

    <div class="container">
    	<div class="row">
	    	<div class="col-sm-2 col-md-2">
<?php if (isset($edit)) { ?>
					<h4>editor</h4>
	    		<ul>
	    			<li><a href="<?php echo $edit; ?>">select your photo's</a></li>
	    			<li><a href="<?php echo $guesturl; ?>">guesturl</a></li>
	    			<li><a href="#keycode">keycode</a></li>
	    		</ul>
<?php } ?>
		      <form action="" method="post">
		        <input type="keycode" placeholder="keycode" <?php if (isset($_GET['guest'])) {echo 'value="'.$_GET['guest'].'"'; } ?> name="keycode">
		        <button class="btn btn-primary" name="code" type="submit">enter</button>
		      </form>
		      <?php notice($data['msg']); ?>
	    	</div>
   		 	<div class="col-sm-10 col-md-10">
   		 		<div class="well">
   		 			<h2><?php echo str_replace('-', ' ', $data['section'][3]); ?></h2>

				<div class="row">
<?php
if (!empty($pics)) {
  $c = count($pics);
  for ($i=0; $i < $c; $i++) { ?>
	  	<div class="col-sm-2 col-md-2">
		  	<div class="thumbnail">

		  		<a href="<?php echo site; ?>gallery/picture/<?php echo $pics[$i]['id']; ?>"><img src="<?php echo site.$pics[$i]['path'].$pics[$i]['filename']; ?>s.jpg"></a>
		  	</div>
		  </div>
<?php } }?>
		</div>
	</div>
	</div>


    	</div>
		<br>

    </div> <!-- /container -->

<?php } ?>
<?php

head($title = '500  - '.title);
css();
?>

<style>
body {
  padding-top: 100px;
  padding-bottom: 40px;
  color: #5a5a5a;
}
.container {
	width: 600px;
	text-align: center;
}
</style>

</head>
  <body>
	<div class="container">
				<?php $messages = array( 'What happened?', 'The spaghetti got stuck.', 'Big Bang in micro format.' ); ?>

				<h1>Error:500 (Server error)</h1>
        <h2><?php echo $messages[mt_rand(0, 2)]; ?></h2>
        <hr>
				<h3>What does this mean?</h3>
				<p>
					We're sorry for the inconvenience, A Server error has accured trying to load this page.
          An administrator has been warned for further investigation.
				</p>
				<a class="btn btn-large btn-success" href="<?echo site?>">Return to home page</a>
	</div>
  </body>
</html>
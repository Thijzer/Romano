<?php

head($title = '404  - '.title);
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
				<?php $messages = array( 'We need a map.', 'I think we\'re lost.', 'We took a wrong turn.' ); ?>

				<h1>Error:404 (Page Not Found)</h1>
        <h2><?php echo $messages[mt_rand(0, 2)]; ?></h2>
        <hr>
				<h3>What does this mean?</h3>
				<p>
					We couldn't find the page you requested on our servers.
				</p>
				<a class="btn btn-large btn-success" href="<?echo site?>">Return to home page</a>
	</div>
</body>
</html>
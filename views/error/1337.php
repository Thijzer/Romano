<?php

head($title = '1337  - '.title);
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
				<?php $messages = array( 'Damn, I lost the SESSION.', 'We\'re is your VIP Pass?', 'the members Only Club', 'No cookie trails found' ); ?>

				<h1>Error : 1337 (No Access)</h1>
        <h2><?php echo $messages[mt_rand(0, 2)]; ?></h2>
        <hr>
				<h3>What does this mean?</h3>
				<p>
					We need you to sign in again, in order to access this page.
				</p>
				<a class="btn btn-large btn-success" href="<?php echo site;?>login">Please Log in</a>
	</div>
</body>
</html>
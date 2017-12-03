<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />

		<title>Invoicing System</title>

		<!-- Font -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
		<!-- Font Awsome -->
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous" />
		<!-- Custom Styles -->
		<link rel="stylesheet" type="text/css" href="/site/css/styles.css" />
	</head>
	<body>
		<?php
			//Header
			include "../app/views/site/main/header.tpl.php";
		?>

		<div class="container-fluid" id="wrapper">
			<?php
				//Current page template
				Libs\Common\View::render();
			?>
		</div>


		<div class="preloader-wrapper">
            <img src="img/main-preloader.gif" />
        </div>


		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<!-- Tether -->
		<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
		<!-- Bootstrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
		<!-- Custom -->
		<script src="/site/js/app.js"></script>
	</body>
</html>
<?php
require_once 'core/init.php';

if (!logged_in()) {
//If not loggend goto index
	header('Location: index.php');
} else if ($clearance == 1 || $clearance == 2 || $clearance == 3 || $clearance == 9){
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/advanced.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script>
		function show_filter_menu(a){
			if(a == 1){
				$("#post_filter").slideUp("fast");
				$("#filter_menu").attr("onclick", "show_filter_menu(2)");
				$("#filter_menu").attr("style", "transform: rotate(0deg);");
			} else if(a == 2){
				$("#post_filter").slideDown("fast");
				$("#filter_menu").attr("onclick", "show_filter_menu(1)");
				$("#filter_menu").attr("style", "transform: rotate(180deg);");
			}
		}
	</script>
</head>
<body>
	<?php include("includes/menubar.php"); ?>
	<div id="container">
		<div id="wrapper">
			<div id="filter_menu" onclick="show_filter_menu(2)"><i class="fa fa-angle-down"></i></div>
			<div id="post_filter" class="post" hidden>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="radio" name="world" value="*" checked="">
					<input type="radio" name="world" value="1">
					<input type="radio" name="world" value="2">
					<input type="submit" value="Submit">
				</form>
			</div>
		</div>
	</div>
</body>
</html>
<?php } ?>
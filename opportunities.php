<?php
require_once 'core/init.php';

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Opportunities</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/opportunities.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/jquery-jvectormap-2.0.3.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-jvectormap-2.0.3.min.js"></script>
	<script type="text/javascript" src="js/jquery-jvectormap-africa-mill.js"></script>
</head>
<body>
	<?php include("includes/navbar2.php");?>
	<div id="wrapper">
		<style>

			#opportunities_result_container{
				float: left;
				width: 60%;
				margin: 0 20% 10% 20%;
				border-radius: 3px;
			}
			.opportunities_result{
				float: left;
				width: 100%;
				-webkit-touch-callout: none;
				-webkit-user-select: none;
				-khtml-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
				min-width: 100%;
			}
			.opportunities_result_title{
				float: left;
				width: 90%;
				padding: 15px 5% 5px 5%;
				border-bottom: 1px dotted #0277BD;
			}
			.opportunities_result_title .op_title{
				float: left;
				width: 100%;
				padding: 5px 0;
				color: #0277BD;
				text-align: left;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
			}
			.opportunities_result_title .op_content{
				float: left;
				width: 100%;
				padding: 5px 0 10px 0;
				margin-bottom: 15px;
				text-align: left;
				font-size: .8em;
				letter-spacing: 1px;
				line-height: 1.4em;
				height: 3em;
				overflow: hidden;
			}
		</style>
		<div class="container sector_info">
			<div id="opportunities_container">
				<p id="opportunities_overtitle">Find new opportunities</p>
				<form method="GET">
					<div class="opportunities_select">
						<p class="opportunities_undertitle">Country</p>
						<select name="country">
							<option value="" disabled selected>Country</option>
							<?php foreach ($every_country as $key) {
								echo '
									<option value="'.$key.'">'.$key.'</option>
								';
							}
							?>
						</select>
					</div>
					<div class="opportunities_select">
						<p class="opportunities_undertitle">Business sector</p>
						<select name="sector" id="filter_sector">
							<option value="" disabled selected>Sector</option>
							<?php foreach ($every_sector as $key) {
								echo '
									<option value="'.$key.'">'.$key.'</option>
								';
							}?>
						</select>
					</div>
					<div class="opportunities_select">
						<p class="opportunities_undertitle">Amount</p>
						<select name="price" id="filter_price">
							<option value="" disabled selected>Price</option>
							<?php foreach ($every_price as $key) {
								echo '
									<option value="'.$key.'">'.$key.'</option>
								';
							}?>
						</select>
					</div>
					<div class="opportunities_select">
						<input type="submit" value="Search" id="filter_submit">
						<input type="button" value="Reset" onclick="location.href='opportunities.php'" style="margin-left: 5px"></input>
					</div>
				</form>

			</div>
			<div id="opportunities_result_container">
<?php

			$sql = "SELECT post_id, post_title, post_content FROM posts";
			
			// Filter the posts
				if (isset($_GET['country'])) {
					$sql .= " WHERE country ='".$_GET['country']."'";
					if (isset($_GET['sector'])) {
						if ($_GET['sector'] !== "Other") {
							$sql .= " AND post_section = '".$_GET['sector']."'";
						} else {
							$sql .= " AND post_section NOT IN ('Oil and Gas',
																 'ICT',
																 'Agribusiness',
																 'Construction and Infrastructure',
																 'Investment and Jointures',
																 'Mines and Metal',
																 'Health care and Life services')";
						}
						if (isset($_GET['price'])) {
							$sql .= " AND post_price ='".$_GET['price']."'";
						}
					}
					if (isset($_GET['price'])) {
						$sql .= " AND post_price ='".$_GET['price']."'";
						if (isset($_GET['sector'])) {
							if ($_GET['sector'] !== "Other") {
								$sql .= " AND post_section = '".$_GET['sector']."'";
							} else {
								$sql .= " AND post_section NOT IN ('Oil and Gas',
																	 'ICT',
																	 'Agribusiness',
																	 'Construction and Infrastructure',
																	 'Investment and Jointures',
																	 'Mines and Metal',
																	 'Health care and Life services')";
							}
						}
					}
				}

			//Filter post (if only price and sector is selected)
				if (isset($_GET['price']) && !isset($_GET['country'])) {
					$sql .= " WHERE post_price ='".$_GET['price']."'";
					if (isset($_GET['sector'])) {
						if ($_GET['sector'] !== "Other") {
							$sql .= " AND post_section = '".$_POST['sector']."'";
						} else {
							$sql .= " AND post_section NOT IN ('Oil and Gas',
																 'ICT',
																 'Agribusiness',
																 'Construction and Infrastructure',
																 'Investment and Jointures',
																 'Mines and Metal',
																 'Health care and Life services')";
						}
					}
				}
				
			//Filter post (if nothing but sector is selected)
				if (isset($_GET['sector']) && !isset($_GET['country']) && !isset($_GET['price'])) {
					if ($_GET['sector'] !== "Other") {
						$sql .= " WHERE post_section = '".$_GET['sector']."'";
					} else {
						$sql .= " WHERE post_section NOT IN ('Oil and Gas',
															 'ICT',
															 'Agribusiness',
															 'Construction and Infrastructure',
															 'Investment and Jointures',
															 'Mines and Metal',
															 'Health care and Life services')";
					}
				}

			$sql.= " ORDER BY post_id DESC";
			if ($result = $mysqli->query($sql)) {
				while ($row = $result->fetch_assoc()) {
					$post_id[] = $row['post_id'];
					$post_title[] = $row['post_title'];
					$post_content[] = $row['post_content'];
				}
				$result->free();
			}

			for ($i=0; $i < 5; $i++) {
				if (empty($post_title[$i])) {
					$post_title[$i] = '...';
				}
				if (strlen($post_content[$i]) > 10 || empty($post_content[$i])) {
					$post_content[$i] = substr($post_content[$i], 0, 150) . '...';
				}
?>
				<div class="opportunities_result">
					<div class="opportunities_result_title">
						<p class="op_title"><?php echo $post_title[$i];?></p>
						<p class="op_content"><?php echo $post_content[$i];?></p>
					</div>
				</div>
<?php
			}
?>
			</div>
			<p style="font-size: 1em">Login or signup too see all the projects.</p>
		</div>
	</div>
	<?php include("includes/footer2.php"); ?>
</body>
</html>
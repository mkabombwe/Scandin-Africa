<?php
require_once 'core/init.php';

//The different sectors
if (isset($_GET['sector'])){

	//Oil and Gas
	if ($_GET['sector'] == 'oil-gas'){
		$sector_img = 'url(img/s01.jpg);';
		$sector_title = 'Oil and Gas';
		$sector_info = '
			<p>Our team works with, mediates, and creates links between manufacturers and the oil and gas sector, worldwide.</p>
			<p>From sale, to implementation, to technical support and aftermarket service coordination, Scandin-Africa® Network simplifies 
			the process of bringing the best products possible to an ever-changing and dynamic industry.</p>';
	}

	//
	else if ($_GET['sector'] == 'ict'){
		$sector_img = 'url(img/s02.jpg);';
		$sector_title = 'ICT';
		$sector_info = '
			<p>ICT in Africa is a blooming industry with its own set of unique opportunities and challenges.</p>
			<p>In the past decade, the growth of Africa’s mobile industry is considered to be one of the continent’s 
			successes in development and technology.</p>
			<p>Our team creates commercial bridges between IT companies and government in order to build new infrastructures and services and infrastructure</p>';
	}

	//
	else if ($_GET['sector'] == 'agrobusiness-fishery'){
		$sector_img = 'url(img/s03.jpg);';
		$sector_title = 'Agrobusiness and Fishery';
		$sector_info = '
			<p>Our team creates commercial bridges between food producers and consumers.</p>
			<p>We are the element of connectivity needed for good and worthwhile business transactions in the food and beverage industries 
			throughout Scandinavia and other markets.</p>';
	}

	//
	else if ($_GET['sector'] == 'construction'){
		$sector_img = 'url(img/s04.jpg);';
		$sector_title = 'Construction and Infrastructure';
		$sector_info = '
			<p>Africa’s rapidly growing middle class continues to drive demand for sustainable social infrastructure. 
			Added to that, growth is being fuelled by continued investment in natural resources and agriculture.</p>
			<p>Scandin-Africa® creates bridges between developers, construction companies, governments and the public sector in order to develop new projects.</p>';
	}

	//
	else if ($_GET['sector'] == 'investment-jointventure'){
		$sector_img = 'url(img/s05.jpg);';
		$sector_title = 'Investment and Joint Ventures';
		$sector_info = '
			<p>Foreign direct investment (FDI) in Africa has reached the highest level in a decade.</p>
			<p>With ten of the world’s fifteen fastest growing economies, it is no wonder that Africa 
			continues to attract considerable FDI inflows and this positive trend is expected to continue.</p>
			<p>Scandin-Africa® is a facilitator, with its network it helps funds to find investment and to create joint ventures...</p>';
	}

	//
	else if ($_GET['sector'] == 'mines-metal'){
		$sector_img = 'url(img/s06.jpg);';
		$sector_title = 'Mines and Metal';
		$sector_info = '
			<p>Scandin-Africa® is a business bridge for mining and metal companies, advisors to the mining and metal industry, 
			service providers and governments to promote themselves to a senior level.</p>
			<p>Scandin-Africa® focused audience of financial institutions, analysts, mining executives and media.</p>';
	}

	//
	else if ($_GET['sector'] == 'health-life'){
		$sector_img = 'url(img/s08.jpg);';
		$sector_title = 'Health Care and Life Services';
		$sector_info = '
			<p>In Africa, the sector is undergoing major policy, system and infrastructural changes.</p>
			<p>The private sector will continue to play a key role in improving the health of African’s people, 
			and health expenditure will continue to grow rapidly.</p>
			<p>Donors, governments, and the investment community each have a role in developing private health care sector 
			in the region, and Scandin-Africa® is helping to do so.</p>';
	}

	else if ($_GET['sector'] == 'child-foundation'){
		$sector_img = 'url(img/s07.jpg);';
		$sector_title = 'Child Foundations';
		$sector_info = '
			<p>Scandin-Africa Foundation is a non-profit organization that prides itself on giving 100% of its profits to helping underprivileged children around West and Central Africa. We currently support 4 orphans in Cameroon and in Côte d’Ivoire by providing food, clothing, school furnitures, education, medical care and others needs. Thanks to God</p>
			<a href="http://www.scandin-africafoundation.com" id="support_child">Support a child</a>';
	}

	else if ($_GET['sector'] == 'training-business'){
		$sector_img = 'url(img/s09.jpg);';
		$sector_title = 'Training-Business';
		$sector_info = '
			<p>High Value Business Training = High Return on Investment.</p>
			<p>Business Training is for high achievers and for those who want to make rapid gains in a short period of time. Frameworks of success can be found in many places, but it sometimes takes massive action to make them work. Vision, leadership and strategy are required to get your business to the next level. (2017)</p>';
	}
	else if ($_GET['sector'] == 'renewable-energy'){
		$sector_img = 'url(img/s11.jpg);';
		$sector_title = 'Renewable Energy';
		$sector_info = '
			<p>NIDECO & Scandin-Africa will contribute significantly to the use of Sustainable Energy (SE) in developing countries and thereby contributing positively to sustainable development in urban and rural areas.</p>
			<p>We provide products and solutions to people in urban and rural areas, to the commercial sector and to the industry. Where no markets exist today (typical in rural areas) we have solutions for developing markets.</p>
			<p>We also: <br>
			- Target the need for modern energy services; <br>
			- Offer scalable products and solutions; <br>
			- Aim at replacing the use of fossil fuels and unhealthy energy practice with the production and use of Sustainable Energy.</p>';
	}

	//Return to index if it's none of the above
	else {
		header('Location: index.php');
		exit();
	}



?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Sectors</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/sectors.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<?php include("includes/navbar2.php");?>
	<div id="wrapper">
		<div id="top_img" style="background: <?php echo $sector_img;?>">
			<div id="top_img_filter">
				<div class="container top">
					<h1 class="title"><?php echo $sector_title;?></h1>
				</div>
			</div>
		</div>
		<div class="container sector_info">
			<?php echo $sector_info;?>
		</div>
	</div>
	<?php include("includes/footer2.php"); ?>
</body>
</html>
<?php
} else {
	header('Location: index.php');
	exit();
}
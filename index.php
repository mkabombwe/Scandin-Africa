<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:image" content="https://scandin-africa.com/img/logo.png" />
	<meta property="og:image:url" content="https://scandin-africa.com/img/logo.png" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="includes/slick/slick.css"/>
	<link rel="stylesheet" href="includes/slick/slick-theme.css"/>
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<script src="js/jquery.js"></script>
</head>
<body>
	<div id="header">
		<?php include("includes/navbar.php"); ?>
		<div id="optioncontainer">
			<div id="option-left">
				<div class="option_background_container">
					<h1>SCANDINAVIA</h1>
					<div id="discover_left"><a href="signup.php"><p>Discover</p></a></div>
				</div>
			</div>
			<div id="option-right">
				<div class="option_background_container">
					<h1>AFRICA</h1>
					<div id="discover_right"><a href="signup.php"><p>Explore</p></a></div>
				</div>
			</div>
		</div>
		
		<div id="about" class="hidden1">
			<h1>ABOUT</h1>
			<div class="aboutbox">
				<p>
				Founded in 2015 to be the first and unique Scandinavian and African largest professional networks.<br>
				Facilitating business relations between Scandinavian based companies and their counterparts in West and Central Africa.<br>
				Establish incubators within local community in emerging countries in order to facilitate the growth of sustainable businesses with the highest professional Scandinavian standards.<br>
				Operating leverage at the service of competitiveness for growth and employment, Scandin-Africa® made readable, available and effective chain of actors and services dedicated to the development and success of businesses , whatever their size, sector and country.
				</p>
			</div>
		</div>

		<div id="sectors">
			<h1 class="hidden1">SECTORS</h1>
			<div class="sectors_container">
				<a href="sectors.php?sector=oil-gas"><div class="box"><div id="box_inner1"><div class="box_inner_container"><p>Oil and Gas</p></div></div></div></a>
				<a href="sectors.php?sector=ict"><div class="box"><div id="box_inner2"><div class="box_inner_container"><p>ICT</p></div></div></div></a>
				<a href="sectors.php?sector=agrobusiness-fishery"><div class="box"><div id="box_inner3"><div class="box_inner_container"><p>Agrobusiness and Fishery</p></div></div></div></a>

				<a href="sectors.php?sector=construction"><div class="box"><div id="box_inner4"><div class="box_inner_container"><p>Construction</p></div></div></div></a>
				<a href="sectors.php?sector=renewable-energy"><div class="box"><div id="box_inner5"><div class="box_inner_container"><p>Renewable Energy</p></div></div></div></a>
				<a href="sectors.php?sector=mines-metal"><div class="box"><div id="box_inner6"><div class="box_inner_container"><p>Mines and Metal</p></div></div></div></a>

				<a href="sectors.php?sector=child-foundation"><div class="box"><div id="box_inner7"><div class="box_inner_container"><p>Child Foundation</p></div></div></div></a>
				<a href="sectors.php?sector=health-life"><div class="box"><div id="box_inner8"><div class="box_inner_container"><p>Health Care and Life Services</p></div></div></div></a>
				<a href="sectors.php?sector=training-business"><div class="box"><div id="box_inner9"><div class="box_inner_container"><p>Training-Business</p></div></div></div></a>
			</div>
		</div>

		<div id="opportunities">
			<div id="opportunities_box_container">
				<p id="opportunities_overtitle">Find new opportunities</p>
				<form action="opportunities.php" method="GET">
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
			<div id="opportunities_container">
				<div id="opportunity1">
					<div class="my_opportunity">
						<div class="my_opportunity_left">
							<div class="my_opportunity_img_container">
								<img class="my_opportunity_img" src="img/op1.jpg">
							</div>
						</div>
						<div class="my_opportunity_right">
							<h1>DEVELOP TRADE</h1>
							<p>We promote inter-West African relation &amp; Scandinavian which offers many business opportunities by providing public and private projects, legal advice, local services, exclusivity of distribution product and consultancy services.</p>
						</div>
					</div>
				</div>
				<div id="opportunity2">
					<div class="my_opportunity">
						<div class="my_opportunity_left">
							<div class="my_opportunity_img_container">
								<img class="my_opportunity_img" src="img/op2.jpg">
							</div>
						</div>
						<div class="my_opportunity_right">
							<h1>TO GENERATE LEADS</h1>
							<p>Scandinavian &amp; African Buyers/Sellers Marketplace : view business trade offers, buying offers posted by importers and buyers from across Africa and Scandinavia to maximize your business opportunities.</p>
						</div>
					</div>
				</div>
				<div id="opportunity3">
					<div class="my_opportunity">
						<div class="my_opportunity_left">
							<div class="my_opportunity_img_container">
								<img class="my_opportunity_img" src="img/op3.jpg">
							</div>
						</div>
						<div class="my_opportunity_right">
							<h1>TO GROW YOUR NETWORK</h1>
							<p>Our mission’s is to bring key players in the Scandinavians and Africans entrepreneurial world by connecting them into the unique networking platform.</p>
						</div>
					</div>
				</div>
				<div id="opportunity4">
					<div class="my_opportunity">
						<div class="my_opportunity_left">
							<div class="my_opportunity_img_container">
								<img class="my_opportunity_img" src="img/op4.jpg">
							</div>
						</div>
						<div class="my_opportunity_right">
							<h1>TO OFFER JOB OPPORTUNITIES</h1>
							<p>An exciting future awaits you at Scandin-Africa networking platform. Browse the opportunities in your field all over Africa and Scandinavia.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			$('#opportunities_container').slick({
				accessibility: true,
				autoplay: true,
				autoplaySpeed: 5000
			});
		</script>

		<div id="pricing">
			<div class="pricing_container">
				<h1 class="hidden1">Pricing</h1>
				<div class="pricing_box hidden1">
					<div class="pricing_box_top">
						<p>Discover</p>
					</div>
					<div class="pricing_box_middle">
						<p id="pricing_box_title1">free</p>
					</div>
					<div class="pricing_box_bottom">
						<p>Upload opportunities</p>
					</div>
					<div class="pricing_box_button">
						<a href="signup.php"><p>Sign up</p></a>
					</div>
				</div>

				<div class="pricing_box hidden1">
					<div class="pricing_box_top">
						<p>Premium</p>
					</div>
					<div class="pricing_box_middle">
						<p id="pricing_box_title2">149€/trimester</p>
					</div>
					<div class="pricing_box_bottom">
						<p>Upload opportunities</p>
						<p>Find new customers</p>
						<p>Find target groups</p>
						<p>Reach decision-makers</p>
						<p>Matching</p>
					</div>
					<div class="pricing_box_button">
						<a href="signup.php"><p>Sign up</p></a>
					</div>
				</div>

				<div class="pricing_box hidden1">
					<div class="pricing_box_top">
						<p>Advantage</p>
					</div>
					<div class="pricing_box_middle">
						<p id="pricing_box_title3">From 299€/trimester</p>
					</div>
					<div class="pricing_box_bottom">
						<p>Upload opportunities</p>
						<p>Find new customers</p>
						<p>Find target groups</p>
						<p>Reach decision-makers</p>
						<p>Matching</p>
						<p>Advertising</p>
						<p>Leads Marketing</p>
						<p>Statistics and Report</p>
					</div>
					<div class="pricing_box_button">
						<a href="signup.php"><p>Sign up</p></a>
					</div>
				</div>
			</div>
		</div>

		<div id="key_people">
			<div id="key_people_container" class="hidden1 lessShown2">
				<h1>KEY PEOPLE</h1>

				<div class="key_people_person">
					<div class="key_people_img_container_first">
						<div class="key_people_img_container_second">
							<img src="img/Madeleine.jpg">
						</div>
					</div>
					<p class="key_people_title">Madeleine TAYLOR, <e>Founder and Chairman</e></p>
					<p class="key_people_info">
						Holder of International Trade licence, 
						Madeleine, French native originally from Guinea Bissau, consecutively worked for Edenred Group, African Chamber 
						of Commerce Scandinavia, Afrimarket Group, Radisson Blu, Danish Primare and Cannes Film Festival where she was in 
						charge of managing projects between Scandinavia, Europe and Africa.
					</p>
				</div>
                <div class="key_people_person">
					<div class="key_people_img_container_first">
						<div class="key_people_img_container_second">
							<img src="img/2c5a5e2.jpg">
						</div>
					</div>
					<p class="key_people_title">Hans-Martin Førsund, <e>Senior Consultant for Scandin-Africa</e></p>
					<p class="key_people_info">
						Hans-Martin is a Norwegian with a Master of Law and more than 25 years work experience, hereunder 12 years of international consultancy and 8 years as a lawyer in different areas of the civil administration of Norway. Today he focuses on sustainable energy (CEO of NIDECO AS) and helping companies to markets in Africa as a consultant for Scandin-Africa.
					</p>
				</div>
				<div class="key_people_person">
					<div class="key_people_img_container_first">
						<div class="key_people_img_container_second">
							<img src="img/pauline.jpg">
						</div>
					</div>
					<p class="key_people_title">Pauline AJANA, <e>Scandinavian countries Manager</e></p>
					<p class="key_people_info">
						Graduated as  an  Export Technician from Odense Technical College and holder a License in International Trade. 
						Pauline represents typically Scandin-Africa by her origins both Danish and Nigerian. She joined Scandin-Africa as 
						Consultant and prospected Scandinavians SME to our networking platform.
					</p>
				</div>
				<div class="key_people_person">
					<div class="key_people_img_container_first">
						<div class="key_people_img_container_second">
							<img src="img/Ben Oumar Ouattara.jpg">
						</div>
					</div>
					<p class="key_people_title">Ben Oumar OUATTARA, <e>Senior Consultant for Scandin-Africa</e></p>
					<p class="key_people_info">
						Ben Oumar is the co-founder of Bandama Group. Company focuses on developing commercial and socio-economic ties 
						between West Africa and the Nordic countries. His ambition is to enable emerging West African economies to take 
						full advantage of innovative technologies and solutions adapted to the reality of the continent.
					</p>
				</div>
				<div class="key_people_person">
					<div class="key_people_img_container_first">
						<div class="key_people_img_container_second">
							<img src="img/profile/profile_default.jpg">
						</div>
					</div>
					<p class="key_people_title">Niels LADEGAARD, <e>Agribusiness Project Leader</e></p>
					<p class="key_people_info">
						To be added.
					</p>
				</div>
				<div class="key_people_person">
					<div class="key_people_img_container_first">
						<div class="key_people_img_container_second">
							<img src="img/DSC_0096.jpg" style="height: 125% !important;">
						</div>
					</div>
					<p class="key_people_title">Laetitia Owendet, <e>Consultant/Content curator</e></p>
					<p class="key_people_info">
						Holder of an Marketing & International Trade Master degree, Laetitia joined Scandin-Africa as consultant. She is involved in some projects in Africa and has a multi-cultural approach of business due to her background and current position in a worldwide company. She mainly deals with SA online visiblity and market perspective.
					</p>
				</div>

			</div>
			<div class="readmore readmore2"><p class="readmore_button2" onclick="moreBotton2(0)">More</p></div>
		</div>

		<div id="key_points">
			<div class="key_points_container">
				<h1 class="hidden1">KEY POINTS</h1>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#009688;"><i class="fa fa-university"></i></div></div>
					<p class="key_point_text">Governments and Chamber of Commerce support</p>
				</div>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#2196F3;"><i class="fa fa-building" aria-hidden="true"></i></div></div>
					<p class="key_point_text">Scandinavian and African companies support</p>
				</div>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#E65100;"><i class="fa fa-money"></i></div></div>
					<p class="key_point_text">Scandinavian Investment fund support</p>
				</div>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#F44336;"><i class="fa fa-users"></i></div></div>
					<p class="key_point_text">A team with more than 20 years expertise in business both in African and Scandinavian countries</p>
				</div>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#3F51B5;"><i class="fa fa-comments" aria-hidden="true"></i></div></div>
					<p class="key_point_text">Strong media partnership with Financial Afrik</p>
				</div>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#673AB7;"><i class="fa fa-line-chart"></i></div></div>
					<p class="key_point_text">Unlocking value for the investor in very short period of time</p>
				</div>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#607D8B;"><i class="fa fa-bolt"></i></div></div>
					<p class="key_point_text">Renewable energies projects on pipe</p>
				</div>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#FF9800;"><i class="fa fa-industry"></i></div></div>
					<p class="key_point_text">Processing factory projects</p>
				</div>
				<div class="key_point_holder hidden1">
					<div class="key_point_circle_container"><div class="key_point_circle" style="background:#795548;"><i class="fa fa-briefcase"></i></div></div>
					<p class="key_point_text">B2B/B2C solutions</p>
				</div>
			</div>
		</div>
		
		<div id="key_partners">
			<h1 class="hidden1">PARTNERS</h1>
			<style>
				</style>
				<div id="key_logos_container">
					<div class="key_logos_control" id="key_logos_leftcontrol"><i class="fa fa-angle-left"></i></div>
					<div id="key_logos_outer">
						<div id="key_logos_inner">
                            <div class="key_partners_box"><a href="#"><img src="img/logo-FA-2015.jpg"></a></div>
                            <div class="key_partners_box"><a href="http://www.nideco.no/"><img src="img/final.jpg"></a></div>
                            <div class="key_partners_box"><a href="http://bandamagroup.com/"><img src="img/web-Bandama-logga.png"></a></div>
                            <div class="key_partners_box"><a href="http://www.mgtelecom.net/"><img src="img/mg back.png"></a></div>
                            <div class="key_partners_box"><a href="http://www.pmenviron.com/"><img src="img/pm Environ.png"></a></div>
							<div class="key_partners_box"><a href="http://www.briqci.com/"><img src="img/BriQci.png"></a></div>
							<div class="key_partners_box"><a href="http://korigins.org/"><img src="img/LOGO KORIGINS4ICCHD.jpg"></a></div>
							<div class="key_partners_box"><a href="#"><img src="img/lamerveille.png"></a></div>
							<div class="key_partners_box"><a href="#"><img src="img/c.png"></a></div>
							<div class="key_partners_box"><a href="#"><img src="img/logo-creatives-corporation.png"></a></div>
							<div class="key_partners_box"><a href="#"><img src="img/Sans titre-1.png"></a></div>
							<div class="key_partners_box"><a href="#"><img src="img/BDC logo v2.jpg"></a></div>
							<div class="key_partners_box"><a href="http://www.conseilcotonanacarde.ci/"><img src="img/logo conseil.jpg"></a></div>
						</div>
					</div>
					<div class="key_logos_control" id="key_logos_rightcontrol"><i class="fa fa-angle-right"></i></div>
				</div>
			<div class="key_partners_container hidden1">
				<p class="key_title">Institutional Partners</p>
				<p class="key_title_under">Minister of Trade Cameroon</p>
				<p class="key_title_under">Scandinavian Funds</p>
                <p class="key_title_under">Chamber of Agriculture, Livestock, Fisheries and Foret</p>
                <p class="key_title_under">Council of Cotton and Cashew Nuts Cote d’Ivoire</p>
                <p class="key_title_under">Chamber of Commerce Cameroon</p>
                <p class="key_title_under">CEPICI</p>
			</div>
		</div>
	</div>
	<?php include("includes/footer2.php"); ?>
	<script type="text/javascript">
		//scrool key_logos

		counter = 0;

		$('#key_logos_rightcontrol').click(function(){
			if (counter >= 0 && counter != 10) {
				$('#key_logos_inner').animate({
					marginLeft: "-=400px"
				}, "fast");
				counter++;
			}
		});
		$('#key_logos_leftcontrol').click(function(){
			if (counter > 0 && counter != 0) {
				$('#key_logos_inner').animate({
					marginLeft: "+=400px"
				}, "fast");
				counter--;
			}
		});
		//scroll to div
		function scrollContact(){
		    $('html, body').animate({
		        scrollTop: $("#contact").offset().top
		    }, 400);
		}
		function scrollOpportunities(){
		    $('html, body').animate({
		        scrollTop: $("#opportunities").offset().top
		    }, 400);
		}
		function scrollAbout(){
		    $('html, body').animate({
		        scrollTop: $("#about").offset().top
		    }, 400);
		}
		function scrollSectors(){
		    $('html, body').animate({
		        scrollTop: $("#sectors").offset().top
		    }, 400);
		}
		function scrollPeople(){
		    $('html, body').animate({
		        scrollTop: $("#key_people").offset().top
		    }, 400);
		}
		function scrollPartners(){
		    $('html, body').animate({
		        scrollTop: $("#key_partners").offset().top
		    }, 400);
		}
		function scrollPoints(){
		    $('html, body').animate({
		        scrollTop: $("#key_points").offset().top
		    }, 400);
		}
		function scrollPricing(){
		    $('html, body').animate({
		        scrollTop: $("#pricing").offset().top
		    }, 400);
		}
		function scrollPeople(){
		    $('html, body').animate({
		        scrollTop: $("#key_people").offset().top
		    }, 400);
		}

		//More about
		var moreBottonActive = 0;
		function moreBotton(){
			if (moreBottonActive == 0){
				$("#about").removeClass("lessShown").addClass("moreShown");
				$('.readmore_button').text('Less');
				moreBottonActive = 1;
			} else if (moreBottonActive == 1) {
				$("#about").removeClass("moreShown").addClass("lessShown");
				$('.readmore_button').text('More');
				moreBottonActive = 0;
			}
		}

		//More contacts
		var moreBottonActive = 0;
		function moreBotton2(){
			if (moreBottonActive == 0){
				$("#key_people_container").removeClass("lessShown2").addClass("moreShown2");
				$('.readmore_button2').text('Less');
				moreBottonActive = 1;
			} else if (moreBottonActive == 1) {
				$("#key_people_container").removeClass("moreShown2").addClass("lessShown2");
				$('.readmore_button2').text('More');
				moreBottonActive = 0;
			}
		}

		//animate
		$(window).scroll(function() {
		    $('.hidden1').each(function(){
		    var imagePos = $(this).offset().top;

		    var topOfWindow = $(window).scrollTop();
		        if (imagePos < topOfWindow+600) {
		            $(this).removeClass("hidden1").addClass("animated fadeInDown");
		        }
		    });
		});

	</script>
	 <script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-79921613-1', 'auto'); ga('send', 'pageview');
	 </script>
	  <!-- Start of Async HubSpot Analytics Code -->
	 <script type="text/javascript">
	   (function(d,s,i,r) {
	     if (d.getElementById(i)){return;}
	     var n=d.createElement(s),e=d.getElementsByTagName(s)[0];
	     n.id=i;n.src='//js.hs-analytics.net/analytics/'+(Math.ceil(new Date()/r)*r)+'/2381130.js';
	     e.parentNode.insertBefore(n, e);
	   })(document,"script","hs-analytics",300000);
	 </script>
	<!-- End of Async HubSpot Analytics Code -->
</body>
</ht
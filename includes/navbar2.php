	<?php
	require_once 'core/init.php';
	?>
	<style type="text/css">
		body{
			margin: 0;
			padding: 0;
			border: 0;
		}
		a{
			text-decoration: none;
		}
		/* NAV - desktop */
		.navcontainer{
			float: left;
			width: 90%;
			height: 80px;
			padding: 0 5%;
			margin: 0 auto;
			background-color: #FFF;
			box-shadow: 0 1px 3px rgba(0,0,0,0.12);
			position: relative;
			display: inline;
			font-family: gidole-regular;
		}
		.navcontainer .logo{
			width: 25%;
			height: 100%;
			float: left;
			background: url(img/logo.png) no-repeat center center;
			background-size: 70%;
		}
		.navcontainer .navigation{
			width: 55%;
			height: 100%;
			padding-left: 2%;
			float: left;
		}
		ul li{
			float: left;
		}
		.navcontainer li a{
			line-height: 80px;
			padding-left: 20px;
			font-size: 1em;
			color: #2B4093;
			transition: all .2s;
		}
		.navcontainer li a:hover{
			color: #4B6EFA;
		}
		.navcontainer .connect{
			width: 15%;
			height: 100%;
			float: left;
		}
		.navcontainer .connect a{
			float: right;
			color: #F44336;
			margin-top: 26px;
			line-height: 30px;
			padding: 0 10px;
		}
		.navcontainer .connect a:hover{
			color: #F44336;
		}
		.navcontainer .connect .signup{
			border: 1px solid #F44336;
			border-radius: 2px;
			width: 44px;
			transition: all .2s;
		}
		.navcontainer .connect .signup:hover{
			background-color: #F44336;
			color: #FFF;
		}
		/* NAV - phone */
		.navcontainer_phone{
			float: left;
			width: 90%;
			height: 70px;
			padding: 0 5%;
			margin: 0 auto;
			background-color: #FFF;
			box-shadow: 0 1px 3px rgba(0,0,0,0.12);
			position: relative;
			display: none;
		}
		.navcontainer_phone .logo{
			width: 35%;
			height: 100%;
			float: left;
			background: url(img/logo.png) no-repeat center center;
			background-size: 100%;
		}
		.navcontainer_phone .menu_phone{
			float: right;
			width: 50px;
			height: 35px;
			margin-top: 20px;
			background: url(img/menu-alt-512.png) no-repeat center center;
			background-size: contain;
			cursor: pointer;
		}
		.navigation_phone{
			width: 100%;
			height: 0;
			margin-top: 70px;
			background-color: #FFF;
			position: absolute;
			overflow: hidden;
			border: none;
			font-family: gidole-regular;
		}
		.navigation_phone li{
			float: left;
			width: 100%;
			height: 50px;
		}
		.navigation_phone a{
			float: left;
			line-height: 50px;
			width: 100%;
			height: 100%;
			text-align: center;
			text-decoration: none;
			color: rgba(0,0,0,.7);
		}
		.navigation_phone a:hover{
			background-color: #F0F0F0;
		}
		@media screen and (max-width: 1060px) {
			.navcontainer_phone{
				display: inline;
				border-top: 1px solid rgba(0,0,0,0.05);
			}
			.navcontainer{
				display: none;
			}
		}
		@media screen and (min-width: 800px)and (max-width: 1060px){
			.navcontainer_phone .logo{
				background-size: 70%;
			}
		}
	</style>
	<script>
		var menuShowMore = 1;
		$(document).ready(function() {
			$(".navigation_phone a").click(function () {
				$(".navigation_phone").attr("style", "height:0;");
				menuShowMore = 1;
			});
		});
		function menuShow(a){
			if (menuShowMore == 0){
				$(".navigation_phone").attr("style", "height:0;");
				menuShowMore = 1;
			} else if (menuShowMore == 1) {
				$(".navigation_phone").attr("style", "height:auto;");
				menuShowMore = 0;
			}
		}
	</script>
	<div class="navcontainer" hidden>
		<a href="index.php"><div class="logo"></div></a>
		<div class="navigation">
			<ul>
				<li><a href="index.php#about">About</a></li>
				<li><a href="index.php#opportunities">Opportunities</a></li>
				<li><a href="index.php#sectors">Sectors</a></li>
				<li><a href="index.php#key_points">Key Points</a></li>
				<li><a href="index.php#pricing">Pricing</a></li>
				<li><a href="index.php#key_people">Key People</a></li>
				<li><a href="index.php#contact">Contact</a></li>
			</ul>
		</div>
		<div class="connect">
			<?php if (logged_in()) {?>
			<a class="signup" href="logout.php">Logout</a>
			<a class="login" href="profile.php"><?php echo $f_name;?></a>
			<?php } else {?>
			<a class="signup" href="signup.php">Signup</a>
			<a class="login" href="login.php">Login</a>
			<?php } ?>
		</div>
	</div>
	<div class="nav_phone">
		<div class="navcontainer_phone">
			<a href="index"><div class="logo"></div></a>
			<div class="menu_phone" onclick="menuShow(1)"></div>
		</div>
		<div class="navigation_phone">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="index.php#about">About</a></li>
				<li><a href="index.php#opportunities">Opportunities</a></li>
				<li><a href="index.php#sectors">Sectors</a></li>
				<li><a href="index.php#key_points">Key Points</a></li>
				<li><a href="index.php#pricing">Pricing</a></li>
				<li><a href="index.php#key_people">Key People</a></li>
				<li><a href="index.php#contact">Contact</a></li>
				<?php if (logged_in()) {?>
				<li><a href="profile.php"><?php echo $f_name;?></a></li>
				<li><a href="logout.php">Logout</a></li>
				<?php } else {?>
				<li><a href="login.php">Login</a></li>
				<li><a href="signup.php">Signup</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
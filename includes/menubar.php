<style type="text/css">
	body{
		margin: 0;
		padding: 0;
		border: 0;
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
		position: fixed;
		z-index: 100;
		font-family: Century Gothic, sans-serif;
		font-size: .9em;
	}
	.navcontainer a{
		text-decoration: none;
	}
	.navcontainer i{
		font-size: 1.2em;
		line-height: 30px;
	}
	.navcontainer .logo{
		width: 25%;
		height: 100%;
		float: left;
		background: url(img/logo.png) no-repeat center center;
		background-size: 70%;
	}
	.navcontainer .navigation{
		width: 15%;
		height: 100%;
		float: left;
	}
	ul li{
		float: left;
	}
	.navcontainer li a{
		line-height: 80px;
		padding-left: 25px;
		font-size: 1.1em;
		color: #2B4093;
		transition: all .2s;
		text-decoration: none;
	}
	.navcontainer li a:hover{
		color: #4B6EFA;
	}
	.navcontainer .connect{
		height: 100%;
		padding-right: 5%;
		float: right;
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
		position: absolute;
		display: none;
		font-family: Century Gothic, sans-serif;
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
		z-index: 1000;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12);
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
		</ul>
	</div>
	<div class="connect">
		<a class="signup" href="logout.php">Logout</a>
		<a href="settings.php" style="color: #2B4093;"><i class="fa fa-cog"></i></a>
		<a href="mailbox.php" style="color: #2B4093;"><i class="fa fa-envelope"></i></a>
		<a href="profile.php" style="color: #2B4093;"><i class="fa fa-user"></i></a>
		<a href="main.php" style="color: #2B4093;"><i class="fa fa-home"></i></a>
		<?php if ($clearance == 9) {?>
		<a href="admin.php" style="color: #2B4093;">Admin panel</a>
		<?php } ?>
	</div>
</div>
<div class="nav_phone">
	<div class="navcontainer_phone">
		<a href="index.php"><div class="logo"></div></a>
		<div class="menu_phone" onclick="menuShow(1)"></div>
	</div>
	<div class="navigation_phone">
		<ul>
			<li><a href="index.php">Front page</a></li>
			<?php if ($clearance == 9) {?>
			<li><a href="admin.php">Admin panel</a></li>
			<?php } ?>
			<li><a href="main.php">Home</a></li>
			<li><a href="profile.php">Profile</a></li>
			<li><a href="mailbox.php">Mailbox</a></li>
			<li><a href="settings.php">Settings</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>
</div>
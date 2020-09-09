<style>
	/* Left navigation */
	#left_nav_container{
		float: left;
		width: 20%;
		height: 80%;
		margin: 20px .5%;
	}
	.left_nav_links_container{
		float: left;
	}
	.left_nav_link{
		float: left;
		width: 95%;
		padding: 10px 2.5%;
		margin: 1% 0;
		color: #616161;
		cursor: pointer;
		transition: all .1s;
	}
	.left_nav_link:hover{
		background: #E0E0E0;
	}
	.left_nav_link i{
		float: left;
		width: 20%;
		text-align: center;
	}
	.left_nav_link p{
		float: left;
		width: 77%;
		padding: 0 0 0 3%;
	}
	.nav_active{
		background: #E0E0E0 !important;
		color: #3969AC !important;
	}
</style>
<div id="left_nav_container">
	<div class="left_nav_links_container">
		<?php
			if ($clearance == 9) {
		?>
			<div class="left_nav_link <?php if($current_page == 'admin'){echo 'nav_active';};?>" onclick="location.href='admin.php'"><i class="fa fa-dashboard"></i><p>Admin Panel</p></div>
		<?php
			}
		?>
		<div class="left_nav_link <?php if($current_page == 'main'){echo 'nav_active';}?>" onclick="location.href='main.php'"><i class="fa fa-newspaper-o"></i><p>News Feed</p></div>
		<div class="left_nav_link <?php if($current_page == 'profile'){echo 'nav_active';}?>" onclick="location.href='profile.php'"><i class="fa fa-user"></i><p>Profile</p></div>
		<div class="left_nav_link <?php if($current_page == 'mail'){echo 'nav_active';}?>" onclick="location.href='mailbox.php'"><i class="fa fa-envelope"></i><p>Messages</p></div>
		<div class="left_nav_link <?php if($current_page == 'settings'){echo 'nav_active';}?>" onclick="location.href='settings.php'"><i class="fa fa-cog"></i><p>Settings</p></div>
	</div>
</div>
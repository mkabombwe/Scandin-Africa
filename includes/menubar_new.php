<style>
/* Menu top */
	#menubar_top{
		float: left;
		width: 100%;
		height: 78px;
		background: #FFF;
		box-shadow: 0 1px 3px rgba(0,0,0,.05);
		border-bottom: 1px solid rgba(0,0,0,.05);
	}
	#menubar_top_container{
		float: left;
		width: 95%;
		padding: 0 2.5%;
	}
	#menubar_top_left{
		float: left;
		width: 18.5%;
	}
	#menubar_top_logo_container{
		float: left;
		width: 100%;
	}
	#menubar_top_logo{
		float: left;
		width: 100%;
		height: 100%;
		float: left;
		background: url(img/logo.png) no-repeat center center;
		background-size: 80%;
	}
	#menubar_top_middle{
		float: left;
		width: 60%;
		height: 100%;
	}
	#menubar_top_right{
		float: left;
		width: 20%;
		cursor: pointer;
		font-family: Century Gothic, sans-serif;
		font-size: .8em;
	}
	#menubar_top_profile_container{
		float: left;
		width: 50%;
		height: 100%;
	}
	#menubar_top_profile_outter{
		float: right;
		width: 60px;
		height: 60px;
		margin-top: 10px;
		margin-right: 10%;
		overflow: hidden;
		border-radius: 50%;
		box-shadow: 0 1px 3px rgba(0,0,0,.12);
	}
	#menubar_top_profile_name{
		float: left;
		width: 50%;
		height: 100%;
	}
	#menubar_top_profile_name p{
		float: left;
		width: 75%;
		padding: 0 5%;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
		line-height: 80px;
	}
	#menubar_top_profile_name i{
		float: left;
		width: 15%;
		line-height: 70px;
		text-align: center;
	}
	#menu_top_more{
		width: 16%;
		margin-left: 3%;
		margin-top: 81px;
		background: #FFF;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
		position: absolute;
		z-index: 1;
		cursor: default;

	}
	.menu_top_more_box{
		cursor: pointer;
	}
	.menu_top_more_box i{
		float: left;
		width: 20%;
		padding: 15px 0;
		text-align: center;
	}
	.menu_top_more_box p{
		float: left;
		width: 70%;
		padding: 15px 10% 15px 0;
	}
</style>
<!-- Top menu -->
	<div id="menubar_top">
		<div id="menubar_top_container">
			<div id="menubar_top_left">
				<a href="index.php" id="menubar_top_logo_container">
					<div id="menubar_top_logo"></div>
				</a>
			</div>
			<div id="menubar_top_middle"></div>
			<div id="menubar_top_right">
				<div id="menu_top_nav_container" class="noselect">
					<div id="menubar_top_profile_container">
						<div id="menubar_top_profile_outter">
							<img src="<?php echo $top_profile_pic;?>" width="100%">
						</div>
					</div>
					<div id="menubar_top_profile_name">
						<p><?php echo $f_name;?></p>
						<i class="fa fa-sort-desc" aria-hidden="true"></i>
					</div>
				</div>
				<!-- Click menu -->
				<div id="menu_top_more" hidden>
					<div class="menu_top_more_box" onclick="window.location.href='premium.php';">
						<i class="fa fa-arrow-up" aria-hidden="true"></i>
						<p>Change plan</p>
					</div>
					<div class="menu_top_more_box" onclick="window.location.href='logout.php';">
						<i class="fa fa-power-off" aria-hidden="true"></i>
						<p>Sign out</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		i = 0;
		$('#menu_top_nav_container').click(function() {
			if (i == 0) {
				$('#menu_top_more').show();
				i = 1;
			} else {
				$('#menu_top_more').hide();
				i = 0;
			}
		});
	</script>
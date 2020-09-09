<?php
	require_once 'core/init.php';

	$current_page = "main";

	if (!logged_in()) {
		//If not loggend in
		header('Location: logout.php');
	}

	//Delete post
	if (isset($_POST['final_delete'])) {
		if($stmt = $mysqli->prepare("DELETE FROM posts WHERE post_id = ?")){
			$stmt->bind_param('i', $_POST['post_display_id']);
			$stmt->execute();
			$stmt->store_result();
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();
		}
	}
	if ($first_time == 0 || $clearance == 0) {
		header('Location: premium.php');
		if($stmt = $mysqli->prepare("UPDATE users SET first_time = 1 WHERE username = ?")){
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->store_result();
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();
		}
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style2_new.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="home_body">
	<div id="home_wrapper">
<?php
	// Get user_id
		if($stmt = $mysqli->prepare("SELECT user_id, profile_pic FROM users WHERE username = ?")){
			$stmt->bind_param('s', $session_user_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($user_id, $top_profile_pic);
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();
		}
		include("includes/menubar_new.php");
?>
		<div id="home_container_outter">
			<div id="home_container_inner">
				<?php include("includes/menu_left.php"); ?>
				<div id="home_posts_container">
<?php	
	// Preprare the posts first part
		$sql = "SELECT post_id, user_id, post_content, upload_time, clearance, post_title, post_section, post_price, country, likes, post_image FROM posts";

	// Filter the posts
		if (isset($_POST['filter_country'])) {
			$sql .= " WHERE country ='".$_POST['filter_country']."'";
			if (isset($_POST['filter_sector'])) {
				if ($_POST['filter_sector'] !== "Other") {
					$sql .= " AND post_section = '".$_POST['filter_sector']."'";
				} else {
					$sql .= " AND post_section NOT IN ('Oil and Gas',
													   'ICT',
													   'Agrobusiness and Fishery',
													   'Construction',
													   'Renewable Energy',
													   'Mines and Metal',
													   'Child Foundation',
													   'Health care and Life services',
													   'Training-Business',
													   'Other')";
				}
				if (isset($_POST['filter_price'])) {
					$sql .= " AND post_price ='".$_POST['filter_price']."'";
				}
			}
			if (isset($_POST['filter_price'])) {
				$sql .= " AND post_price ='".$_POST['filter_price']."'";
				if (isset($_POST['filter_sector'])) {
					if ($_POST['filter_sector'] !== "Other") {
						$sql .= " AND post_section = '".$_POST['filter_sector']."'";
					} else {
						$sql .= " AND post_section NOT IN ('Oil and Gas',
														   'ICT',
														   'Agrobusiness and Fishery',
														   'Construction',
														   'Renewable Energy',
														   'Mines and Metal',
														   'Child Foundation',
														   'Health care and Life services',
														   'Training-Business',
														   'Other')";
					}
				}
			}
		}

	//Filter post (if only price and sector is selected)
		if (isset($_POST['filter_price']) && !isset($_POST['filter_country'])) {
			$sql .= " WHERE post_price ='".$_POST['filter_price']."'";
			if (isset($_POST['filter_sector'])) {
				if ($_POST['filter_sector'] !== "Other") {
					$sql .= " AND post_section = '".$_POST['filter_sector']."'";
				} else {
					$sql .= " AND post_section NOT IN ('Oil and Gas',
													   'ICT',
													   'Agrobusiness and Fishery',
													   'Construction',
													   'Renewable Energy',
													   'Mines and Metal',
													   'Child Foundation',
													   'Health care and Life services',
													   'Training-Business',
													   'Other')";
				}
			}
		}
		
	//Filter post (if nothing but sector is selected)
		if (isset($_POST['filter_sector']) && !isset($_POST['filter_country']) && !isset($_POST['filter_price'])) {
			if ($_POST['filter_sector'] !== "Other") {
				$sql .= " WHERE post_section = '".$_POST['filter_sector']."'";
			} else {
				$sql .= " WHERE post_section NOT IN ('Oil and Gas',
													 'ICT',
													 'Agrobusiness and Fishery',
													 'Construction',
													 'Renewable Energy',
													 'Mines and Metal',
													 'Child Foundation',
													 'Health care and Life services',
													 'Training-Business',
													 'Other')";
			}
		}

	// prepare posts second part
		$sql.= " ORDER BY post_id";
		$result = $mysqli->query($sql);
		$post_id = array();
		$temp_user_id = array();
		$post_content = array();
		$upload_time = array();
		$post_clearence = array();
		$post_title = array();
		$post_section = array();
		$post_price = array();
		$post_country = array();
		$post_likes = array();
		$post_image = array();
		$a = 0;

		while ($row = $result->fetch_assoc()){
			$post_id[$a] = $row['post_id'];
			$temp_user_id[$a] = $row['user_id'];
			$post_content[$a] = $row['post_content'];
			$upload_time[$a] = $row['upload_time'];
			$post_clearence[$a] = $row['clearance'];
			$post_title[$a] = $row['post_title'];
			$post_section[$a] = $row['post_section'];
			$post_price[$a] = $row['post_price'];
			$post_country[$a] = $row['country'];
			$post_likes[$a] = $row['likes'];
			$post_images[$a] = $row['post_image'];
			$a++;
		}
		$result->close();
		


		for ($i = $a-1; $i >= 0; $i--) {
			$sql = "SELECT posts.post_id, posts.user_id, posts.post_content, posts.upload_time, users.username, users.profile_id, users.user_id, users.f_name, users.l_name, users.profile_pic, users.country FROM posts INNER JOIN users ON posts.user_id = users.user_id AND users.user_id = '".$temp_user_id[$i]."'";
			if($stmt = $mysqli->prepare($sql)){
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($main_post_id, $main_post_user_id, $main_post_content, $main_post_upload_time, $main_user_username, $main_user_profile_id, $main_user_user_id, $main_user_f_name, $main_user_l_name, $main_user_profile_pic, $main_user_country);
				$stmt->fetch();
			}

			if ($clearance == 0 || $clearance == 1) {
				//If user account is free
?>
					<div class="home_post" postID="<?php echo $post_id[$i];?>">
						<div class="post_top">
							<div class="post_top_left">
								<div class="post_img_container noclick">
									<img src="<?php echo $main_user_profile_pic; ?>" width="100%">
								</div>
							</div>
							<div class="post_top_right">
								<p class="post_name noclick"><?php echo htmlentities($main_user_f_name);?>&nbsp;<?php echo htmlentities($main_user_l_name);?></p>
								<p class="post_date noclick"><?php echo date('M j, Y', strtotime($upload_time[$i]));?></p>
							</div>
						</div>
						<div class="post_bottom">
							<div class="post_content">
								<p class="post_title"><?php echo htmlentities($post_title[$i]); ?></p>
							</div>
							<div class="post_content_image noselect">
								<?php
									if (!empty($post_images[$i])) {
										echo '<img src="'.$post_images[$i].'" width="100%" />';
									}
								?>
							</div>
							<div class="post_content">
								<p class="post_text noselect"><?php echo htmlentities($post_content[$i]); ?></p>
								<p class="post_section noselect">
									<?php echo htmlentities($post_section[$i]);?>&nbsp;&#183;&nbsp;
									<?php echo htmlentities($post_price[$i]);?>&nbsp;&#183;&nbsp;
									<?php echo htmlentities($post_country[$i]);?>
								</p>
							</div>
							<div class="post_reactions">
								<?php if ($main_user_profile_id == $profile_id && $main_user_user_id == $user_id && $main_user_username == $username) {?>
								<p class="settings" class="delete_post" id="<?php echo $i; ?>" style="float:right"><i class="fa fa-trash"></i></p>
								<div class="delete_post_confirm" id="delete_post_confirm_<?php echo $i;?>" hidden>
									<div class="delete_post_container">
										<form action="" method="post" enctype="multipart/form-data" id="delete_post_form">
											<input type="file" name="file" class="delete_profile" id="delete_profile" hidden>
											<p id="are_you_delete">Are you sure you want to delete this post?</p>
											<input class="submit_delete" type="submit" name="final_delete" id="final_delete" value="Yes" >
											<input type="hidden" name="post_display_id" value="<?php echo $post_id[$i]; ?>"/> 
											<p id="cancel_delete_<?php echo $i;?>" class="cancel_delete">Cancel</p>
										</form>
									</div>
								</div>
								<script>
									$("#<?php echo $i;?>").click(function() {
										$("#delete_post_confirm_<?php echo $i;?>").show();
									});
									$("#cancel_delete_<?php echo $i;?>").click(function() {
										$("#delete_post_confirm_<?php echo $i;?>").hide();
									});
								</script>
								<?php } else { ?>
								<p class="settings" style="float:right"><i class="fa fa-ellipsis-v"></i></p>
								<?php }?>
							</div>
						</div>
					</div>
<?php
			} else {
				//If user account is premium or higher

				//Likes and comments
				if($stmt = $mysqli->prepare('SELECT like_id FROM post_likes WHERE liker_id = ? AND post_id = ?')){
					$stmt->bind_param('ii', $user_id, $post_id[$i]);
					$stmt->execute();
					$result = $stmt->get_result();
					if (mysqli_num_rows($result) > 0) {
						$has_liked = 'yes';
					} else {
						$has_liked = 'no';
					}
					$result->free();
				}

				$sql = "SELECT comment_id, post_id, commenter_id, comment, comment_time FROM post_comments WHERE post_id = ".$post_id[$i]." ORDER BY post_id DESC";
				$result = $mysqli->query($sql);
				$comment_comment_id = array();
				$comment_post_id = array();
				$comment_commenter_id = array();
				$comment_comment = array();
				$comment_comment_time = array();
				$b = 0;
				while ($row = $result->fetch_assoc()){
					$comment_comment_id[$b] = $row['comment_id'];
					$comment_post_id[$b] = $row['post_id'];
					$comment_commenter_id[$b] = $row['commenter_id'];
					$comment_comment[$b] = $row['comment'];
					$comment_comment_time[$b] = $row['comment_time'];
					$b++;
				}
				$result->close();


?>

					<div class="home_post" id="post<?php echo $post_id[$i];?>">
						<div class="post_top">
							<div class="post_top_left">
								<div class="post_img_container" <?php echo 'onclick="window.location.href=\'profile.php?user='.$main_user_profile_id.'\';"' ?>>
									<img src="<?php echo $main_user_profile_pic; ?>" width="100%">
								</div>
							</div>
							<div class="post_top_right">
								<p class="post_name" <?php echo 'onclick="window.location.href=\'profile.php?user='.$main_user_profile_id.'\';"' ?>><?php echo htmlentities($main_user_f_name);?>&nbsp;<?php echo htmlentities($main_user_l_name);?></p>
								<p class="post_date"><?php echo date('M j, Y', strtotime($upload_time[$i]));?></p>
							</div>
						</div>
						<div class="post_bottom">
							<div class="post_content">
								<p class="post_title"><?php echo htmlentities($post_title[$i]); ?></p>
							</div>
							<div class="post_content_image">
								<?php
									if (!empty($post_images[$i])) {
										echo '<img src="'.$post_images[$i].'" width="100%" />';
									}
								?>
							</div>
							<div class="post_content" id="post_content<?php echo $post_id[$i];?>">
								<p class="post_text"><?php echo $post_content[$i]; ?></p>
								<p class="post_section">
									<?php echo htmlentities($post_section[$i]);?>&nbsp;&#183;&nbsp;
									<?php echo htmlentities($post_price[$i]);?>&nbsp;&#183;&nbsp;
									<?php echo htmlentities($post_country[$i]);?>
								</p>
							</div>
							<div class="post_reactions">
								<?php if ($has_liked == 'yes') {
										echo '<p id="like_'.$post_id[$i].'" class="like post_acted" liked="yes" likes="'.$post_likes[$i].'" postID="'.$post_id[$i].'" style="float:left"><e class="like_text">Unlike </e>'; 
										if ($post_likes[$i] > 0) {
											echo '('.$post_likes[$i].')';
										}
										echo '</p>';
									} else {
										echo '<p id="like_'.$post_id[$i].'" class="like" liked="no" postID="'.$post_id[$i].'" style="float:left"><e class="like_text">Like </e>'; 
										if ($post_likes[$i] > 0) {
											echo '('.$post_likes[$i].')';
										}
										echo '</p>';
									}

									if (count($comment_comment_id) > 0) {
										echo '<p id="comment_'.$post_id[$i].'">Comment ('.count($comment_comment_id).')</p>';
									} else {
										echo '<p id="comment_'.$post_id[$i].'">Comment</p>';
									}


								?>
								<?php if (($main_user_profile_id == $profile_id && $main_user_user_id == $user_id && $main_user_username == $username) || $clearance == 9) {?>
								<p class="settings" class="delete_post" id="<?php echo $i; ?>" style="float:right"><i class="fa fa-trash"></i></p>
								<div class="delete_post_confirm" id="delete_post_confirm_<?php echo $i;?>" hidden>
									<div class="delete_post_container">
										<form action="" method="post" enctype="multipart/form-data" id="delete_post_form">
											<input type="file" name="file" class="delete_profile" id="delete_profile" hidden>
											<p id="are_you_delete">Are you sure you want to delete this post?</p>
											<input class="submit_delete" type="submit" name="final_delete" id="final_delete" value="Yes" >
											<input type="hidden" name="post_display_id" value="<?php echo $post_id[$i]; ?>"/> 
											<p id="cancel_delete_<?php echo $i;?>" class="cancel_delete">Cancel</p>
										</form>
									</div>
								</div>
								<script>
									$("#<?php echo $i;?>").click(function() {
										$("#delete_post_confirm_<?php echo $i;?>").show();
									});
									$("#cancel_delete_<?php echo $i;?>").click(function() {
										$("#delete_post_confirm_<?php echo $i;?>").hide();
									});
									//Like
								</script>
								<?php } else { ?>
								<p class="settings" style="float:right"><i class="fa fa-ellipsis-v"></i></p>
								<?php }?>
							</div>
								<!-- Comments (user) -->
								<div class="post_user_comment_container">
									<div class="post_user_comment_left">
										<div class="post_user_comment_img_container">
											<img src="<?php echo $profile_pic;?>" width="100%">
										</div>
									</div>
									<div class="post_user_comment_right">
										<textarea placeholder="Comment..." id="textarea_<?php echo $post_id[$i];?>"></textarea>
										<div class="send_comment_button" id="send_comment_<?php echo $post_id[$i];?>">COMMENT</div>
									</div>
								</div>
								<!-- Comments (other) -->
								<?php
								for ($m=0; $m < count($comment_comment_id); $m++) { 
									if($stmt = $mysqli->prepare("SELECT profile_pic, profile_id FROM users WHERE user_id = ?")){
										$stmt->bind_param('s', $comment_commenter_id[$m]);
										$stmt->execute();
										$stmt->store_result();
										$stmt->bind_result($comment_commenter_pic, $comment_profile_id);
										$stmt->fetch();
										$stmt->free_result();
										$stmt->close();
									}
									echo '
									<div class="post_comments_container">
										<div class="post_comments_left" onclick="window.location.href=\'profile.php?user='.$comment_profile_id.'\';">
											<div class="post_comments_img_container">
												<img src="'.$comment_commenter_pic.'" width="100%">
											</div>
										</div>
										<div class="post_comments_right">
											<div class="post_comments_comment">
												<p>'.$comment_comment[$m].'</p>
											</div>
											<div class="post_comments_date">'.ago(strtotime($comment_comment_time[$m])).'</div>';
											if ($comment_commenter_id[$m] == $user_id || $clearance == 9) {
												echo '<div class="post_comments_delete" id="post_comments_delete_'.$comment_comment_id[$m].'" postID="'.$post_id[$i].'"><i class="fa fa-times"></i></div>';
											}

									echo '</div>
									</div>
									';
								}
								?>
						</div>
					</div>
<?php
		}
	}
?>
					</div>
				<div id="home_filters_container">
					<div id="post_filter" class="post">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="select_container">
								<p class="filter_undertitle">Country</p>
								<select name="filter_country">
									<option value="" disabled selected>Country</option>
									<?php
									foreach ($every_country as $key) {
										echo '
										<option value="'.$key.'">'.$key.'</option>
										';
									}?>
								</select>
							</div>
							<div class="select_container">
								<p class="filter_undertitle">Sector</p>
								<select name="filter_sector" id="filter_sector">
									<option value="" disabled selected>Sector</option>
									<?php
									foreach ($every_sector as $key) {
										echo '
										<option value="'.$key.'">'.$key.'</option>
										';
									}?>
								</select>
							</div>
							<div class="select_container">
								<p class="filter_undertitle">Price</p>
								<select name="filter_price" id="filter_price">
									<option value="" disabled selected>Price</option>
									<?php
									foreach ($every_price as $key) {
										echo '
										<option value="'.$key.'">'.$key.'</option>
										';
									}?>
								</select>
							</div>
							<div class="select_container">
								<input type="submit" value="Search" id="filter_submit">
								<a href="main.php"><input type="button" value="Reset" id="filter_reset"></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		<?php if ($clearance !== 0 || $clearance !== 1) {?>
			//Like a post
			$(".like").click(function() {
				var ID = $(this).attr('postID');
				var content = $(this);
				var likes = $(this).attr('likes');
				var LIKED = $(this).attr("liked");
				var URL = 'includes/post.php';
				var dataString = 'post_like_id=' + ID +'&liked='+ LIKED;
				$.ajax({
					type: "POST",
					url: URL,
					data: dataString,
					cache: false,
					success: function(html){
						if(LIKED == 'no'){
							//Show notification or somthing
							$(content).addClass('post_acted');
							$(content).find('.like_text').text('Unlike');
							$(content).attr('liked', 'yes');
							window.location.href = 'main.php#post_content'+ID;
							window.location.reload(true);

						} else {
							//Show notification or somthing
							$(content).removeClass('post_acted');
							$(content).find('.like_text').text('Like');
							$(content).attr('liked', 'no');
							window.location.href = 'main.php#post_content'+ID;
							window.location.reload(true);
						}
					}
				});
			});
			$(".send_comment_button").click(function() {
				var ID = $(this).attr('id');
				var split_comment = ID.split('send_comment_')[1];
				var content = $('#textarea_'+split_comment).val();
				var URL = 'includes/post.php';
				var dataString = 'post_comment_id=' + split_comment +'&message='+ content +'&action=make';
				$.ajax({
					type: "POST",
					url: URL,
					data: dataString,
					cache: false,
					success: function(html){
						window.location.href = 'main.php#post_content'+ID;
						window.location.reload(true);
					}
				});
			});
			$(".post_comments_delete").click(function() {
				var ID = $(this).attr('id');
				var ID2 = $(this).attr('postID');
				var split_comment = ID.split('post_comments_delete_')[1];
				var URL = 'includes/post.php';
				var dataString = 'post_id=' + ID2 +'&post_comment_comment_id='+ split_comment +'&action=delete';
				$.ajax({
					type: "POST",
					url: URL,
					data: dataString,
					cache: false,
					success: function(html){
						window.location.href = 'main.php#post_content'+ID;
						window.location.reload(true);
					}
				});
			});
		<?php } ?>
	</script>
</body>
</html>
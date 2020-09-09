<?php
require_once 'core/init.php';

$current_page = "profile";
$error1 = "";

if (!logged_in()) {
	//If not loggend in
	header('Location: logout.php');
} else {
		//Displays another users info
	if (isset($_GET['user']) === true && empty($_GET['user']) === false) {
		$stmt = $mysqli->prepare("SELECT user_id, username, f_name, l_name, companyname, profile_pic, cover_pic, position, country, bio, phone, clearance FROM users WHERE profile_id = ?");
		$lol = $_GET['user'];
		$stmt->bind_param('s', $lol);
		$stmt->execute();
		$stmt->bind_result($new_user_id, $new_username, $new_f_name, $new_l_name, $new_companyname, $new_profile_pic, $new_cover_pic, $new_position, $new_country, $new_bio, $new_phone, $clearance);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
	} else {
		//If not set, redirects user to own page
		header('Location: profile.php?user='.$profile_id);
	}

	if (isset($_POST['profile_photo'])) {
		//Upload profile picture
		move_uploaded_file($_FILES['file']['tmp_name'], "img/profile/" . $_FILES['file']['name']);
		try {
			$stmt = $mysqli->prepare("UPDATE users SET profile_pic = 'img/profile/".$_FILES['file']['name']."' WHERE username = ?");
			$lol = $session_user_id;
			$stmt->bind_param('s', $lol);
			$stmt->execute();
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();

			header('Location: profile.php');
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	if(isset($_POST['submit_post_text'])) {
		//Post submission
		if (!isset($_POST['post_section']) || !isset($_POST['post_price']) || !isset($_POST['post_country']) || !isset($_POST['post_you_are']) || !isset($_POST['post_duration'])) {
			$error1 = "Please fill all the fields";
		} else {
			$target_dir = 'img/post_images/';
			$target_file = $target_dir . basename($_FILES['image']['name']);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			
			move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

			$sql = "INSERT INTO posts (user_id, post_content, clearance, post_title, post_section, post_price, upload_time, country, post_image, you_are, post_duration) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("isissssssss", $v1, $v2, $v3, $v4, $v5, $v6, $v7, $v8, $v9, $v10, $v11);

			$v1 = $user_id;
			$v2 = nl2br(htmlentities($_POST['post_text']));
			$v3 = $clearance;
			$v4 = $_POST['post_title'];
			if ($_POST['post_section'] == "Other") {
				if ($_POST['post_section_other'] == "") {
					$v5 = "(Not defined)";
				} else {
					$v5 = $_POST['post_section_other'];
				}
			} else {
				$v5 = $_POST['post_section'];
			}
			$v6 = $_POST['post_price'];
			$v7 = date("Y-m-d H:i:s");
			$v8 = $_POST['post_country'];
			if (!empty($_FILES['image']['tmp_name'])) {
				$v9 = $target_file;
			} else {
				$v9 = '';
			}
			$v10 = $_POST['post_you_are'];
			$v11 = $_POST['post_duration'];
			$stmt->execute();
		}
	}

	//Delete post
	if (isset($_POST['final_delete'])) {
		if($stmt = $mysqli->prepare("DELETE FROM posts WHERE post_id = ? AND user_id = ?")){
			$stmt->bind_param('is', $_POST['post_display_id'], $user_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();
		}
	}

	if($stmt = $mysqli->prepare("SELECT user_id, profile_pic FROM users WHERE username = ?")){
		$stmt->bind_param('s', $session_user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user_id, $top_profile_pic);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/profile_new.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/mailbox/app.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="profile_body">
	<div id="profile_wrapper">
<?php include("includes/menubar_new.php"); ?>
		<div id="profile_container_outter">
			<div id="profile_container_inner">
				<div id="lightbox">
					<p>Click to close</p><br>
					<div id="content" class="mail_lightbox">
						<div id="new">
							<h2 style="margin:0 0 20px 0;">New message</h2>
							<form class ="form" method="post" action="#">
							  <div class="recever form-group">
								<p class="label"><label for="">Recipient</label></p>
								<p><input type="text" name="mrecever" class="mrecever form-control" value="<?php echo $new_username; ?>" placeholder="email address" readonly /></p>
								
							  </div>
							  <div class="object form-group">
								<p class="label"><label for="">Object</label></p>
								<p><input type="text" name="mobject" class="mobject form-control"/></p>
								 
							  </div>
							  <div class="message form-group">
							   <p class="label"><label for="">Message</label></p>
							   <p><textarea name="message" class="form-control"></textarea></p>
							  </div>
							  <div>
								 <input type="hidden" name="token" id="token" value="<?php echo crypt('hwyethdnsbcgdferyr874h43',md5('token-'.uniqid())); ?>" readonly />
								 <input type="hidden" name="mtoken" class="mtoken form-control" value="" readonly />
							  </div>
																
								<div class="form-group" class=''>
								  <p class="label"><label for="attachments[]">Attachments <i class="fa fa-paperclip"></i></label></p>
								  <input type="file" id="attachments" name="attachments[]" class="form-control" multiple>
								  <br />
								  <div id="attachments-list"></div>
								</div>
								<br><br>
							  <div>
							   <p><button id="send" name="send" class="btn submit" type="button">send</button></p>
							  </div>
							 </form>
						 </div>
					</div>
				</div>
				<?php include("includes/menu_left.php"); ?>
				<div id="wrapper">
					<div id="top_content">
						<!-- user pic -->
						<div id="top_content_left">
							<div id="top_image_container">
								<img src="<?php echo $new_profile_pic; ?>" width="100%">
							</div>
							<?php if ($_GET['user'] == $profile_id) {?>
							<div id="change_profile_button"><p>Change picture</p></div>
							<!-- change user -->
							<div id="change_profile" hidden>
								<div class="change_profile">
								<form action="" method="post" enctype="multipart/form-data" id="change_profile_form">
									<input type="file" name="file" class="press_profile" id="press_profile" hidden>
									<p id="are_you">Are you sure you want to change your profile picture?</p>
									<input class="submit_profile" type="submit" name="profile_photo" id="final_submit_photo">
									<p id="cancel_pic">Cancel</p>
								</form>
								</div>
							</div>
							<script>
							$("#change_profile_button").click(function() {
								$(".press_profile").click();
								$("#change_profile").show();
							});
							$("#cancel_pic").click(function() {
								$("#change_profile").hide();
							});
							</script>
							<?php } 
							if ($clearance == 0 || $clearance == 1) {?>
							<a href="premium.php"><div id="premium_badge1"><p>Discover</p></div></a>
							<?php } else if ($clearance == 2) {?>
							<a href="premium.php"><div id="premium_badge4"><p>Premium</p></div></a>
							<?php } else if ($clearance == 3) {?>
							<a href="premium.php"><div id="premium_badge2"><p>Advantage</p></div></a>
							<?php } else if ($clearance == 9){?>
							<a href="premium.php"><div id="premium_badge3"><p>Admin</p></div></a>
							<?php }?>
							<?php if ($_GET['user'] != $profile_id){
							echo '
								<a href="mailbox.php" class="mail_lightbox_trigger">
									<div id="premium_badge3">
										<p><i class="fa fa-enveloppe"></i> Send message</p>
									</div>
								</a>
							'; }?>
						</div>
						<!-- user info -->
						<div id="top_content_right">
							<div id="ajaxloader">Loading...</div>
							<p id="top_name" class="top"><?php echo htmlentities($new_f_name);?>&nbsp;<?php echo htmlentities($new_l_name);?></p>
							<div id="top_bio">
								<p><?php echo $new_bio;?></p>
							</div>
						</div>
					</div>
					<div id="right_container">
<?php if ($_GET['user'] == $profile_id) {?>
						<div class="post" id="post_upload">
							<div id="post_text_container">
								<p class="error"><?php echo $error1; ?></p>
								<form action="" method="post" enctype="multipart/form-data">
									<div id="post_text_container_top">
										<div id="post_title_container">
											<input type="text" name="post_title" placeholder="Title...">
										</div>
										<div id="post_you_are_container">
											<select name="post_you_are" id="post_you_are">
												<option value="" disabled selected>You are...</option>
												<option value="Project leader">Project leader</option>
												<option value="Investor">Investor</option>
											</select>
										</div>
										<div id="post_section_container">
											<select name="post_section" id="post_section">
												<option value="" disabled selected>Sector...</option>
												<?php 
													foreach ($every_sector as $key) {
														echo '
															<option value="'.$key.'">'.$key.'</option>
														';
													}
												?>
											</select>
										</div>
										<div id="post_section_other" hidden>
											<input class="post_input" type="text" name="post_section_other" placeholder="Sector name...">
											<script>
												$("#post_section").change(function(){
												    if($(this).val() == "Other") {
												       $("#post_section_other").slideDown("fast");
												    } else {
												    	$("#post_section_other").slideUp("fast");
												    }
												});
											</script>
										</div>
										<div id="post_price_container">
											<select name="post_price" id="post_price">
												<option value="" disabled selected>Price</option>
												<?php 
													foreach ($every_price as $key) {
														echo '
															<option value="'.$key.'">'.$key.'</option>
														';
													}
												?>
											</select>
										</div>
										<div id="post_country_container">
											<select name="post_country">
												<option value="" disabled selected>Country...</option>
												<?php 
													foreach ($every_country as $key) {
														echo '
															<option value="'.$key.'">'.$key.'</option>
														';
													}
												?>
											</select>
										</div>
										<div id="post_duration_container">
											<select name="post_duration" id="post_duration">
												<option value="" disabled selected>Project duration...</option>
												<option value=" 6 months">&#60; 6 months</option>
												<option value="6 - 12 months">6 - 12 months</option>
												<option value="1 - 2 years">1 - 2 years</option>
												<option value="> 2 years">&#62; 2 years</option>
											</select>
										</div>
										<textarea name="post_text" placeholder="About your project..."></textarea>
									</div>
									<div id="post_text_container_bottom">
										<input id="upload_pic" type="file" name="image" hidden>
										<div id="post_upload_picture"><i class="fa fa-camera"></i></div>
										<p id="submit_post_button">Upload</p>
										<input type="submit" value="Upload" id="submit_post" name="submit_post_text" hidden>
									</div>
								</form>
							</div>
						</div>
						<script>
							$('#post_upload_picture').click(function() {
								$('#upload_pic').click();
							});
							$('#submit_post_button').click(function() {
								$('#submit_post').click();
							});
							$('#upload_pic').change(function() {
								if ($('#upload_pic').val() !== "") {
									$('#post_upload_picture').css( "color", "#03A9F4" );
								}
							});
						</script>
<?php }
			//Load posts
			$sql = "SELECT post_id, user_id, post_content, upload_time, clearance, post_title, post_section, post_price, country, likes, post_image FROM posts WHERE user_id = '".$new_user_id."' ";
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
				if ($clearance == 0 || $clearance == 1) {
?>
						<div class="post">
							<div class="post_top">
								<div class="post_top_left">
									<div class="post_img_container">
										<img src="<?php echo $new_profile_pic; ?>" width="100%">
									</div>
								</div>
								<div class="post_top_right">
									<p class="post_name"><?php echo htmlentities($new_f_name);?>&nbsp;<?php echo htmlentities($new_l_name);?></p>
									<p class="post_date"><?php echo date('M j, Y', strtotime($upload_time[$i])); ?></p>

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
								<div class="post_content">
									<p class="post_text"><?php echo $post_content[$i]; ?></p>
									<p class="post_section">
										<?php echo htmlentities($post_section[$i]); ?>&nbsp;&#183;&nbsp;
										<?php echo htmlentities($post_price[$i]); ?>&nbsp;&#183;&nbsp;
										<?php echo htmlentities($post_country[$i]); ?>
									</p>
								</div>

								<div class="post_reactions">
									<?php if ($user_id == $new_user_id) {?>
									<p class="settings" class="delete_post" id="<?php echo $i; ?>" style="float:right"><i class="fa fa-trash"></i></p>
									<?php } else {?>
									<p class="settings" style="float:right"><i class="fa fa-ellipsis-v"></i></p>
									<?php }?>
									
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
								</div>
							</div>
						</div>
<?php
				} else {
					if($stmt = $mysqli->prepare('SELECT like_id FROM post_likes WHERE liker_id = ? AND post_id = ?')){
						$stmt->bind_param('ii', $user_id, $post_id[$i]);
						$stmt->execute();
						$result = $stmt->get_result();
						if (mysqli_num_rows($result) > 0) {
							$has_liked = 'yes';
						} else {
							$has_liked = 'no';
						}
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
						<div class="post">
							<div class="post_top">
								<div class="post_top_left">
									<div class="post_img_container">
										<img src="<?php echo $new_profile_pic; ?>" width="100%">
									</div>
								</div>
								<div class="post_top_right">
									<p class="post_name"><?php echo htmlentities($new_f_name);?>&nbsp;<?php echo htmlentities($new_l_name);?></p>
									<p class="post_date"><?php echo date('M j, Y', strtotime($upload_time[$i])); ?></p>

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
								<div class="post_content">
									<p class="post_text"><?php echo $post_content[$i]; ?></p>
									<p class="post_section">
										<?php echo htmlentities($post_section[$i]); ?>&nbsp;&#183;&nbsp;
										<?php echo htmlentities($post_price[$i]); ?>&nbsp;&#183;&nbsp;
										<?php echo htmlentities($post_country[$i]); ?>
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
									<?php if ($user_id == $new_user_id) {?>
									<p class="settings" class="delete_post" id="<?php echo $i; ?>" style="float:right"><i class="fa fa-trash"></i></p>
									<?php } else {?>
									<p class="settings" style="float:right"><i class="fa fa-ellipsis-v"></i></p>
									<?php }?>
									
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
												if ($comment_commenter_id[$m] == $user_id) {
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
				</div>
				<div id="side_tool_widget">
					<div class="side_tool_container">
						<p class="side_tool_title">About</p>
						<p class="side_tool_text"><e class="side_tool_marked"><?php echo htmlentities($new_position);?></e> at <e class="side_tool_marked"><?php echo htmlentities($new_companyname);?></e></p>
						<p class="side_tool_text">Located in <e class="side_tool_marked"><?php echo htmlentities($new_country);?></e></p>
						<p class="side_tool_text side_tool_mail">Mail: <e class="side_tool_marked"><?php echo htmlentities($new_username);?></e></p>
						<?php if (!empty($new_phone)) {echo '<p class="side_tool_text">Phone: <e class="side_tool_marked">'.$new_phone.'</e></p>';}?>
					</div>
					<?php
						$sql = "SELECT profile_id, f_name, l_name, companyname, profile_pic FROM users WHERE profile_id IN (SELECT person2 FROM connections WHERE person1 = '".$_GET['user']."' AND person1_accept = 1 AND person2_accept = 1) OR profile_id IN (SELECT person1 FROM connections WHERE person2 = '".$_GET['user']."' AND person1_accept = 1 AND person2_accept = 1)";
						if ($result = $mysqli->query($sql)) {
							while ($row = $result->fetch_assoc()) {
								$connections_user_id[] = $row['profile_id'];
								$connections_user_f_name[] = $row['f_name'];
								$connections_user_l_name[] = $row['l_name'];
								$connections_user_company[] = $row['companyname'];
								$connections_user_pic[] = $row['profile_pic'];
							}
							$result->free();
						}
						if (count($connections_user_id) >= 1) {
								echo '
								<div class="side_tool_container">
									<p class="side_tool_title">Connections</p>';
							for ($i=0; $i < count($connections_user_id); $i++) { 
								echo '
									<a class="connections_container" href="profile.php?user='.$connections_user_id[$i].'">
										<div class="connections_left">
											<img src="'.$connections_user_pic[$i].'" width="100%" />
										</div>
										<div class="connections_middle">
											<p class="connection_name">'.$connections_user_f_name[$i].' '.$connections_user_l_name[$i].'</p>
											<p class="connection_job">'.$connections_user_company[$i].'</p>
										</div>
										<div class="connections_right"></div>
									</a>
								';
							}	
								echo '</div>';
						}
					?>
				</div>
			</div>
		</div>	
	</div>
	<script type="text/javascript" src="js/mailbox/app.js"></script>
	<script type="text/javascript" src="js/mailbox/lightbox.js"></script>
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
<?php
}
?>
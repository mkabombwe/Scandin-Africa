<?php
require_once 'core/init.php';
require_once('mailbox/users.class.php');

$error1 = "";

if (!logged_in()) {
	header('Location: index.php');
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
		header('Location: mailbox.php?user='.$profile_id);
	}

	if (isset($_POST['profile_photo'])) {
		//Upload profile picture
		move_uploaded_file($_FILES['file']['tmp_name'], "img/profile/" . $_FILES['file']['name']);
		try {
			$stmt = $mysqli->prepare("UPDATE users SET profile_pic = 'img/profile/". $_FILES['file']['name']."' WHERE username = ?");
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
		if ($_POST['post_section'] == "" || $_POST['post_price'] == "" || $_POST['post_country'] == "" || empty($_POST['post_section']) || empty($_POST['post_price']) || empty($_POST['post_country'])) {
			$error1 = "Please your select section, price and project country";
		} else {
			$sql = "INSERT INTO posts (user_id, post_content, clearance, post_title, post_section, post_price, upload_time, country) VALUES (?,?,?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("isisssss", $v1, $v2, $v3, $v4, $v5, $v6, $v7, $v8);

			$v1 = $user_id;
			$v2 = $_POST['post_text'];
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
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa&nbsp;|&nbsp;Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/profile.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/mailbox/app.css">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script>
		function show_filter_menu(a){
			if(a == 1){
				$("#post_upload").slideUp("fast");
				$("#filter_menu").attr("onclick", "show_filter_menu(2)");
				$("#filter_menu").attr("style", "transform: rotate(180deg);");
			} else if(a == 2){
				$("#post_upload").slideDown("fast");
				$("#filter_menu").attr("onclick", "show_filter_menu(1)");
				$("#filter_menu").attr("style", "transform: rotate(0deg);");
			}
		}
	</script>
</head>
<body>
<?php include("includes/menubar.php"); ?>
<?php
		
?>
	<div id="top_container">
	</div>
	<div id="main_container">
	<div id="lightbox">
		<p>Click to close</p>
		<div id="content">
			<img src="#" />
		</div>
	</div>
		<div id="wrapper">
		<div id="top_content">
			<!-- user pic -->
			<div id="top_content_left">
				<h1 style="text-align:center;">Mailbox</h1>
				<img src="<?php echo $new_profile_pic; ?>" class="profilPicture" alt="">
				<div class="list-mailbox ibloc"></div>
			</div>
			<!-- user info -->
			<div id="top_content_right">
				<div id="ajaxloader">Loading...</div>
				<aside>
					<ul>
						<li class="frst"><a href="#new" id="newm"><i class="fa fa-edit"></i> New message</a></li>
						<li><a href="#mailbox" class="active"><i class="fa fa-envelope-o"></i> Mailbox</a></li>
						<li><a href="#sent"><i class="fa fa-send-o"></i> Sent</a></li>
						<li class="lst"><a href="#deleted"><i class="fa fa-close"></i> Deleted</a></li>
					</ul>
				</aside>
				<br class="clf">
				<div id="mailbox">
					<div class="block">
					   <a href='' style="display:none" class="delete-msg" title='Delete'>
						 <div class="line-block"><img src='img/delete.png' class='del-icone'> </div>
						 <div class="line-block">delete</div>
					  </a>
					 </div><br>
					<div class="preview-mailbox ibloc"></div>
				</div>
				<div id="new">
					<div id="new-layout">
					 <form class ="form" method="post" action="#">
					  <div class="recever form-group">
						<p class="label"><label for="">Recipient</label></p>
						<p><input type="text" name="mrecever" class="mrecever form-control" placeholder="email address" /></p>
						
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
					<br>
				</div>
				<div id="sent">
					 <h2 class="line-block">sent messages</h2>
					 <div class="line-block">
					   <a href='' style="display:none" class="delete-msg" title='Delete'>
						 <div class="line-block"><img src='img/delete.png' class='del-icone'> </div>
						 <div class="line-block">delete</div>
					  </a>
					 </div>
							<hr>
					<div class="list-sent ibloc"></div>
					<div class="preview-sent ibloc"></div>
				</div>
				<div id="deleted">
					<h2>Deleted messages</h2>
					<hr>
					<div class="list-deleted ibloc"></div>
					<div class="preview-delete ibloc"></div>
				</div>
				
			</div>
		</div>

	</div>
	</div>
	<script type="text/javascript" src="js/mailbox/app.js"></script>
	<script type="text/javascript" src="js/mailbox/lightbox.js"></script>
	<?php include("includes/footer.php"); ?>
</body>
</html>
<?php
}
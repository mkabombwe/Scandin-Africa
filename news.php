<?php
require_once 'core/init.php';

$sql = "SELECT id, title, content, img, link, uploadtime FROM news";
$result = $mysqli->query($sql);
$b = 0;
while ($row = $result->fetch_assoc()){
	$news_id[$b] = $row['id'];
	$news_title[$b] = $row['title'];
	$news_content[$b] = $row['content'];
	$news_img[$b] = $row['img'];
	$news_link[$b] = $row['link'];
	$news_uploadtime[$b] = $row['uploadtime'];
	$b++;
}
$result->close();

?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | News</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/news.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="header">
	<?php include("includes/navbar2.php"); ?>
	<div id="news_wrapper">
		<h1>News and annoucements</h1>

		<form action="" method="post" enctype="multipart/form-data">
		</form>


		<?php
			for ($i = (count($news_id)-1); $i>=0; $i--) {
				echo '
					<a class="news_box" href="'.$news_link[$i].'">
						<div class="news_img_container" style="background-image:url('.$news_img[$i].');">
						</div>
						<div class="news_text_container">
							<div class="news_text_top">
								<p class="news_text_top_date">'.ago(strtotime($news_uploadtime[$i])).'</p>
								<p class="news_text_top_title">'.$news_title[$i].'</p>
							</div>
							<p class="news_text">'.$news_content[$i].'</p>
						</div>
					</a>
				';
			}
		?>
	</div>

</body>
<?php
//if (logged_in() || $clearance == 9) {}
?>
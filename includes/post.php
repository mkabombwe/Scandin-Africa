<?php
require_once '../core/init.php';

############################## LIKE ##############################
	if(isset($_POST['post_like_id']) && isset($_POST['liked'])) {
		$post_id = $_POST['post_like_id'];
		$liked = $_POST['liked'];

		if ($liked == 'no') {
			if($stmt = $mysqli->prepare('SELECT like_id FROM post_likes WHERE liker_id = ? AND post_id = ?')){
					$stmt->bind_param('ii', $user_id, $post_id);
					$stmt->execute();
					$result = $stmt->get_result();

					if (mysqli_num_rows($result) == 0) {
						if($stmt1 = $mysqli->prepare("INSERT INTO post_likes (post_id, liker_id, like_time) VALUES (?,?,?)")){
							$stmt1->bind_param('iis', $post_id, $user_id, date('YmdHis', strtotime("now")));
							$stmt1->execute();
							$stmt1->free_result();
							$stmt1->close();
						}
						if($stmt2 = $mysqli->prepare("UPDATE posts SET likes=likes+1 WHERE post_id = ?")){
							$stmt2->bind_param('i', $post_id);
							$stmt2->execute();
							$stmt2->free_result();
							$stmt2->close();
						}
					} else {
						echo "lol";
					}

					$stmt->close();
			}
		} else {
			if($stmt = $mysqli->prepare('SELECT like_id FROM post_likes WHERE liker_id = ? AND post_id = ?')){
					$stmt->bind_param('ii', $user_id, $post_id);
					$stmt->execute();
					$result = $stmt->get_result();

					if (mysqli_num_rows($result) > 0) {
						if($stmt3 = $mysqli->prepare("DELETE FROM post_likes WHERE liker_id = ? AND post_id = ?")){
							$stmt3->bind_param('ii', $user_id, $post_id);
							$stmt3->execute();
							$stmt3->free_result();
							$stmt3->close();
						}
						if($stmt4 = $mysqli->prepare("UPDATE posts SET likes=likes-1 WHERE post_id = ?")){
							$stmt4->bind_param('i', $post_id);
							$stmt4->execute();
							$stmt4->free_result();
							$stmt4->close();
						}
					} else {
						echo "lol1";
					}

					$stmt->close();
			}
		}
	}
############################## COMMENT ##############################
	//Make comment
	if(isset($_POST['action'])) {
		$post_id = $_POST['post_comment_id'];
		$action = $_POST['action'];

		if ($action == 'make' && isset($_POST['message'])) {
			$message = $_POST['message'];
			if($stmt = $mysqli->prepare("INSERT INTO post_comments (post_id, commenter_id, comment, comment_time) VALUES (?,?,?,?)")){
				$stmt->bind_param('iiss', $post_id, $user_id, $message, date('YmdHis', strtotime("now")));
				$stmt->execute();
				$stmt->store_result();
				$stmt->fetch();
				$stmt->free_result();
				$stmt->close();
			}
			if($stmt2 = $mysqli->prepare("UPDATE posts SET comments=comments+1 WHERE post_id = ?")){
				$stmt2->bind_param('i', $post_id);
				$stmt2->execute();
				$stmt2->free_result();
				$stmt2->close();
			}
		} else if ($action == 'delete' && isset($_POST['post_comment_comment_id']) && isset($_POST['post_id'])) {
			$post_id = $_POST['post_id'];
			$post_comment_id = $_POST['post_comment_comment_id'];
			if($stmt = $mysqli->prepare("DELETE FROM post_comments WHERE comment_id = ?")){
				$stmt->bind_param('i', $post_comment_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->fetch();
				$stmt->free_result();
				$stmt->close();
			}
			if($stmt2 = $mysqli->prepare("UPDATE posts SET comments=comments-1 WHERE post_id = ?")){
				$stmt2->bind_param('i', $post_id);
				$stmt2->execute();
				$stmt2->free_result();
				$stmt2->close();
			}
		}
	}

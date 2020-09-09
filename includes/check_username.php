<?php

require_once '../core/init.php';

$username = $mysqli->real_escape_string($_POST['username']);

if($stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ?")){
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($user);
    $stmt->fetch();
    $stmt->free_result();
    $stmt->close();
}
if (!$user) {
    echo 0;
} else {
    echo 1;
}
?>


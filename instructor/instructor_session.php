<?php
require_once('../session.php');
if(!($session_usertype == 5)){
	$_SESSION['index_error'] ="You have been logged out due to illegal activity!";
	header('location:../index.php');
}
else if(!isset($_SESSION['user_id'])){
	$_SESSION['index_error'] ="You have been logged out due to inactivity!";
	header('location:../index.php');
}

?>
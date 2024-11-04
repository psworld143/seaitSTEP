<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['user_id'])){
	$user_id = $_POST['user_id'];
	$reset_query = mysqli_query($conn, "UPDATE step_users SET password='f8894d2c589ac837633c4ade8665980a' WHERE id ='$user_id'");
	if($reset_query){
		$_SESSION['success'] = "User password successfully reset!";
	}
	else{
		$_SESSION['error'] = "There is an error reseting user password!";
	}
}
header('location:../admin/manage_user.php');

?>
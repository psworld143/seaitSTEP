<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['user_id'])){
	$user_id = $_POST['user_id'];
	$delete_query = mysqli_query($conn, "DELETE FROM step_users WHERE id ='$user_id'");
	if($delete_query){
		$_SESSION['success'] = "User successfully deleted!";
	}
	else{
		$_SESSION['error'] = "There is an error deleting user!";
	}
}
header('location:../admin/manage_student.php');

?>
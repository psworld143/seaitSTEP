<?php
include('../dbconnection.php');
include('../session.php');
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$delete_query = mysqli_query($conn, "DELETE FROM departments WHERE id = '$id'");
	if($delete_query){
		$_SESSION['success'] = "Department deleted successfully!";
	}
	else{
		$_SESSION['success'] = "There is an error deleting Department!";
	}
}
header('location: ../admin/departments.php');

?>
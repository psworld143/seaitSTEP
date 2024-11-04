<?php
include('../dbconnection.php');
include('../session.php');
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$emp_id = $_POST['emp_id'];
	$delete_query = mysqli_query($conn, "DELETE FROM emp_report WHERE id = '$id'");
	if($delete_query){
		$_SESSION['success'] = "Report deleted successfully!";
	}
	else{
		$_SESSION['error'] = "There is an error deleting report!";
	}
}
header('location:../admin/profile.php?eid='.$emp_id.'');
?>
<?php
include('../dbconnection.php');
include('../session.php');
if(isset($_POST['status'])){
	$status = $_POST['status'];
	$emp_id =$_POST['emp_id'];
	$sql = "UPDATE basic_info SET status = '$status' WHERE id = '$emp_id'";
	$res = mysqli_query($conn, $sql);
	if($res){
		$_SESSION['success'] = "Employment status successfully updated!";
	}

}
header('location:../admin/profile.php?eid='.$emp_id.'');

?>
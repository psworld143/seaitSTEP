<?php
include('../dbconnection.php');
include('../session.php');
if(isset($_POST['emp_id'])){
	$emp_id = $_POST['emp_id'];
	$reportdate = $_POST['reportdate'];
	$details = $_POST['details'];
	$action = $_POST['action'];

	$sql_check = "SELECT * FROM emp_report WHERE date_of_report = '$reportdate' AND emp_id = '$emp_id'";
	$res_check = mysqli_query($conn, $sql_check);
	if(mysqli_num_rows($res_check ) > 0){
		$_SESSION['error'] = "Data exist in the database";
	}
	else{
		$sql_insert = "INSERT INTO emp_report(emp_id,date_of_report,details,action) VALUES($emp_id, '$reportdate','$details','$action')";
		$res_insert = mysqli_query($conn, $sql_insert);
		if($res_insert){
			$_SESSION['success'] = "Report Data successfully added!";
		}
		else{

		}
	}

}
header('location: ../admin/profile.php?eid='.$emp_id.'');


?>
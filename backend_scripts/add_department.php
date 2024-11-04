<?php
include('../dbconnection.php');
if(isset($_POST['dept_name'])){
	$dept_name = $_POST['dept_name'];
	$sql_check = "SELECT * FROM departments WHERE dept_name = '$dept_name'";
	$query_check = mysqli_query($conn, $sql_check);
	if(mysqli_num_rows($query_check) > 0){
		$_SESSION['error'] = "Department Name already exist!";
	}
	else{
		$sql_insert = "INSERT INTO departments(dept_name, added_by) VALUES('$dept_name', 1)";
		$res_insert = mysqli_query($conn, $sql_insert);
		if($res_insert){
			$_SESSION['success'] = "Department added successfully";
		}
	}
}
else{
	echo 'Please send Parameters';
}

header('location: ../admin/departments.php');

?>
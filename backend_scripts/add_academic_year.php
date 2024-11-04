<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['acad_year'])){
	$acad_year = $_POST['acad_year'];
	$semester = $_POST['semester'];
	$query = mysqli_query($conn, "SELECT * FROM academic_year WHERE acad_year = '$acad_year' AND semester = '$semester'");
	if(mysqli_num_rows($query) == 0){
		$sql_insert = mysqli_query($conn, "INSERT INTO academic_year(acad_year, semester,evaluation_status) VALUES('$acad_year','$semester',1)");
		if($sql_insert){
			$_SESSION['success'] = "Academic Year successfully added!";
		}
	}

}
header('location:../admin/academic_year.php');

?>
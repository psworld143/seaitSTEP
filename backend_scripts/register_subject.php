<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['subject_code'])){
	$subject_code = strtoupper($_POST['subject_code']);
	$desc_title = strtoupper($_POST['desc_title']);
	$check_query = mysqli_query($conn, "SELECT * FROM subjects WHERE code ='$subject_code' OR description = '$desc_title'");
	if(mysqli_num_rows($check_query) == 0){
		$insert_query = mysqli_query($conn, "INSERT INTO subjects(code,description) VALUES('$subject_code','$desc_title')");
		if($insert_query){
			$_SESSION['success'] = "Subject registered successfully!";
		}
	}

}

header('location: ../instructor/index.php');
?>
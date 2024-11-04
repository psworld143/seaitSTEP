<?php
include('../dbconnection.php');
session_start();
$sub_load_id ="";
if(isset($_POST['id'])){
	$sub_load_id = $_POST['sub_load_id'];
	$id = $_POST['id'];
	$query_remove = mysqli_query($conn, "DELETE FROM student_subjects WHERE id = '$id'");
	if($query_remove){
		$_SESSION['success'] = "Student removed from the class successfully!";
	}
	else{
		$_SESSION['error'] = "There is an error removing student!";
	}

}
header('location:../instructor/students.php?id='.$sub_load_id.'');
?>
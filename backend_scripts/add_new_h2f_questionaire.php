<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['description'])){
	$desc = str_replace("'", " i",$_POST['description']);
	$cat_id = $_POST['cat_id'];
	$query_check = mysqli_query($conn,"SELECT * FROM h2f_questionaires WHERE description = '$desc'");
	if(mysqli_num_rows($query_check) == 0 && $desc!=''){
		$query_insert = mysqli_query($conn, "INSERT INTO h2f_questionaires(cat_id, description) VALUES('$cat_id','$desc')");
		if($query_insert){
			$_SESSION['success'] = "Question added successfully!";
		}
	}

}
header('location:../staff/questionaires.php');

?>
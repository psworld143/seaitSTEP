<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['description'])){
	$desc = str_replace("'", " i",$_POST['description']);
	$cat_id = 0;

	$query_check = mysqli_query($conn,"SELECT * FROM h2f_questionaires WHERE description = '$desc'");
	if(mysqli_num_rows($query_check) == 0 && $desc!=''){
		$query_insert = mysqli_query($conn, "INSERT INTO h2f_questionaires(cat_id, description, added_by) VALUES('$cat_id','$desc', '".$_SESSION['user_id']."')");
		if($query_insert){
			$_SESSION['success'] = "Question added successfully!";
		}
	}

}
header('location:../heads/head_evaluation.php?id='.$_POST['teacher_id'].'');

?>
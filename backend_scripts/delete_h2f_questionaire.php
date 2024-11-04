<?php
include('../dbconnection.php');
include('../session.php');
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$delete_query = mysqli_query($conn, "DELETE FROM h2f_questionaires WHERE id = '$id'");
	if($delete_query){
		$_SESSION['success'] = "Question deleted successfully!";
	}
	else{
		$_SESSION['error'] = "There is an error deleting question!";
	}
}
header('location:../staff/questionaires.php');
?>
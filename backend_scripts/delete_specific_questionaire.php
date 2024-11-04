<?php
include('../dbconnection.php');
include('../session.php');
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$fid = $_GET['fid'];
	$delete_query = mysqli_query($conn, "DELETE FROM h2f_questionaires WHERE id = '$id'");
	if($delete_query){
		$_SESSION['success'] = "Question deleted successfully!";
	}
	else{
		$_SESSION['error'] = "There is an error deleting question!";
	}
}
header('location:../heads/head_evaluation.php?id=oA==');
?>
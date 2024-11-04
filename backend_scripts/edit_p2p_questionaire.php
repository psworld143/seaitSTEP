<?php
include('../dbconnection.php');
include('../session.php');
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$description = str_replace("'", " i",$_POST['description']);
	$update_query = mysqli_query($conn, "UPDATE p2p_questionaires SET description = '$description' WHERE id = '$id'");
	if($update_query){
		$_SESSION['success'] = "Question updated successfully!";
	}
	else{
		$_SESSION['success'] = "There is an error updating question!";
	}
}
header('location:../admin/p2p_questionaires.php');
?>
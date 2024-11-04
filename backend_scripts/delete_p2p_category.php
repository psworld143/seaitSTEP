<?php

include('../dbconnection.php');
include('../session.php');
if(isset($_POST['category_id'])){
	$cat_id = $_POST['category_id'];
	$res_delete = mysqli_query($conn, "DELETE FROM p2p_category WHERE id = '$cat_id'");
	
	if($res_delete){
		$_SESSION['success'] = "Category deleted successfully!";
	}
	
}
header('location:../admin/p2p_categories.php');
?>
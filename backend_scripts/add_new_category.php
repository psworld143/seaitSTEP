<?php
session_start();
include('../dbconnection.php');
if(isset($_POST['category_name'])){
	$cat_name = $_POST['category_name'];
	$res_check = mysqli_query($conn, "SELECT * FROM category WHERE cat_name = '$cat_name'");
	if(mysqli_num_rows($res_check) == 0 && $cat_name != ''){
		$res_insert = mysqli_query($conn, "INSERT INTO category(cat_name) VALUES('$cat_name')");
		if($res_insert){
			$_SESSION['success'] = "New Category inserted successfully!";
		}
	}
	else{

	}
}
header('location:../admin/categories.php');
?>
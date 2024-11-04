<?php
include('../session.php');
session_start();
 if(isset($_POST['id'])){
 	$id = $_POST['id'];
 	unset($_SESSION['acad_year']);
 	
 	$_SESSION['acad_year'] = $id;
 }
 header('location:../staff/employees.php');
?>
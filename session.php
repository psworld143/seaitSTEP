
<?php
session_start();
include('dbconnection.php');

if(isset($_SESSION['acad_year'])){
	$academic_year = $_SESSION['acad_year'];

}
else{
	
  	$_SESSION['index_error'] ="You have been logged out due to inactivity!";
  	header('location:../index.php');
}



if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
}
else{
	
  	$_SESSION['index_error'] ="You have been logged out due to inactivity!";
  	header('location:../index.php');
}


if(isset($_SESSION['dept_id'])){
	$dept_id = $_SESSION['dept_id'];
}
else{

  	$_SESSION['index_error'] ="You have been logged out due to inactivity!";
  	header('location:../index.php');
}

if(isset($_SESSION['usertype'])){
	$session_usertype = $_SESSION['usertype'];
}
else{

  	$_SESSION['index_error'] ="You have been logged out due to inactivity!";
  	header('location:../index.php');
}


?>








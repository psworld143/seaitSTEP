<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['email'])){
    
    $_SESSION['password'] = $_POST['password'];

	$academic_year_query=mysqli_query($conn, "SELECT * FROM academic_year ORDER BY id DESC LIMIT 1");
	$acad_data = mysqli_fetch_assoc($academic_year_query);
	$_SESSION['acad_year'] = $acad_data['id'];


	$email = mysqli_real_escape_string($conn, trim($_POST['email']));
	$password = mysqli_real_escape_string($conn, trim($_POST['password']));
	$pass = md5($password);
	$_SESSION['dept_id'] = 0;
	$login_query = mysqli_query($conn, "SELECT * FROM step_users WHERE email = '$email' AND password = '$pass'");
	if(mysqli_num_rows($login_query) > 0){
	    
		$users_row = mysqli_fetch_assoc($login_query);
		$fullname = $users_row['firstname'].' '.$users_row['lastname'];
		$usertype = $users_row['usertype'];


		$_SESSION['fullname'] = $fullname;
		$_SESSION['user_id'] = $users_row['id'];
		$_SESSION['dept_id'] = $users_row['dept'];

		if($usertype == 1){
			$_SESSION['usertype'] = 1;
			header('location:../admin/departments.php');
			
		}
		else if($usertype == 2){
			$_SESSION['usertype'] = 2;
			header('location:../staff/departments.php');
			
		}
		else if($usertype == 4){
			$_SESSION['dept_id'] = $users_row['dept'];
			$_SESSION['usertype'] = 3;
			header('location:../heads/employees.php');
			
			
		}
		else{
			$_SESSION['usertype'] = 4;
			header('location:../student/index.php');
			
		}
		
		

	}
	else{
		$instructor_query = mysqli_query($conn, "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id WHERE email = '$email' AND password ='$pass'");
		if(mysqli_num_rows($instructor_query) > 0){
			$instructor_row = mysqli_fetch_assoc($instructor_query);
			$fullname = $instructor_row['firstname'].' '.$instructor_row['lastname'];
			$_SESSION['dept_id'] = $instructor_row['department'];

			$_SESSION['fullname'] = $fullname;
			$_SESSION['user_id'] = $instructor_row['id'];
			$_SESSION['usertype'] = 5;
			header('location:../instructor/index.php');
			
		}
		else{
			header('location:../index.php');
			$_SESSION['index_error'] = "Invalid username or password!";
		}
	}
}

?>
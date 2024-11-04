<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['email'])){

	$usertype = $_POST['usertype'];
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$password1 = trim($_POST['password1']);
	$school_id  = $_POST['school_id'];
	$lastname = trim($_POST['lastname']);
	$firstname = trim($_POST['firstname']);
	$pass = md5($password);

	if($password != $password1){
		$_SESSION['index_error'] = "Password doesn't match!";
	}
	else if($usertype == 3){
		//Student
		$check_query_student = mysqli_query($conn, "SELECT * FROM step_users WHERE (email='$email' OR school_id = '$school_id') OR (lastname = '$lastname' AND firstname='$firstname')");
		if(mysqli_num_rows($check_query_student) == 0){
			$insert_student_query = mysqli_query($conn, "INSERT INTO step_users(email,password,school_id,lastname,firstname,usertype) VALUES('$email','$pass','$school_id','$lastname','$firstname','$usertype')");
			if($insert_student_query){
				$_SESSION['index_success'] = "You have successfully registered";
			}
			else{
				$_SESSION['index_error'] = "There is an error during registration";

			}
		}
		else{
			$_SESSION['index_error'] = "User details exist on the database!";
		}
	}
	else if($usertype == 1){
		//Admin
		$check_query_student = mysqli_query($conn, "SELECT * FROM step_users WHERE lastname = '$lastname' AND firstname='$firstname'");
		if(mysqli_num_rows($check_query_student) > 0){
			$admin_row = mysqli_fetch_assoc($check_query_student);
			$admin_id = $admin_row['id'];
			$insert_student_query = mysqli_query($conn, "UPDATE step_users SET email = '$email',password='$pass',school_id='$school_id',lastname='$lastname',firstname='$firstname' WHERE id='$admin_id'");
			if($insert_student_query){
				$_SESSION['index_success'] = "You have successfully registered";
			}
			else{
				$_SESSION['index_error'] = "There is an error during registration";
			}
		}
		else{
			$_SESSION['index_error'] = "User details does not exists in the database!";

		}
	}
	else if($usertype == 2){
		$check_if_signed_up_query = mysqli_query($conn, "SELECT * FROM basic_info WHERE lastname = '$lastname' AND firstname = '$firstname' ");
		if(mysqli_num_rows($check_if_signed_up_query) > 0){
			$check_data = mysqli_fetch_assoc($check_if_signed_up_query);
			$s_id = $check_data['school_id'];
			$id = $check_data['id'];
			if($s_id == ''){
				$insert_query = mysqli_query($conn, "UPDATE basic_info SET school_id = '$school_id', email = '$email', password = '$pass' WHERE id = '$id'");
				if($insert_query){
					$_SESSION['index_success'] = "You have successfully registered";
				}
				else{
					$_SESSION['index_error'] = "There is an error during registration";
				}
			}
			else{
				$_SESSION['index_error'] = "You have an existinng account, please login to continue. ";
			}
		}
		else{
			$_SESSION['index_error'] = "Invalid details provided, You can not use this platform.";
		}
	}
	else{
		$_SESSION['index_error'] = "Please select usertype";

	}
}
else{
	echo 'No Parameters';
}

header('location:../signup.php');
?>
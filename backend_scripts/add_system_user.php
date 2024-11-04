<?php
include('../dbconnection.php');
session_start();
if(isset($_POST['usertype'])){
	$usertype = $_POST['usertype'];
	$email = 'seait@seait-edu.ph';
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	//Check for Lastname
	$check_query = mysqli_query($conn, "SELECT * FROM step_users WHERE lastname = '$lastname' AND firstname = '$firstname' ");
	if(mysqli_num_rows($check_query) == 0 ){

		if ($usertype== 1) {
		//Guidance

			$email = $_POST['email'];
			$password = $_POST['password'];
			$password1 = $_POST['password1'];
			$pass = md5($password);
			if($username == ''){
				$_SESSION['error'] = 'Username is empty!';
			}
			else if($password != $password1 ){
				$_SESSION['error'] = 'There is an error in password provided!';
			}
			else{
				$sql_insert_admin = mysqli_query($conn, "INSERT INTO step_users(email,password,lastname,firstname,usertype) VALUES('$email','$pass','$lastname','$firstname','$usertype')");
				if($sql_insert_admin){
					$_SESSION['success'] = "Guidance Office user successfully added!";
				}
				else{
					$_SESSION['error'] = 'There is an error adding guidance office user!';
				}

			}


		}
		else if($usertype== 2){
		//Admin Department
		    $email = $_POST['email'];
		    $passABC = md5("Seait123");
			$insert_admin_query = mysqli_query($conn, "INSERT INTO step_users(lastname,firstname,usertype,email,password) VALUES('$lastname','$firstname','$usertype','$email','$passABC')");
			if($insert_admin_query){
				$_SESSION['success'] = "Admin Department user successfully added!";
			}
			else{
				$_SESSION['error'] = 'There is an error adding admin office user!';
			}


		}
		else if($usertype== 4){
		//Department Head
		    $email = $_POST['email'];
			$dept = $_POST['department'];
			$passABC = md5("Seait123");
			$insert_dept_head = mysqli_query($conn, "INSERT INTO step_users(lastname,firstname,usertype,dept,email,password) VALUES('$lastname','$firstname','$usertype','$dept','$email','$passABC')");
			if($insert_dept_head){
				$_SESSION['success'] = "user successfully added!";
			}
			else{
				$_SESSION['error'] = 'There is an error adding admin office user!';
			}

		}
		else{

		}
	}
	else{
		$_SESSION['error'] = 'User with the same Lastname and Password exists in the database!';
	}

}
else{
	$_SESSION['error'] = 'Please select Usertype first';
}
header('location: ../admin/manage_user.php');


?>
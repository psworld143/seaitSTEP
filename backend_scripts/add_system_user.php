<?php
include('../dbconnection.php');
session_start();

// Ensure the connection is valid
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['usertype'])) {
	$usertype = $_POST['usertype'];
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = 'seait@seait-edu.ph';  // Default email (for some users)

	// Check if the user already exists by lastname and firstname
	$check_query = mysqli_query($conn, "SELECT * FROM step_users WHERE lastname = '$lastname' AND firstname = '$firstname'");
	if (mysqli_num_rows($check_query) == 0) {

		// For Guidance Office User (usertype == 1)
		if ($usertype == 1) {
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$password1 = mysqli_real_escape_string($conn, $_POST['password1']);
			$pass = md5($password);

			if ($password != $password1) {
				$_SESSION['error'] = 'Passwords do not match!';
			} else {
				$sql_insert_user = mysqli_query($conn, "INSERT INTO step_users(email, password, lastname, firstname, usertype) 
                                                        VALUES('$email', '$pass', '$lastname', '$firstname', '$usertype')");
				if ($sql_insert_user) {
					// Add a notification after successfully adding the user
					$notification_message = "A new user '{$firstname} {$lastname}' has been added to the Guidance Office.";
					$notification_message = mysqli_real_escape_string($conn, $notification_message);
					$notification_query = mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification_message')");

					if ($notification_query) {
						$_SESSION['success'] = "Guidance Office user successfully added and notification created!";
					} else {
						$_SESSION['error'] = "User added, but notification failed!";
					}
				} else {
					$_SESSION['error'] = 'There is an error adding the Guidance Office user!';
				}
			}

			// For Admin Department User (usertype == 2)
		} else if ($usertype == 2) {
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$passABC = md5("Seait123");

			$sql_insert_admin = mysqli_query($conn, "INSERT INTO step_users(email, password, lastname, firstname, usertype) 
                                                    VALUES('$email', '$passABC', '$lastname', '$firstname', '$usertype')");
			if ($sql_insert_admin) {
				// Add a notification after successfully adding the user
				$notification_message = "A new user '{$firstname} {$lastname}' has been added to the Admin Department.";
				$notification_message = mysqli_real_escape_string($conn, $notification_message);
				$notification_query = mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification_message')");

				if ($notification_query) {
					$_SESSION['success'] = "Admin Department user successfully added and notification created!";
				} else {
					$_SESSION['error'] = "User added, but notification failed!";
				}
			} else {
				$_SESSION['error'] = 'There is an error adding Admin Department user!';
			}

			// For Department Head User (usertype == 4)
		} else if ($usertype == 4) {
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$dept = mysqli_real_escape_string($conn, $_POST['department']);
			$passABC = md5("Seait123");

			$insert_dept_head = mysqli_query($conn, "INSERT INTO step_users(lastname, firstname, usertype, dept, email, password) 
                                                    VALUES('$lastname', '$firstname', '$usertype', '$dept', '$email', '$passABC')");
			if ($insert_dept_head) {
				// Add a notification after successfully adding the user
				$notification_message = "A new Department Head user '{$firstname} {$lastname}' has been added.";
				$notification_message = mysqli_real_escape_string($conn, $notification_message);
				$notification_query = mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$notification_message')");

				if ($notification_query) {
					$_SESSION['success'] = "Department Head user successfully added and notification created!";
				} else {
					$_SESSION['error'] = "User added, but notification failed!";
				}
			} else {
				$_SESSION['error'] = 'There is an error adding Department Head user!';
			}
		} else {
			$_SESSION['error'] = 'Invalid user type selected!';
		}
	} else {
		$_SESSION['error'] = 'User with the same Lastname and Firstname already exists!';
	}
} else {
	$_SESSION['error'] = 'Please select a User Type first';
}

header('location: ../admin/manage_user.php');

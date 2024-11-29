<?php
include('../dbconnection.php');
session_start();

// Function to insert user data into the database
function insertUser($conn, $email, $lastname, $firstname, $school_id, $usertype, $dept)
{
    $department = $_POST['dept_id'];
    $defaultPassword = md5('Seait123'); // Hash the default password
    $sql = "INSERT INTO step_users (email, password, school_id, lastname, firstname, usertype, dept) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssd", $email, $defaultPassword, $school_id, $lastname, $firstname, $usertype, $dept);

    if ($stmt->execute()) {
        return true; // Success
    } else {
        return false; // Failure
    }
}

// Function to insert a notification
function insertNotification($conn, $message)
{
    $message = mysqli_real_escape_string($conn, $message);
    $notification_query = mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('$message')");
    return $notification_query;
}

// Check if CSV file is uploaded
if (isset($_FILES['csv_file'])) {
    if ($_FILES['csv_file']['error'] == UPLOAD_ERR_OK) {
        // Get the temporary file path
        $tmpFilePath = $_FILES['csv_file']['tmp_name'];

        // Open the CSV file for reading
        $handle = fopen($tmpFilePath, 'r');

        // Check if file opened successfully
        if ($handle !== false) {
            // Skip the first row (header row)
            $isHeader = true;

            // Loop through each row in the CSV file
            while (($data = fgetcsv($handle, 1000, ",")) !== false) { // Adjust delimiter if necessary
                if ($isHeader) {
                    $isHeader = false;
                    continue; // Skip the header row
                }

                // Extract data from CSV row
                $email = $data[0];
                $school_id = $data[1]; // Adjusted index for school_id
                $lastname = $data[2];
                $firstname = $data[3];
                $usertype = 3; // Hardcoded usertype as 3 (student)
                $dept = $_POST['dept_id'];

                // Debug data
                error_log("Email: $email, School ID: $school_id, Lastname: $lastname, Firstname: $firstname, Usertype: $usertype, Dept: $dept");

                // Check if user already exists
                $check_query = mysqli_query($conn, "SELECT * FROM step_users WHERE lastname = '$lastname' AND firstname = '$firstname'");
                if ($check_query !== false) {
                    if (mysqli_num_rows($check_query) == 0) {
                        // Insert user into the database
                        if (insertUser($conn, $email, $lastname, $firstname, $school_id, $usertype, $dept)) {
                            $_SESSION['success'] = 'User successfully added!';
                            // Create notification
                            $notification_message = "A new student '{$firstname} {$lastname}' has been added to the system.";
                            if (insertNotification($conn, $notification_message)) {
                                $_SESSION['success'] .= " Notification successfully created.";
                            } else {
                                $_SESSION['error'] = 'User added, but notification failed!';
                            }
                        } else {
                            $_SESSION['error'] = 'Failed to add user to the database!';
                        }
                    } else {
                        $_SESSION['error'] = 'User with the same Lastname and Firstname exists in the database!';
                    }
                } else {
                    $_SESSION['error'] = 'Error querying database!';
                }
            }

            // Close the CSV file
            fclose($handle);
        } else {
            $_SESSION['error'] = 'Error opening CSV file!';
        }
    } else {
        $_SESSION['error'] = 'Error uploading CSV file: ' . $_FILES['csv_file']['error'];
    }
} else {
    $_SESSION['error'] = 'No CSV file uploaded!';
}

// Redirect back to the manage_student.php page
header('location: ../admin/manage_student.php');

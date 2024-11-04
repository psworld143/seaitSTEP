<?php
include('../dbconnection.php');
session_start();

// Function to insert user data into the database
function insertUser($conn, $email, $password, $lastname, $firstname, $school_id, $usertype, $dept)
{   $department = $_POST['dept_id'];
    $pass = md5($password); // Hash the password
    $sql = "INSERT INTO step_users (email, password, lastname, firstname, school_id, usertype, dept) VALUES (?, ?, ?,?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssdd", $email, $pass, $lastname, $firstname,$school_id, $usertype, $department);

    if ($stmt->execute()) {
        return true; // Success
    } else {
        return false; // Failure
    }
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
            // Loop through each row in the CSV file
            while (($data = fgetcsv($handle, 1000, ",")) !== false) { // Use comma (",") as delimiter
                // Extract data from CSV row
                $email = $data[0];
                $password = $data[1];                
                $firstname = $data[2];
                $lastname = $data[3];
                $school_id = $data[4];
                $usertype = (float)$data[5]; // Convert to float
                $dept = $_POST['dept_id'];//isset($data[6]) ? (float)$data[6] : null; // Convert to float if not null

                // Check if user already exists
                $check_query = mysqli_query($conn, "SELECT * FROM step_users WHERE lastname = '$lastname' AND firstname = '$firstname'");
                if ($check_query !== false) {
                    if (mysqli_num_rows($check_query) == 0) {
                        // Insert user into the database
                        if (insertUser($conn, $email, $password, $lastname, $firstname,$school_id, $usertype, $dept)) {
                            $_SESSION['success'] = 'User successfully added!';
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
?>

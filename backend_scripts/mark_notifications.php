<?php
include('../dbconnection.php');

// Update the status of all unread notifications to 'read'
$update_query = mysqli_query($conn, "UPDATE notifications SET status = 'read' WHERE status = 'unread'");

header('Location: ../admin/manage_user.php');

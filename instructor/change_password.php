<?php
session_start();
include('../dbconnection.php');
$id = $_POST['id'];
$pass = md5($_POST['new_pass']);
$pass1 = $_POST['new_pass'];
$pass2 = $_POST['new_pass1'];
if($pass1 == $pass2){
    $sql_query = mysqli_query($conn, "UPDATE basic_info SET password = '$pass' WHERE id ='$id' ");
    if($sql_query){
        $_SESSION['success'] = "Password changed successfully!";
    }
    else{
        $_SESSION['error'] = "There is an error changing password!";
    }
}
else{
    $_SESSION['error'] = "Password does not match!";
    
}



?>
<script>
    window.location.href="index.php";
</script>
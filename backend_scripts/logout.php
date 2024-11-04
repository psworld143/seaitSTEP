<?php
unset($_SESSION['success']);
unset($_SESSION['error']);
session_destroy();
header('location:../index.php');

?>
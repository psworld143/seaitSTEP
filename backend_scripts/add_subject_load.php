<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include('../dbconnection.php');
include('../session.php');
//session_start();
if(isset($_POST['subject'])){
	$subject = $_POST['subject'];
	$year_block = $_POST['year_block'];
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $join_code = '';
    for ($i = 0; $i < 6; $i++)
        $join_code .= $characters[mt_rand(0, 61)];

	$check_query = mysqli_query($conn, "SELECT * FROM subject_loads WHERE acad_year='$academic_year' AND teacher='$user_id' AND subject='$subject' AND year_block ='$year_block'");
	if(mysqli_num_rows($check_query) == 0){
		$insert_query = mysqli_query($conn, "INSERT INTO subject_loads(acad_year,teacher,subject,year_block,join_code) VALUES('$academic_year','$user_id','$subject','$year_block','".strtoupper($join_code)."')");
		if($insert_query){
			$_SESSION['success'] = 'Subject load added successfully!';
		}
	}

}
echo '
    <script>
        window.location.href="../instructor/index.php";
    </script>

';
//header('location:');
?>
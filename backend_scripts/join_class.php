<?php
include('../dbconnection.php');
include('../session.php');
if(isset($_POST['code'])){
	$code = $_POST['code'];
	$get_code_query = mysqli_query($conn, "SELECT * FROM subject_loads WHERE join_code = '$code'");
	if(mysqli_num_rows($get_code_query) > 0){
		$subject_load_data = mysqli_fetch_assoc($get_code_query); 
		$subject_load_id = $subject_load_data['id'];

		$check_query = mysqli_query($conn, "SELECT * FROM student_subjects WHERE subject_load_id = '$subject_load_id' AND acad_year = '$academic_year' AND student_id='$user_id'");
		if(mysqli_num_rows($check_query) == 0){
			$join_query = mysqli_query($conn, "INSERT INTO student_subjects(student_id,subject_load_id,acad_year) VALUES('$user_id','$subject_load_id','$academic_year')");
			if($join_query ){
				$_SESSION['success'] = "Subject Instructor Added successfully!";
			}
			else{
				$_SESSION['error']="There is an error adding Subject Instructor";
			}

		}
		else{
			$_SESSION['error']="You have already added this Subject Instructor!";
			
		}
	}
	else{
		$_SESSION['error']="Invalid Code provided!";
		
	}
}
else{
	
}
//header('location:../student/index.php');
?>
<script>
    window.location.href = '../student/index.php';
</script>
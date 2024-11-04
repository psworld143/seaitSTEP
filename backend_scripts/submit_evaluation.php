<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
include('../dbconnection.php');
include('../session.php');
$data = array();
if(isset($_POST['teacher_id'])){
	$comment = str_replace("'", " i", $_POST['comment']);
	$teacher_id = $_POST['teacher_id'];
	$subject_id = $_POST['subject_id'];
	$subject_load_id = $_POST['subject_load_id'];
	$acad_id = $academic_year;
	$evaluator_id = $user_id;

	$sql_get_id = mysqli_query($conn, "SELECT id FROM questionaires ORDER BY id ASC");
	while($row_id = mysqli_fetch_assoc($sql_get_id)){
		$question_id = $row_id['id'];
		$score =  ''.$_POST['q'.$question_id.''].'';

		$eval_check_query = mysqli_query($conn, "SELECT * FROM student_evaluation WHERE acad_year = '$acad_id' AND question_id = '$question_id' AND student_id = '$evaluator_id' AND subject_load_id ='$subject_load_id'");
		if(mysqli_num_rows($eval_check_query) == 0){
			$eval_insert_query = mysqli_query($conn, "INSERT INTO student_evaluation(acad_year,question_id,score,comment,subject_id,student_id,subject_load_id,teacher_id) VALUES('$acad_id','$question_id','$score','$comment','$subject_id','$evaluator_id','$subject_load_id','$teacher_id')");
			if($eval_insert_query){
				$_SESSION['success'] = "Thank you for your response!";
			}

		}
		else{
			$eval_update_query = mysqli_query($conn, "UPDATE student_evaluation SET score = '$score', comment ='$comment' WHERE acad_year = '$acad_id' AND question_id = '$question_id' AND student_id = '$evaluator_id' AND subject_load_id ='$subject_load_id'");
			if($eval_update_query){
				$_SESSION['success'] = "Thank you for your response!";
			}

		}
		
		
	}


}


?>
<script>
    window.location.href = '../student/index.php';
</script>
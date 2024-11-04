<?php
include('../dbconnection.php');
include('../session.php');
$data = array();
if(isset($_POST['teacher_id'])){
	$comment_course = str_replace("'", " i", $_POST['comment_course']);
	$comment_instructor = str_replace("'", " i", $_POST['comment_instructor']);
	$teacher_id = $_POST['teacher_id'];
	$subject_id = $_POST['subject_id'];
	$acad_id = $academic_year;
	$evaluator_id = $user_id;

	$sql_get_id = mysqli_query($conn, "SELECT id FROM p2p_questionaires ORDER BY id ASC");
	while($row_id = mysqli_fetch_assoc($sql_get_id)){
		$question_id = $row_id['id'];
		$score =  ''.$_POST['q'.$question_id.''].'';

		$eval_check_query = mysqli_query($conn, "SELECT * FROM p2p_evaluation WHERE acad_year = '$acad_id' AND question_id = '$question_id' AND evaluator_id = '$evaluator_id' AND subject_id = '$subject_id'");
		if(mysqli_num_rows($eval_check_query) == 0){
			$eval_insert_query = mysqli_query($conn, "INSERT INTO p2p_evaluation(acad_year,question_id,score,comment_course,comment_instructor,evaluator_id,teacher_id, subject_id) VALUES('$acad_id','$question_id','$score','$comment_course','$comment_instructor','$evaluator_id','$teacher_id','$subject_id')");
			if($eval_insert_query){
				$_SESSION['success'] = "Thank you for your response!";
			}

		}
		else{
			$eval_uopdate_query = mysqli_query($conn, "UPDATE p2p_evaluation SET score='$score', comment_instructor = '$comment_instructor' WHERE acad_year = '$acad_id' AND question_id = '$question_id' AND evaluator_id = '$evaluator_id' AND subject_id = '$subject_id'");
			if($eval_update_query){
				$_SESSION['success'] = "Thank you for your response!";
			}

		}
		
		
	}


}



?>
<script>
    window.location.href="../instructor/peertopeer.php";
</script>
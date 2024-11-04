<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

include('../dbconnection.php');
include('../session.php');
if(isset($_POST['emp_id'])){
	$emp_id = $_POST['emp_id'];
	$lastname = $_POST['lastname'];
	$firstname = $_POST['firstname'];
	$middlename = $_POST['middlename'];
	$birthdate = 'A'; //$_POST['birthdate'];
	$photo = $_FILES['photo'];

	$email = 'seait@seait-edu.ph'; //$_POST['email'];
	$mobilenumber = 'A'; //$_POST['mobilenumber'];
	$address = 'A'; //$_POST['address'];
	$address2 = 'A'; //$_POST['address2'];
	$municipality = 'A'; //$_POST['municipality'];
	$province = 'A'; //$_POST['province'];
	$zipcode = '123'; //$_POST['zipcode'];

	$dateofhire = 'A'; //$_POST['dateofhire'];
	$position = 'Faculty'; //$_POST['position'];
	$department = $_POST['department'];

	$sss = 'A'; //$_POST['sss'];
	$phic = 'A'; //$_POST['phic'];
	$hdmf = 'A'; //$_POST['hdmf'];
	$password = md5('Seait123');
	//Insert Basic Informations
	$sql_basic_info_check = "SELECT * FROM basic_info WHERE lastname = '$lastname' AND middlename = '$middlename' AND firstname = '$firstname'";
	$sql_basic_info_res_check = mysqli_query($conn, $sql_basic_info_check);
	if(mysqli_num_rows($sql_basic_info_res_check) > 0){
		$_SESSION['error'] = "Employee already exist";
	}
	else{
		//Upload Photo
		if(strtolower(end(explode(".", $_FILES["photo"]["name"]))) =="mp4"){
		}else{
			$image = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
			$image_name = addslashes($_FILES['photo']['name']);
			$image_size = getimagesize($_FILES['photo']['tmp_name']);
			move_uploaded_file($_FILES["photo"]["tmp_name"], "../emp_photos/".md5($emp_id).'-' . $_FILES["photo"]["name"]);
			$location = "emp_photos/".md5($emp_id).'-' . $_FILES["photo"]["name"];
	
		}
		

		$sql_basic_info = "INSERT INTO basic_info(id,lastname,firstname,middlename,birthdate,photo_location,password, email) VALUES($emp_id,'$lastname','$firstname','$middlename','$birthdate','$location','$password','$email')";
		$res_basic_info = mysqli_query($conn, $sql_basic_info);
	//Insert Contact Informations
		$sql_contact_information = "INSERT INTO contact_information(id,email,mobile_number,address1,address2,municipality,province,zipcode) VALUES($emp_id,'$email','$mobilenumber','$address','$address2','$municipality','$province','$zipcode')";
		$res_contact_information = mysqli_query($conn, $sql_contact_information);
	//Insert Employment Informations
		$sql_emp_info = "INSERT INTO employment_informations(id,date_of_hire,position,department) VALUES($emp_id,'$dateofhire','$position','$department')";
		$res_emp_info = mysqli_query($conn, $sql_emp_info);
	//Insert identifications
		$sql_ids = "INSERT INTO identifications(id,sss,phic,hdmf) VALUES($emp_id, '$sss','$phic','$hdmf')";
		$res_ids = mysqli_query($conn, $sql_ids);



		$_SESSION['success'] = "Employee added successfully!";

	}

}
else{
	$_SESSION['success'] =  "Please send Parameters";
	echo 'No POST Object recieved';
}


?>
<script>
    window.location.href ='../admin/view_instructors.php?dept_id=<?php echo $department ;?>';
</script>
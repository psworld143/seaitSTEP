<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(true);
include('../dbconnection.php');
include('../session.php');
include('staff_session.php');
$simple_string = $_GET['eid'];
                                                                    
// Store the cipher method
$ciphering = "AES-256-CTR";
                                                                       
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
                                                                       
// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
                                                                       
// Store the encryption key
$encryption_key = "Seait123";
                                                                       
// Use openssl_encrypt() function to encrypt the data
$encrypted_id = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);

                                                                       
// Non-NULL Initialization Vector for decryption
$decryption_iv = '1234567891011121';
                                                                       
// Store the decryption key
$decryption_key = "Seait123";
                                                                       
// Use openssl_decrypt() function to decrypt the data
$decrypted_id =openssl_decrypt ($simple_string, $ciphering, $decryption_key, $options, $decryption_iv);
$eid = $decrypted_id;
//$eid = $_GET['eid'];
$dataPoints = array();
$dataPointsPie = array();
$tot_eval = 0;
$acad_year_profile = $_SESSION['acad_year'];
$tot_sub = 0; 

//Getting Evaluation Summary

$rating = 1;
$rating_sym = 'N/A';
$acad_year_query = mysqli_query($conn, "SELECT * FROM academic_year ORDER BY id ASC");
while($acad_year_row = mysqli_fetch_assoc($acad_year_query)){
  $total_score = 0;
  $tot_eval = 0;
  $acad_year_id = $acad_year_row['id'];
  $acad_desc = $acad_year_row['acad_year'];
  $semester = $acad_year_row['semester'];
  $sem_shoretened = '';
  if($semester == 'First Semester'){
    $sem_shoretened = '1st Sem';
  }
  else{
    $sem_shoretened = '2nd Sem';
  }

  $acad_label = $acad_desc.' '.$sem_shoretened;
  //get total questionaires
  $total_questionaires = 0;
  $total_questionaires_query = mysqli_query($conn, "SELECT COUNT(*) AS total_questions FROM questionaires");
  if(mysqli_num_rows($total_questionaires_query) > 0){
    $row_quest = mysqli_fetch_assoc($total_questionaires_query);
    $total_questions = $row_quest['total_questions'];
  }
  //End total questions
  //Get Total Evaluators
  $total_eval_query = mysqli_query($conn, "SELECT * FROM student_evaluation WHERE teacher_id = '$eid' AND acad_year = '$acad_year_id' GROUP BY student_id");
  if(mysqli_num_rows($total_eval_query) > 0){
    $total_evaluators = mysqli_num_rows($total_eval_query);
    $tot_eval = $total_evaluators;
    
    $total_score_query = mysqli_query($conn, "SELECT SUM(score) AS total_score FROM student_evaluation WHERE teacher_id = '$eid' AND acad_year = '$acad_year_id'");
    if(mysqli_num_rows($total_score_query) > 0){
      $total_score_row = mysqli_fetch_assoc($total_score_query);
      $total_score = $total_score_row['total_score'];
      //Get Total Subjects
      $total_sub_query = mysqli_query($conn, "SELECT * FROM student_evaluation WHERE teacher_id = '$eid' AND acad_year = '$acad_year_id' GROUP BY subject_load_id");
      $total_subject = mysqli_num_rows($total_sub_query);
      $tot_sub = $total_subject;
      //End total Subjects
      //End of getting score
      //Getting the Mean
      if($total_score != '' || $total_score != 'NULL'){

        $rating = (($total_score/$total_questions) / $total_evaluators) / $tot_sub;

        if($rating > 0 && $rating < 2){
          $rating_sym = 'Unsatisfactory';
        }
        else if($rating > 1 && $rating < 3){
          $rating_sym = 'Satisfactory';
        }
        else if($rating > 2 && $rating < 4){
          $rating_sym = 'Very Satisfactory';              
        }
        else if($rating > 3 && $rating < 5){
          $rating_sym = 'Outstanding';
                                                
        }
        
      }
      

    }
  }
  else{
    $rating_sym = 'Not Applicable';
    $rating = 1.0;
  }
  
  //End total evaluators
  //Get Total Scores
    
  array_push($dataPoints , array("y"=> round($rating, 0), "symbol" =>$rating_sym, "label"=>$acad_label));
  
}
//End of Getting Evaluation Summary
//Getting Employee Profile
        
$sql = "SELECT *, YEAR(CURRENT_TIMESTAMP) - YEAR(birthdate) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(birthdate, 5)) as age  FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id LEFT JOIN identifications ON identifications.id = basic_info.id  WHERE basic_info.id = '$eid'";
$query = mysqli_query($conn, $sql);
$rows = mysqli_fetch_assoc($query);
//End of getting EMployee Profile



//Fetching Rating per Questionaire

$questionaire_query = mysqli_query($conn, "SELECT * FROM questionaires ORDER BY id ASC");
$quesNo = 0;
while($questionaire_row = mysqli_fetch_assoc($questionaire_query)){
  $quesNo += 1;
  $queNoLabel = "Q-". $quesNo;
  $question = $questionaire_row['description'];
  $quesID = $questionaire_row['id'];
  //Get total Score
  $total_score_questionaire  =0;
  $total_score_questionaire_query = mysqli_query($conn, "SELECT SUM(score) AS question_score FROM student_evaluation WHERE question_id = '$quesID' AND acad_year = '$acad_year_profile' AND teacher_id = '$eid'");
  if(mysqli_num_rows($total_score_questionaire_query) > 0){
    $total_score_questionaire_row = mysqli_fetch_assoc($total_score_questionaire_query);
    $total_score_questionaire = $total_score_questionaire_row['question_score'];

  }
  //End get total scores
  //Get total evaluator
  $total_questionaire_eval_query = mysqli_query($conn, "SELECT * FROM student_evaluation WHERE question_id = '$quesID' AND teacher_id ='$eid' AND acad_year = '$acad_year_profile' GROUP BY student_id");
  $tot_ques_eval = mysqli_num_rows($total_questionaire_eval_query);
  //End of getting evaluators
  $rating_ques = '';
  if($tot_ques_eval > 0){
    $rating_per_ques = ($total_score_questionaire / $tot_ques_eval)/$tot_sub ;
    if($rating_per_ques > 0 && $rating_per_ques < 2){
      $rating_ques = 'Unsatisfactory';
    }
    else if($rating_per_ques > 1 && $rating_per_ques < 3){
      $rating_ques = 'Satisfactory';
    }
    else if($rating_per_ques > 2 && $rating_per_ques < 4){
      $rating_ques = 'Very Satisfactory';              
    }
    else if($rating_per_ques > 3 && $rating_per_ques < 5){
      $rating_ques = 'Outstanding';
                                            
    }
  }
  else{
    //$rating_per_ques = "No rating";

  }

  array_push($dataPointsPie , array("y"=> round($rating_per_ques, 3), "name" =>$question, "queNo"=>$queNoLabel, "ratingLabel"=>$rating_ques, "label"=>"-"));

}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title><?php echo $rows['lastname'].', '.$rows['firstname']; ?></title>
  <style>
    #loader {
      transition: all 0.3s ease-in-out;
      opacity: 1;
      visibility: visible;
      position: fixed;
      height: 100vh;
      width: 100%;
      background: #fff;
      z-index: 90000;
    }

    #loader.fadeOut {
      opacity: 0;
      visibility: hidden;
    }



    .spinner {
      width: 40px;
      height: 40px;
      position: absolute;
      top: calc(50% - 20px);
      left: calc(50% - 20px);
      background-color: #333;
      border-radius: 100%;
      -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
      animation: sk-scaleout 1.0s infinite ease-in-out;
    }

    @-webkit-keyframes sk-scaleout {
      0% { -webkit-transform: scale(0) }
      100% {
        -webkit-transform: scale(1.0);
        opacity: 0;
      }
    }

    @keyframes sk-scaleout {
      0% {
        -webkit-transform: scale(0);
        transform: scale(0);
      } 100% {
        -webkit-transform: scale(1.0);
        transform: scale(1.0);
        opacity: 0;
      }
    }
    .emp_image{
      width: 100px;
      height: 100px;
      border-radius: 100%;
      margin-bottom: 2%;
    }
    td{
      text-align: left;
    }
  </style>
  <script defer="defer" src="../assets/main.js"></script></head>
  <script src="../assets/canvas.min.js"></script>
  <body class="app">
    <div id="loader">
      <div class="spinner"></div>
    </div>

    <script>
      window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
          loader.classList.add('fadeOut');
        }, 300);
      });
    </script>

    
    
    <div>

      <?php 
      include('sidebar.php'); 
      ?>


      <div class="page-container">
        <!-- ### $Topbar ### -->
        <?php include('../navbar.php'); ?>
        

        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="row gap-20 masonry pos-r">
              <div class="masonry-sizer col-md-6"></div>
              <div class="masonry-item col-md-6">
                <div class="bgc-white p-20 bd">
                  <img src="../<?php echo $rows['photo_location']; ?>" class="emp_image">
                  <h6 class="c-grey-900">Basic Information</h6>
                  <div class="mT-30">

                    <table class="table table-striped">

                      <tbody>
                        <tr>

                          <td>Lastname</td>
                          <th scope="row"><?php echo $rows['lastname']; ?></th>               
                        </tr>
                        <tr>   
                          <td>Firstname</td>
                          <th scope="row"><?php echo $rows['firstname']; ?></th>
                        </tr>
                        <tr>
                          <td>Middlename</td>
                          <th scope="row"><?php echo $rows['middlename']; ?></th>
                        </tr>
                        <?php
                        $birthDate = $rows['birthdate'];
                        $birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $birthDate))))));
                        $today= new DateTime(date("Y-m-d"));           
                        $age = $birthdate->diff($today)->y +1;

                        
                        ?>
                        <tr>
                          <td>Age</td>
                          <th scope="row"><?php echo $age; ?></th>
                        </tr>
                        <tr>
                          <td>Birthdate</td>
                          <th scope="row"><?php echo $rows['birthdate']; ?></th>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Contact Information</h6>
                  <div class="mT-30">
                    <table class="table table-striped">

                      <tbody>
                        <tr>

                          <td>Phone Number</td>
                          <th scope="row"><?php echo $rows['mobile_number']; ?></th>               
                        </tr>
                        <tr>   
                          <td>Email Address</td>
                          <th scope="row"><?php echo $rows['email']; ?></th>
                        </tr>
                        <tr>
                          <td>City</td>
                          <th scope="row"><?php echo $rows['address1'].', '.$rows['address2']; ?></th>
                        </tr>
                        <tr>
                          <td>Municipality</td>
                          <th scope="row"><?php echo $rows['municipality']; ?></th>
                        </tr>
                        <tr>
                          <td>Provice</td>
                          <th scope="row"><?php echo $rows['province']; ?></th>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Identification Numbers</h6>
                  <div class="mT-30">
                    <table class="table table-striped">

                      <tbody>
                        <tr>

                          <td>Social Security System</td>
                          <th scope="row"><?php echo $rows['sss']; ?></th>               
                        </tr>
                        <tr>   
                          <td>PhilHealt</td>
                          <th scope="row"><?php echo $rows['phic']; ?></th>
                        </tr>
                        <tr>
                          <td>Pag-Ibig</td>
                          <th scope="row"><?php echo $rows['hdmf']; ?></th>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>


              <div class="masonry-item col-md-6">
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Employment Informations</h6>
                  <div class="mT-30">
                    <table class="table table-striped">

                      <tbody>
                        <tr>

                          <td>Status</td>
                          <th scope="row">
                            <?php
                            if($rows['status'] == 1){
                              echo 'Probationary';
                            }
                            else if($rows['status'] == 2){
                              echo 'Contractual';
                            }
                            else if($rows['status'] == 3){
                              echo 'Part Time';
                            }
                            else if($rows['status'] == 4){
                              echo 'Regular';
                            }
                            else if($rows['status'] == 5){
                              echo 'Resigned';
                            }

                            ?>
                            
                            <span style="width: 4px;"></span>
                            <button type="button" class="btn btn-info btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Update Status</button>
                          </th>               
                        </tr>
                        <tr>   
                          <td>Date of Hire</td>
                          <th scope="row"><?php echo $rows['date_of_hire']; ?></th>

                        </tr>
                        <tr>
                          <td>Position</td>
                          <th scope="row"><?php echo $rows['position']; ?></th>
                        </tr>
                        <tr>
                          <td>Department</td>
                          <th scope="row"><?php echo $rows['dept_name']; ?></th>
                        </tr>
                      </tbody>
                    </table>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="../backend_scripts/update_emp_status.php" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Update Employee Status</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                             <div class="mb-3 col-lg-6">
                              <label class="form-label" for="inputState">Change Status</label>
                              <input type="hidden" name="emp_id" value="<?php echo $_GET['eid']; ?>">
                              <select id="inputState" name="status" class="form-control" required>
                                <option selected="selected" value="">Choose...</option>
                                <option value="1">Probationary</option>
                                <option value="2">Contractual</option>
                                <option value="3">Part Time</option>
                                <option value="4">Regular</option>
                                <option value="5">Resigned</option>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-color btn-sm">Save changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>




                </div>
              </div>
            </div>

            <div class="masonry-item col-md-6">
              
              <div class="bgc-white p-20 bd">
                <h6 class="c-grey-900">Employee Sanctions</h6>
                <button type="button" class="btn btn-info btn-sm btn-color" data-bs-toggle="modal" data-bs-target="#addSanctionModal">Add Report</button>
                <div class="mT-30">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">

                        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Action Taken</th>
                              <th>View</th>
                              
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Date</th>
                              <th>Action Taken</th>
                              <th>Option</th>
                             
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php
                              $sql_report = "SELECT * FROM emp_report WHERE emp_id = ".$eid."";
                              $res_report = mysqli_query($conn, $sql_report);
                              while($rows_report = mysqli_fetch_assoc($res_report)){
                                $reportdate = $rows_report['date_of_report'];
                                $report_id = $rows_report['id'];
                                $action = $rows_report['action'];
                                $details = $rows_report['details'];
                                echo '
                                  <tr>
                                    <td>'.$reportdate.'</td>
                                    <td>'.$action.'</td>
                                    <td> <button type="button" class="btn btn-sm btn-info btn-color" data-bs-toggle="popover" title="Report Details" 
                                    data-bs-content="'.$details.'">View Details</button>

                                    <button type="button" class="btn cur-p btn-danger btn-sm btn-color" data-bs-toggle="modal" data-bs-target="#delete'.$report_id.'"><i class="ti-trash"></i> Delete</button>
                                          <div class="modal fade" id="delete'.$report_id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Delete Report</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="../backend_scripts/delete_report.php" method="POST">
                                                    <div class="mb-3">   
                                                      Are you sure? you want to delete this report?
                                                      <input type="hidden" name="id" value="'.$report_id.'">
                                                      <input type="hidden" name="emp_id" value="'.$_GET['eid'].'">
                                                    </div>  
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Cancel</button>
                                                  <button type="submit" class="btn btn-danger btn-color btn-sm">Delete</button>
                                                </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                    </td>
                                  </tr>
                                ';

                              }
                            ?>

                            

                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>


                </div>
                <div class="modal fade" id="addSanctionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="../backend_scripts/add_emp_report.php" method="POST">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Sanction</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="emp_id" value="<?php echo $_GET['eid']; ?>">
                          <label class="form-label fw-500">Incident Date</label>
                          <!--Date Picker-->
                          <div class="timepicker-input input-icon mb-3">
                            <div class="input-group">
                              <div class="input-group-text bgc-white bd bdwR-0">
                                <i class="ti-calendar"></i>
                              </div>
                              <input type="text" name="reportdate" class="form-control bdc-grey-200 start-date" placeholder="Date of Report" data-provide="datepicker" required>
                            </div>
                          </div>
                         
                          <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" name="details" id="floatingTextarea2" style="height: 100px" required></textarea>
                            <label for="floatingTextarea2">Details of Report</label>
                          </div>
                          <br>
                          <div class="mb-3 col-md-12">
                          <label class="form-label" for="inputState">Action Taken</label>
                          <select id="inputState" name="action" class="form-control" required>
                            <option selected="selected" value="">Choose...</option>
                            <option value="Suspension">Suspension</option>
                            <option value="Resign">For to Resign</option>
                          </select>
                        </div>



                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary btn-color btn-sm">Add Sanction</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="masonry-item col-md-6">
              <div class="bgc-white p-20 bd">
                <center><h6 class="c-grey-900">Student Evaluation Summary</h6>
                  <p>1-Unsatisfactory 2-Satisfactory 3-Very Satisfactory 4-Outstanding</p>
                </center>

                  <div  id="chartContainer" style="height: 280px; width: 100%;"></div>

              <div>
              </div>
            </div>
          </div>
          <div class="masonry-item col-md-6">
              <div class="bgc-white p-20 bd">
                <center><h6 class="c-grey-900">Students rating per questions for this semester</h6></center>

                  <div  id="chartContainerPie" style="height: 500px; width: 100%;"></div>

              <div>
              </div>
            </div>
          </div>
        </div>
        <div style="margin-top: 2%;">
          <center><a href="employees.php" class="btn btn-danger btn-color">CLOSE EMPLOYEE PROFILE</a></center>
        </div>



      </main>


      <!-- ### $App Screen Footer ### -->
      <?php include('footer.php'); ?>
    </div>
  </div>
</body>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  exportEnabled: true,
  theme: "light2", // "light1", "light2", "dark1", "dark2"
  title:{
    text: "Semestral Evaluation Comparison"
  },
  axisY: {
    title: "Ratings"
  },
  data: [{        
    type: "column",  
    showInLegend: true, 
    legendMarkerColor: "grey",
    legendText: "<?php echo "Evaluated by " .$tot_eval." Students";?> ",
    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
  }]
});


var chartPie = new CanvasJS.Chart("chartContainerPie", {
  exportEnabled: true,
  animationEnabled: true,
  theme: "light2", // "light1", "light2", "dark1", "dark2"
  title:{
    text: ""
  },
  // legend:{
  //   cursor: "hand",
  //   itemclick: explodePie
  // },
  axisY: {
    title: "Ratings"
  },
  data: [{
    type: "column",
    showInLegend: true,
    legendMarkerColor: "grey",
    toolTipContent: "{name}",
    indexLabel: "{y}",
    legendText: "1-Poor, 2-Fair, 3-Excellent, 4-Outstanding",
    dataPoints: <?php echo json_encode($dataPointsPie, JSON_NUMERIC_CHECK); ?>
  }]
});
chart.render();
chartPie.render();


}

</script>
</html>

<?php
include('../dbconnection.php');
include('../session.php');
include('instructor_session.php');
$re_comment = "";

$simple_string = $_GET['id'];
                                                                    
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

$id = $decrypted_id;
// $subject_load_id = $_POST['subject_load_id'];

$teacher = mysqli_query($conn, "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id WHERE basic_info.id = '$id'");
$row_teacher = mysqli_fetch_assoc($teacher);
$fullname = $row_teacher['firstname'].' '. $row_teacher['middlename'].' '.$row_teacher['lastname'];
$department = $row_teacher['dept_name'];
$photo = $row_teacher['photo_location'];
$dateOfHire = $row_teacher['date_of_hire'];
$doh = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $dateOfHire))))));
$today= new DateTime(date("Y-m-d"));           
$yearsInService = $doh->diff($today)->y +1;
?>
<?php
  $totalH2FQuestionaire = 0;
  $totalTeacherScore = 0;
  $numericalRating = 0;
  $adjectiveRating = "";
  $cat = mysqli_query($conn, "SELECT * FROM h2f_category ORDER BY added ASC");
  $count = 0;
  while($catRows = mysqli_fetch_assoc($cat)){
    $catId = $catRows['id'];
    $ques = mysqli_query($conn, "SELECT * FROM h2f_questionaires WHERE cat_id='$catId' ORDER BY added ASC");
      $q_number = 0;
      while($rowQuestion = mysqli_fetch_assoc($ques)){
        $totalH2FQuestionaire += 1;

        $qId = $rowQuestion['id'];
        $sql_get_score = mysqli_query($conn, "SELECT sum(score) AS total_score FROM h2f_evaluation WHERE teacher_id = '$id' AND question_id='$qId ' AND acad_year = '".$_SESSION['acad_year']."' ");
        $row_score = mysqli_fetch_assoc($sql_get_score);
        $total_score = $row_score['total_score'];
        $totalTeacherScore += $total_score;
      }
      $numericalRating = round(($totalTeacherScore / $totalH2FQuestionaire), 0);
      if($numericalRating == 1){
        $colorBadge = "danger";
        $adjectiveRating = "Fail";
      }
      else if($numericalRating == 2){
        $colorBadge = "warning";
        $adjectiveRating = "Poor";
      }
      else if($numericalRating == 3){
        $colorBadge = "info";
        $adjectiveRating = "Satisfactory";
      }
      else if($numericalRating == 4){
        $colorBadge = "primary";
        $adjectiveRating = "Very Satisfactory";
      }
      else if($numericalRating == 5){
        $colorBadge = "success";
        $adjectiveRating = "Outstanding";
      }


  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>Evaluation</title>
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
    input#q156 {
      transform: scale(1.6);
      cursor: pointer;
    }
   
  </style>
  <script defer="defer" src="../assets/main.js"></script></head>
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
        <main id = "pintable" class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="full-container">
              <div class="email-content-wrapper">

                <div class="peers ai-c jc-sb pX-40 pY-30">
                  <div class="peers peer-greed">
                    <div class="peer mR-20">
                      <img class="bdrs-50p w-3r h-3r" alt="" src="../<?php echo $photo; ?>">
                    </div>
                    <div class="peer">
                      <small><?php echo $department; ?></small>
                      <h5 class="c-grey-900 mB-5"><?php echo $fullname; ?></h5>
                      <!-- <span><?php //echo $sub_name; ?></span> -->
                    </div>
                  </div>
                  <div class="peer">
                    <a href="index.php" class="btn btn-danger bdrs-50p p-15 lh-0">
                      <i class="fa fa-reply"></i>
                    </a>
                    <!-- <button class="btn btn-info btn-color bdrs-50p p-15 lh-0" onclick="printDiv('pintable')" value="print a div!" >
                      <i class="fa fa-print"></i>
                    </button> -->

                  </div>
                </div>

                <!--Modal-->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="../backend_scripts/add_new_specific_questionaire.php" method="POST">

                          <h6 class="c-grey-900">Function/Specific Task</h6>
                          <div class="mT-30">
                            
                              <div class="mb-3">                   
                                <input type="text" class="form-control" name="description"aria-describedby="emailHelp" placeholder="Type Task here">
                                <input type="hidden" class="form-control" name="teacher_id" value="<?php echo $_GET['id']; ?>" aria-describedby="emailHelp">
                              </div>  
                            
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-color btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-color btn-sm">Add New</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="bdT pX-40 pY-30">
                <form action="../backend_scripts/submit_h2f_evaluation.php" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4>SUMMARY</h4>
                        <?php 
                          $sqlAcadYear = mysqli_query($conn, "SELECT * FROM academic_year WHERE id = '".$_SESSION['acad_year']."'");
                          $rowAcadYear = mysqli_fetch_assoc($sqlAcadYear);

                        ?>
                        <table class="table table-striped">

                          <tbody>
                            <tr>
                              <th scope="row">Position</th>
                              <td>Instructor</td>
                            </tr> 
                            <tr>
                              <th scope="row">Number of Years in Present Position</th>
                              <td><?php echo $yearsInService; ?> Years</td>
                            </tr> 
                            <tr>
                              <th scope="row">Department</th>
                              <td><?php echo $department; ?></td>
                            </tr> 
                            <tr>
                              <th scope="row">Rating Period</th>
                              <td><?php echo $rowAcadYear['acad_year']; ?> - <?php echo $rowAcadYear['semester']; ?></td>
                            </tr> 
                            <tr>
                              <th scope="row">Numerical Rating</th>
                              <td><b><?php echo $numericalRating; ?></b></td>
                            </tr> 
                            <tr>
                              <th scope="row">Adjective Rating</th>
                              <td><span class="badge rounded-pill fl-l bg-<?php echo $colorBadge; ?> lh-0 p-10"><?php echo $adjectiveRating; ?></span></td>
                            </tr> 
                          </tbody>
                        </table>
                      </div>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Rating scale is as follows:</h4>
                        <p><b>Employees shall be rated using the range of 5 to 1 as 5 as the highest and 1 as the lowest rating.</b></p>
                        <table class="table table-striped">

                          <tbody>
                            <tr>
                              <th scope="row">(1) Fail</th>
                              <td>The Instructor does not demonstrates this behavior at all.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(2) Poor</th>
                              <td>The Instructor demonstrates this behavior rarely/not at all.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(3) Satisfactory</th>
                              <td>The Instructor demonstrates this behavior sometimes.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(4) Very Satisfactory</th>
                              <td>The Instructor demonstrates this behavior most of the times.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(5) Outstanding</th>
                              <td>The Instructor demonstrates this behavior all the times.</td>
                            </tr> 
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <?php
                          $categories = mysqli_query($conn, "SELECT * FROM h2f_category ORDER BY added ASC");
                          $count = 0;
                          while($cat_rows = mysqli_fetch_assoc($categories)){
                            $cat_id = $cat_rows['id'];
                            echo '
                            <div class="col-md-12">
                              <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <h4 class="c-grey-900 mB-20">'.$cat_rows['cat_name'].'</h4>
                                  <table class="table">
                                  <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Numeric Rating</th>
                                        <th scope="col">Adjective Rating</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                ';
                                    $questions = mysqli_query($conn, "SELECT * FROM h2f_questionaires WHERE cat_id='$cat_id' ORDER BY added ASC");
                                    $q_number = 0;
                                    while($row_question = mysqli_fetch_assoc($questions)){

                                      $q_id = $row_question['id'];
                                      $q_number+=1;


                                      $sql_get_score = mysqli_query($conn, "SELECT sum(score) AS total_score FROM h2f_evaluation WHERE teacher_id = '$id' AND question_id='$q_id ' AND acad_year = '".$_SESSION['acad_year']."' ");
                                      $row_score = mysqli_fetch_assoc($sql_get_score);
                                      $total_score = $row_score['total_score'];
                                      $rating = 'No Rating';
                                      $color_badge = "secondary";
                                      $adj_rating = "No Rating";
                                      if($total_score == ''){
                                        $color = "btn-secondary";
                                      }
                                      else{
                                        $rating = $total_score;
                                        if($rating == 1){
                                          $color_badge = "danger";
                                          $adj_rating = "Fail";
                                        }
                                        else if($rating == 2){
                                          $color_badge = "warning";
                                          $adj_rating = "Poor";

                                        }
                                        else if($rating == 3){
                                          $color_badge= "info";
                                          $adj_rating = "Satisfactory";

                                        }
                                        else if($rating == 4){
                                          $color_badge = "primary";
                                          $adj_rating = "Very Satisfactory";

                                        }
                                        else if($rating == 5){
                                          $color_badge = "success";
                                          $adj_rating = "Outstanding";

                                        }
                                      }

                                      echo '
                                      <tr>
                                        <td><span class="badge rounded-pill fl-l bg-success lh-0 p-10">'.$q_number.'</badge></td>
                                        <td><b>'.$row_question['description'].'</b></td>
                                        <td>
                                          <span class="badge rounded-pill fl-l bg-'.$color_badge.' lh-0 p-10">'.$rating.'</span>
                                        </td>
                                        <td>
                                          <span class="badge rounded-pill fl-l bg-'.$color_badge.' lh-0 p-10">'.$adj_rating.'</span>
                                        </td>
                                        
                                      </tr>

                                      ';
                                    }
                            echo' 
                                    </tbody>
                                  </table>   
                              </div>
                            </div>

                            ';
                            
                          }
                          
                        ?>
                  </div>
                  <div class="row">
               
                         
                            <div class="col-md-12">
                              <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <h4 class="c-grey-900 mB-20">Functions/Specific Tasks</h4>

                                  <table class="table">
                                  
                                <?php
                                    $questions_a = mysqli_query($conn, "SELECT * FROM h2f_evaluation LEFT JOIN h2f_questionaires  ON h2f_evaluation.question_id = h2f_questionaires.id  WHERE h2f_evaluation.teacher_id = '$id' AND h2f_evaluation.acad_year = ".$_SESSION['acad_year']." AND cat_id = 0 ORDER BY h2f_questionaires.added ASC");
                                    $q_number_a = 0;
                                    if(mysqli_num_rows($questions_a) > 0){
                                      echo '
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col"></th>
                                            <th scope="col">Numeric Rating</th>
                                            <th scope="col">Adjective Rating</th>
                                            
                                          </tr>
                                        </thead>
                                    <tbody>

                                      ';

                                    }
                                    while($row_question_a = mysqli_fetch_assoc($questions_a)){
                                      $re_comment = $row_question_a['comment_instructor'];
                                      $q_id_a = $row_question_a['id'];
                                      $q_number_a+=1;

                                      $total_scorea = $row_question_a ['score'];
                                      $ratinga = 'No Rating';
                                      $color_badgea = "secondary";
                                      $adj_ratinga = "No Rating";

                                      if($total_scorea == ''){
                                        $color_badgea  = "btn-secondary";
                                      }
                                      else{
                                        $ratinga = $total_scorea;
                                        if($ratinga == 1){
                                          $color_badgea = "danger";
                                          $adj_ratinga = "Fail";
                                        }
                                        else if($ratinga == 2){
                                          $color_badgea = "warning";
                                          $adj_ratinga = "Poor";

                                        }
                                        else if($ratinga == 3){
                                          $color_badgea = "info";
                                          $adj_ratinga = "Satisfactory";

                                        }
                                        else if($ratinga == 4){
                                          $color_badgea = "primary";
                                          $adj_ratinga = "Very Satisfactory";

                                        }
                                        else if($ratinga == 5){
                                          $color_badgea = "success";
                                          $adj_ratinga = "Outstanding";

                                        }
                                      }




                                      echo '
                                      <tr>
                                        <td><span class="badge rounded-pill fl-l bg-success lh-0 p-10">'.$q_number_a.'</badge></td>
                                        <td><b>'.$row_question_a['description'].'</b></td>
                                        <td>
                                          <span class="badge rounded-pill fl-l bg-'.$color_badgea.' lh-0 p-10">'.$ratinga.'</span>
                                        </td>
                                        <td>
                                          <span class="badge rounded-pill fl-l bg-'.$color_badgea.' lh-0 p-10">'.$adj_ratinga.'</span>
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
                  <div class="row">
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Recommended Areas for improvement</h4>
                        <div class="layer w-100">
                          <div class="p-20 bdT bgc-white">
                            <div class="pos-r">
                              <h4><?php echo $re_comment;?></h4>
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                                
                 </div>
               </form>
               </div>


             </div>
           </div>
         </main>

         <!-- ### $App Screen Footer ### -->
         <?php //include('footer.php'); ?>
       </div>
     </div>
   </body>
   <script>
      function printDiv(divId) {
           var printContents = document.getElementById(divId).innerHTML;
           var originalContents = document.body.innerHTML;

           document.body.innerHTML = printContents;

           window.print();

           document.body.innerHTML = originalContents;
      }
    </script>

   ?>
  
   </html>

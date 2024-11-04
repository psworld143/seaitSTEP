<?php
include('../dbconnection.php');
include('../session.php');
include('staff_session.php');

if(isset($_GET['id'])){
  $_SESSION['eval_id'] = $_GET['id'];
}
$id = $_SESSION['eval_id'];
$teacher = mysqli_query($conn, "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id WHERE basic_info.id = '$id'");
$row_teacher = mysqli_fetch_assoc($teacher);
$fullname = $row_teacher['firstname'].' '. $row_teacher['middlename'].' '.$row_teacher['lastname'];
$department = $row_teacher['dept_name'];
//Make it dynamic later

if(isset($_GET['subject_id'])){
  $subject_id = $_GET['subject_id'];
}
else{
  $subject_id = 0;
}

$total_questions = 0;
$dataPoints = array();
$load = 0;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <script src="../assets/canvas.min.js"></script>
    <title>Evaluation Results</title>
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
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="full-container">
              <div class="email-app">
                <div class="email-side-nav remain-height ov-h">
                  <div class="h-100 layers">
                    <div class="p-20 bgc-grey-100 layer w-100">
                          <a href="employees.php" class="btn btn-danger bdrs-50p p-15 lh-0">
                            <i class="fa fa-reply"></i> 
                          </a>

                    </div>
                    <div class="scrollable pos-r bdT layer w-100 fxg-1">
                      <ul class="p-20 nav flex-column">
                        <?php
                          $subjects_query = mysqli_query($conn, "SELECT * FROM subject_loads LEFT JOIN subjects ON subjects.id = subject_loads.subject WHERE subject_loads.teacher = '$id' AND acad_year = '$academic_year'");
                          while($subject_row = mysqli_fetch_assoc($subjects_query)){
                            echo '
                              <li class="nav-item" title="'.$subject_row['description'].'">
                                <a href="p2p_evaluation_result.php?subject_id='.$subject_row['subject'].'" class="nav-link c-grey-800 cH-blue-500 actived">
                                  <div class="peers ai-c jc-sb">
                                    <div class="peer peer-greed">
                                      <i class="mR-10 ti-clipboard"></i>
                                      <span>'.$subject_row['code'].'</span>
                                    </div>
                                    <div class="peer">
                                    </div>
                                  </div>
                                </a>
                              </li>
                            ';

                          }

                        ?>
                      </ul>
                    </div>
                  </div>
                </div>
              <div class="email-wrapper row remain-height bgc-white ov-h">
                <input type="hidden" id="subject_id" value="<?php echo $subject_id; ?>">
                <div class="email-list h-100 layers">
                  <div class="layer w-100">
                    <div class="bgc-grey-100 peers ai-c jc-sb p-20 fxw-nw">
                      <div class="peer">
                        <div class="btn-group" role="group">
                          <button type="button" class="email-side-toggle d-n@md+ btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-menu"></i>
                          </button>
                         <!--  <button type="button" class="btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-folder"></i>
                          </button>
                          <button type="button" class="btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-tag"></i>
                          </button> -->
                          <div class="btn-group" role="group">
                            <!-- <button id="btnGroupDrop1" type="button" class="btn cur-p bgc-white no-after dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ti-more-alt"></i>
                            </button> -->
                           
                          </div>
                        </div>
                      </div>
                      <div class="peer">
                        <div class="btn-group" role="group">
                          <button type="button" class="fsz-xs btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-angle-left"></i>
                          </button>
                          <button type="button" class="fsz-xs btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-angle-right"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                 <!--  <div class="layer w-100">
                    <div class="bdT bdB">
                      <input type="text" class="form-control m-0 bdw-0 pY-15 pX-20" placeholder="Search...">
                    </div>
                  </div> -->
                  <div class="layer w-100 fxg-1 scrollable pos-r">
                    <?php
                      if(isset($_GET['subject_id'])){
                        $comment_query = mysqli_query($conn, "SELECT *, p2p_evaluation.added AS comment_date FROM p2p_evaluation LEFT JOIN basic_info ON basic_info.id = p2p_evaluation.evaluator_id WHERE p2p_evaluation.subject_id = '$subject_id' AND teacher_id = '$id' AND acad_year = '$academic_year' GROUP BY p2p_evaluation.comment_instructor");
                        if(mysqli_num_rows($comment_query) != 0){
                          $load = 1;



                          while($comment_row = mysqli_fetch_assoc($comment_query)){
                            $total_rating_comment = 0;
                            $fullname_comment = $comment_row['lastname'].', '.$comment_row['firstname'];
                            $eval_id = $comment_row['evaluator_id'];
                            $get_total_score_query = mysqli_query($conn, "SELECT SUM(score) AS total_score FROM p2p_evaluation WHERE teacher_id = '$eval_id' AND subject_id='$subject_id' AND acad_year='$academic_year'");

                            $total_score_row = mysqli_fetch_assoc($get_total_score_query);

                            $total_score_comment = $total_score_row['total_score'];

                            $total_evaluator_comment_query = mysqli_query($conn, "SELECT COUNT(*) AS total_questions FROM p2p_questionaires");

                            $total_evaluator_comment_row = mysqli_fetch_assoc($total_evaluator_comment_query);
                            $total_questions = $total_evaluator_comment_row['total_questions'];

                            $total_rating_comment = $total_score_comment / $total_questions;

                            $rating_comment = '';
                            $badge_color_comment = '';

                            if($total_rating_comment > 0 && $total_rating_comment < 2){
                              $rating_comment = 'Unsatisfactory';
                              $badge_color_comment = 'bg-danger';
                            }
                            else if($total_rating_comment > 1 && $total_rating_comment < 3){
                              $rating_comment = 'Satisfactory';
                              $badge_color_comment = 'bg-warning';
                            }
                            else if($total_rating_comment > 2 && $total_rating_comment < 4){
                              $rating_comment = 'Very Satisfactory';
                              $badge_color_comment = 'bg-success';
                            }
                            else if($total_rating_comment > 3 && $total_rating_comment < 5){
                              $rating_comment = 'Outstanding';
                              $badge_color_comment = 'bg-info';
                            }
                            echo '
                              <div class="">
                                <div class="email-list-item peers fxw-nw p-20 bdB bgcH-grey-100 cur-p">
                                  <div class="peer peer-greed ov-h">
                                    <div class="peers ai-c">
                                      <div class="peer peer-greed">
                                        <h6>'.$fullname_comment.'</h6>
                                      </div>
                                      <div class="peer">
                                        <small>'.$comment_row['comment_date'].'</small>
                                      </div>
                                    </div>
                                    <h5 class="fsz-def tt-c c-grey-900" title="'.$total_rating_comment.'"><span class="badge rounded-pill '.$badge_color_comment.'" >'.$rating_comment.'</span></h5>
                                    <hr style="color: black;">
                                    Instructor Comment:
                                    <br>
                                    <span class="">'.$comment_row['comment_course'].'</span>
                                    <hr style="color: black;">
                                    Student Comment:
                                    <br>
                                    <span class="">'.$comment_row['comment_instructor'].'</span>
                                  </div>
                                </div>
                              </div>
                            ';
                          }
                        }
                        else{

                        }


                      }
                      else{
                        echo "<center><h6>Select Subject first.</h6></center>";
                      }
                      

                    ?>
                  </div>
                </div>
                <div class="email-content h-100">
                  <div class="h-100 scrollable pos-r">
                    <div class="bgc-grey-100 peers ai-c jc-sb p-20 fxw-nw d-n@md+">
                      <div class="peer">
                        <div class="btn-group" role="group">
                          <button type="button" class="back-to-mailbox btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-angle-left"></i>
                          </button>
                          <!-- <button type="button" class="btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-folder"></i>
                          </button>
                          <button type="button" class="btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-tag"></i>
                          </button> -->
                          <div class="btn-group" role="group">
                            <!-- <button id="btnGroupDrop1" type="button" class="btn cur-p bgc-white no-after dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ti-more-alt"></i>
                            </button> -->
                            <!-- <ul class="dropdown-menu fsz-sm" aria-labelledby="btnGroupDrop1">
                              <li>
                                <a href="" class="d-b td-n pY-5 pX-10 bgcH-grey-100 c-grey-700">
                                  <i class="ti-trash mR-10"></i>
                                  <span>Delete</span>
                                </a>
                              </li>
                              <li>
                                <a href="" class="d-b td-n pY-5 pX-10 bgcH-grey-100 c-grey-700">
                                  <i class="ti-alert mR-10"></i>
                                  <span>Mark as Spam</span>
                                </a>
                              </li>
                              <li>
                                <a href="" class="d-b td-n pY-5 pX-10 bgcH-grey-100 c-grey-700">
                                  <i class="ti-star mR-10"></i>
                                  <span>Star</span>
                                </a>
                              </li>
                            </ul> -->
                          </div>
                        </div>
                      </div>
                      <div class="peer">
                        <div class="btn-group" role="group">
                          <button type="button" class="fsz-xs btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-angle-left"></i>
                          </button>
                          <button type="button" class="fsz-xs btn bgc-white bdrs-2 mR-3 cur-p">
                            <i class="ti-angle-right"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="email-content-wrapper">
                      
                      <div class="peers ai-c jc-sb pX-40 pY-30">
                        <div class="peers peer-greed">
                          <?php
                            if(isset($_GET['subject_id'])){
                              echo '
                              <div id="chartContainer" style="height: 180px; width: 100%;">
                                
                              </div>';
                            }
                          ?>
                          
                        </div>
                        
                      </div>

                      <center><h4><?php echo $fullname;?></h4></center>
                       <center><h6>
                          <?php
                            if(isset($_GET['subject_id']) && $load == 1){
                                echo 'Evaluation Result';
                            }
                            else{

                            }
                          ?>
                          
                        </h6>
                      </center>
                      <div class="bdT pX-40 pY-30">
                       
                        <div class="row">
                          <?php

                          if(isset($_GET['subject_id']) && $load == 1){
                            $categories = mysqli_query($conn, "SELECT * FROM p2p_category ORDER BY added ASC");
                            $count = 0;

                            $cat_name = "";
                            $cat_total_scores = 0;
                            $cat_total_evaluators = 0;
                            $cat_total_ratings = 0 ;
                            

                            while($cat_rows = mysqli_fetch_assoc($categories)){
                              $cat_total_ratings = 0 ;

                              $cat_id = $cat_rows['id'];
                              $cat_name = $cat_rows['cat_name'];
                              echo '
                              <div class="col-md-12">
                                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                  <h4 class="c-grey-900 mB-20">'.$cat_rows['cat_name'].'</h4>
                                    <table class="table">
                                    <thead>
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Criteria</th>
                                          <th scope="col"><center>Rating</center></th>
                                         
                                        </tr>
                                      </thead>
                                      <tbody>
                                  ';
                                      $questions = mysqli_query($conn, "SELECT * FROM p2p_questionaires WHERE cat_id='$cat_id' ORDER BY added ASC");
                                      $q_number = 0;

                                      $tot_score = 0;
                                      while($row_question = mysqli_fetch_assoc($questions)){
                                        $q_id = $row_question['id'];
                                        $q_number+=1;
                                        echo '
                                        <tr>
                                          <td>'.$q_number.'</td>
                                          <td>'.$row_question['description'].'</td>
                                          <td>
                                            
                                        ';
                                          $rating_query = mysqli_query($conn, "SELECT SUM(score) AS total_score FROM p2p_evaluation WHERE question_id = '$q_id' AND subject_id='$subject_id'  AND acad_year = '$academic_year'  AND teacher_id = '$id'");
                                          $rating_row = mysqli_fetch_assoc($rating_query);
                                          $total_score = $rating_row['total_score'];

                                          $tot_score += $total_score;

                                          $cat_total_scores += $total_score;

                                          $total_evaluators_query = mysqli_query($conn, "SELECT COUNT(*) FROM p2p_evaluation WHERE question_id = '$q_id' AND subject_id='$subject_id'  AND acad_year = '$academic_year'  AND teacher_id = '$id' GROUP BY evaluator_id");

                                          $total_evaluators = mysqli_num_rows($total_evaluators_query);
                                          $cat_total_evaluators += $total_evaluators;

                                          $total_rating =  round($total_score / $total_evaluators);

                                          $cat_total_ratings += $total_rating;

                                          $rating = '';
                                          $badge_color = '';
                                          if($total_rating > 0 && $total_rating < 2){
                                            $rating = 'Unsatisfactory';
                                            $badge_color = 'bg-danger';
                                          }
                                          else if($total_rating > 1 && $total_rating < 3){
                                            $rating = 'Satisfactory';
                                            $badge_color = 'bg-warning';
                                          }
                                          else if($total_rating > 2 && $total_rating < 4){
                                            $rating = 'Very Satisfactory';
                                            $badge_color = 'bg-success';
                                          }
                                          else if($total_rating > 3 && $total_rating < 5){
                                            $rating = 'Outstanding';
                                            $badge_color = 'bg-info';
                                          }
                                          echo '<span class="peer" title="'.$total_rating.'">
                                                  <span class="badge rounded-pill fl-r '.$badge_color.' lh-0 p-10">'.$rating.'</span>
                                                </span>'
                                          ;



                                        echo '    
                                            
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

                              $sql_get_total_question_per_category = mysqli_query($conn, "SELECT COUNT(*) AS total_question FROM p2p_questionaires WHERE cat_id = '$cat_id'");

                              $total_questions_cat_row = mysqli_fetch_assoc($sql_get_total_question_per_category);
                              $total_questions_cat = $total_questions_cat_row['total_question'];

                              $percentage = round(($tot_score / $total_questions_cat)/$total_evaluators, 0);
                              $rating_pie = '';
                              $badge_color = '';

                              if($percentage > 0 && $percentage < 2){
                                $rating_pie = 'Unsatisfactory';
                              }
                              else if($percentage > 1 && $percentage < 3){
                                $rating_pie = 'Satisfactory';
                              }
                              else if($percentage > 2 && $percentage < 4){
                                $rating_pie = 'Very Satisfactory';              
                              }
                              else if($percentage > 3 && $percentage < 5){
                                $rating_pie = 'Outstanding';
                                          
                              }


                              array_push($dataPoints , array("label"=>$rating_pie, "symbol" =>$cat_name, "y"=> $percentage));
                             
                              
                            //End of While Loop
                            }
                          }
                          else{
                            echo "<center><h6>Select Subject first.</h6></center>";
                          }
                          
                        ?>
                  </div>
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>
        </main>

        <!-- ### $App Screen Footer ### -->
        <?php include('footer.php'); ?>
      </div>
    </div>
  </body>
  <script>

    window.onload = function() {
    var chart = new CanvasJS.Chart("chartContainer", {
      theme: "light2",
      animationEnabled: true,
      title: {
        text: ""
      },
      subtitles: [{
        text: " Evaluated by <?php echo $total_evaluators; ?> Students"
      }],
      data: [{
        type: "doughnut",
        indexLabel: "{symbol} - {y}",
        yValueFormatString: "#\"\"",
        showInLegend: false,
        legendText: "{label} : {y}",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart.render();
     
    }

  </script>
</html>

<?php
include('../dbconnection.php');
include('../session.php');
include('admin_session.php');

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
$load = 1;

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
              <div class="peers fxw-nw pos-r">
                
                <!-- <div class="peer bdR" id="chat-sidebar" style="width:20%;">
                  <div class="layers h-100">
                    
                    <div class="bdB layer w-100">
                      
                    </div>
                    <div class="layer w-100 fxg-1 scrollable pos-r">
                      <div class="peers fxw-nw ai-c p-20 bdB bgc-white bgcH-grey-50 cur-p">
                        <div class="peer">
                          <h6><i class="ti-comment"></i></h6>
                        </div>
                        <div class="peer peer-greed pL-20">
                          <h6 class="mB-0 lh-1 fw-400">Course Comments</h6>
                          <small class="lh-1 c-green-500"></small>
                        </div>
                      </div> -->
                    <?php
                      
                        // $comment_query = mysqli_query($conn, "SELECT *, p2p_evaluation.added AS comment_date FROM p2p_evaluation LEFT JOIN basic_info ON basic_info.id = p2p_evaluation.evaluator_id WHERE teacher_id = '3' GROUP BY p2p_evaluation.comment_course");
                        // if(mysqli_num_rows($comment_query) != 0){
                        //   $load = 1;



                        //   while($comment_row = mysqli_fetch_assoc($comment_query)){
                        //     $total_rating_comment = 0;
                        //     $fullname = $comment_row['lastname'].', '.$comment_row['firstname'];
                        //     $student_id = $comment_row['evaluator_id'];
                        //     $get_total_score_query = mysqli_query($conn, "SELECT SUM(score) AS total_score FROM student_evaluation WHERE student_id = '$student_id' AND subject_id='$subject_id' AND acad_year='$academic_year'");

                        //     $total_score_row = mysqli_fetch_assoc($get_total_score_query);

                        //     $total_score_comment = $total_score_row['total_score'];

                        //     $total_evaluator_comment_query = mysqli_query($conn, "SELECT COUNT(*) AS total_questions FROM questionaires");

                        //     $total_evaluator_comment_row = mysqli_fetch_assoc($total_evaluator_comment_query);
                        //     $total_questions = $total_evaluator_comment_row['total_questions'];

                        //     $total_rating_comment = $total_score_comment / $total_questions;

                        //     $rating_comment = '';
                        //     $badge_color_comment = '';
                        //     if($total_rating_comment > 0 && $total_rating_comment < 2){
                        //       $rating_comment = 'Unsatisfactory';
                        //       $badge_color_comment = 'bg-danger';
                        //     }
                        //     else if($total_rating_comment > 1 && $total_rating_comment < 3){
                        //       $rating_comment = 'Satisfactory';
                        //       $badge_color_comment = 'bg-warning';
                        //     }
                        //     else if($total_rating_comment > 2 && $total_rating_comment < 4){
                        //       $rating_comment = 'Very Satisfactory';
                        //       $badge_color_comment = 'bg-success';
                        //     }
                        //     else if($total_rating_comment > 3 && $total_rating_comment < 5){
                        //       $rating_comment = 'Outstanding';
                        //       $badge_color_comment = 'bg-info';
                        //     }
                        /* 
                            echo '
                             
                                
                                <div class="peers fxw-nw ai-c p-20 bdB bgc-white bgcH-grey-50 cur-p">
                                  <div class="peer">
                                    <h6></h6>
                                  </div>
                                  <div class="peer peer-greed pL-20">
                                    <h6 class="mB-0 lh-1 fw-400">'.$fullname.'</h6>
                                    <small class="lh-1 c-green-500">'.$comment_row['comment_course'].'</small>
                                  </div>
                                </div>
                              
                              
                            ';
                            */
                        //   }
                        // }
                        // else{

                        // }


                      
                      

                    ?>
                 <!--  </div>
                  </div>
                </div> -->
                <div class="peer bdR" id="chat-sidebar" style="width:40%;">
                  <div class="layers h-100">
                    
                    <div class="bdB layer w-100">
                      
                    </div>
                    <div class="layer w-100 fxg-1 scrollable pos-r">
                      <div class="peers fxw-nw ai-c p-20 bdB bgc-white bgcH-grey-50 cur-p">
                        <div class="peer">
                          <h6><i class="ti-comment"></i></h6>
                        </div>
                        <div class="peer peer-greed pL-20">
                          <h6 class="mB-0 lh-1 fw-400">Instructor Comments</h6>
                          <small class="lh-1 c-green-500"></small>
                        </div>
                      </div>
                    <?php
                      
                        $comment_query = mysqli_query($conn, "SELECT *, p2p_evaluation.added AS comment_date FROM p2p_evaluation LEFT JOIN basic_info ON basic_info.id = p2p_evaluation.evaluator_id WHERE teacher_id = '3' GROUP BY p2p_evaluation.comment_course");
                        if(mysqli_num_rows($comment_query) != 0){
                          $load = 1;



                          while($comment_row = mysqli_fetch_assoc($comment_query)){
                            $total_rating_comment = 0;
                            $fullname = $comment_row['lastname'].', '.$comment_row['firstname'];
                            $student_id = $comment_row['evaluator_id'];
                            $get_total_score_query = mysqli_query($conn, "SELECT SUM(score) AS total_score FROM student_evaluation WHERE student_id = '$student_id' AND subject_id='$subject_id' AND acad_year='$academic_year'");

                            $total_score_row = mysqli_fetch_assoc($get_total_score_query);

                            $total_score_comment = $total_score_row['total_score'];

                            $total_evaluator_comment_query = mysqli_query($conn, "SELECT COUNT(*) AS total_questions FROM questionaires");

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
                                <div class="peers fxw-nw ai-c p-20 bdB bgc-white bgcH-grey-50 cur-p">
                                  <div class="peer">
                                    <h6></h6>
                                  </div>
                                  <div class="peer peer-greed pL-20">
                                    <h6 class="mB-0 lh-1 fw-400">'.$fullname.'</h6>
                                    <small class="lh-1 c-green-500">'.$comment_row['comment_instructor'].'</small>
                                  </div>
                                </div>
                              
                              
                            ';
                          }
                        }
                        else{

                        }


                      
                      

                    ?>
                  </div>
                  </div>
                </div>

                
                <div class="peer peer-greed" id="chat-box">
                  <div class="peers ai-c jc-sb pX-40 pY-30">
                      <div class="peers peer-greed">
                          <?php
                            if(isset($_GET['id'])){
                              echo '
                              <div id="chartContainerP2P" style="height: 180px; width: 100%;">
                                
                              </div>';
                            }
                          ?>
                       </div>       
                  </div>
                  <center><h4><?php echo $fullname;?></h4></center>
                  <center>
                    <h6>
                      <?php
                        if(isset($_GET['id']) && $load == 1){
                          echo 'Evaluation Result';
                        }
                        else{

                        }
                      ?>  
                    </h6>
                  </center>

                  <?php

                          if($load == 1){
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
                                          $rating_query = mysqli_query($conn, "SELECT SUM(score) AS total_score FROM p2p_evaluation WHERE question_id = '$q_id' AND acad_year = '$academic_year'  AND teacher_id = '3'");
                                          $rating_row = mysqli_fetch_assoc($rating_query);
                                          $total_score = $rating_row['total_score'];

                                          $tot_score += $total_score;

                                          $cat_total_scores += $total_score;

                                          $total_evaluators_query = mysqli_query($conn, "SELECT COUNT(*) FROM p2p_evaluation WHERE question_id = '$q_id' AND acad_year = '$academic_year'  AND teacher_id = '3' GROUP BY evaluator_id");

                                          $total_evaluators = mysqli_num_rows($total_evaluators_query);
                                          $cat_total_evaluators += $total_evaluators;

                                          $total_rating =  round($total_score / $total_evaluators);

                                          $cat_total_ratings += $total_rating;

                                          $rating = '';
                                          $badge_color = '';
                                          if($total_rating > 0 && $total_rating < 2){
                                            $rating = 'Strongly Disagree';
                                            $badge_color = 'bg-danger';
                                          }
                                          else if($total_rating > 1 && $total_rating < 3){
                                            $rating = 'Disagree';
                                            $badge_color = 'bg-warning';
                                          }
                                          else if($total_rating > 2 && $total_rating < 4){
                                            $rating = 'Somewhat Agree';
                                            $badge_color = 'bg-success';
                                          }
                                          else if($total_rating > 3 && $total_rating < 5){
                                            $rating = 'Agree';
                                            $badge_color = 'bg-info';
                                          }
                                          else if($total_rating > 4 && $total_rating < 6){
                                            $rating = 'Strongly Agree';
                                            $badge_color = 'bg-primary';
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
        </main>

        <!-- ### $App Screen Footer ### -->
        <?php include('footer.php'); ?>
      </div>
    </div>
  </body>
  <script>

    window.onload = function() {
    var chart = new CanvasJS.Chart("chartContainerP2P", {
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

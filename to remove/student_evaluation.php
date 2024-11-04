<?php
session_start();
include('dbconnection.php');
$id =$_POST['id'];
$teacher = mysqli_query($conn, "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id WHERE basic_info.id = '$id'");
$row_teacher = mysqli_fetch_assoc($teacher);
$fullname = $row_teacher['firstname'].' '. $row_teacher['middlename'].' '.$row_teacher['lastname'];
$department = $row_teacher['dept_name'];
//Make it dynamic later
$subject_id = 1;
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
    }
   
  </style>
  <script defer="defer" src="assets/main.js"></script></head>
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
              <div class="email-content-wrapper">

                <div class="peers ai-c jc-sb pX-40 pY-30">
                  <div class="peers peer-greed">
                    <div class="peer mR-20">
                      <img class="bdrs-50p w-3r h-3r" alt="" src="https://randomuser.me/api/portraits/men/11.jpg">
                    </div>
                    <div class="peer">
                      <small><?php echo $department; ?></small>
                      <h5 class="c-grey-900 mB-5"><?php echo $fullname; ?></h5>
                      <span>Platform Technologies</span>
                    </div>
                  </div>
                  <div class="peer">
                    <a href="student_evaluation_page.php" class="btn btn-danger bdrs-50p p-15 lh-0">
                      <i class="fa fa-reply"></i>
                    </a>
                  </div>
                </div>


                <div class="bdT pX-40 pY-30">
                <form action="backend_scripts/submit_evaluation.php" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4>INSTRUCTIONS</h4>
                        <p>
                          In this Inventory, you are asked to assess your Instructor's Planning and Lesson Implementation, CLassroom Mnagement, and Interpersonal Skills. We hope that you answer truthfully, and free of bias. Your responses will be confidential, and will not affect you grades. SELECT YOUR ANSWER IN EACH ITEM.
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Rating scale is as follows:</h4>
                        <p><b>1=being the lowest, and 4=being the highest</b></p>
                        <table class="table table-striped">

                          <tbody>
                            <tr>
                              <th scope="row">(1) Unsatisfactory</th>
                              <td>The Instructor demonstrates this behavior rarely/not at all.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(2) Satisfactory</th>
                              <td>The Instructor demonstrates this behavior sometimes.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(3) Very Satisfactory</th>
                              <td>The Instructor demonstrates this behavior most of the times.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(4) Outstanding</th>
                              <td>The Instructor demonstrates this behavior all the times.</td>
                            </tr> 
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <?php
                          $categories = mysqli_query($conn, "SELECT * FROM category ORDER BY added ASC");
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
                                        <th scope="col"></th>
                                        <th scope="col"><center>1</center></th>
                                        <th scope="col"><center>2</center></th>
                                        <th scope="col"><center>3</center></th>
                                        <th scope="col"><center>4</center></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                ';
                                    $questions = mysqli_query($conn, "SELECT * FROM questionaires WHERE cat_id='$cat_id' ORDER BY added ASC");
                                    $q_number = 0;
                                    while($row_question = mysqli_fetch_assoc($questions)){
                                      $q_id = $row_question['id'];
                                      $q_number+=1;
                                      echo '
                                      <tr>
                                        <td>'.$q_number.'</td>
                                        <td>'.$row_question['description'].'</td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="1" required>  
                                          </center>
                                        </td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="2" required>
                                          </center>
                                        </td>
                                        <td> 
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="3" required> 
                                          </center>
                                        </td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="4" required>  
                                          </center>     
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
                        <h4 class="c-grey-900 mB-20">COMMENTS</h4>
                        <div class="layer w-100">
                          <div class="p-20 bdT bgc-white">
                            <div class="pos-r">
                              <input type="text" name="comment" class="form-control bdrs-10em m-0" placeholder="Say something..." required>
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <div class="layer w-100">                        
                          <div class="p-20 bdT bgc-white">
                            <center>Thank you for taking the time to answer this.</center>
                            <center>Your responses will be confidential, and will not affect your grades.</center>
                            <div class="pos-r">
                            <br>                             
                              <center>
                                <input type="hidden" name="teacher_id" value="<?php echo $id;?>">
                                <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                                <button type="submit" class="btn btn-primary btn-color">
                                 <i class="fa fa-paper-plane-o"></i>
                                  SUBMIT EVALUATION
                                </button>
                              </center>
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
   </html>

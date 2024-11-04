<?php
include('../dbconnection.php');
include('../session.php');
include('instructor_session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>STEP-Instructors</title>
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
      $(function() {
        $('.selectpicker').selectpicker();
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
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="bgc-white bd bdrs-3 p-20">
                    <h4 class="c-grey-900 mB-20">Peer-to-Peer Evaluation</h4>
                    
                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Teacher</th>
                          <th>Evaluated</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Teacher</th>
                          <th>Evaluated</th>
                          <th>Option</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                          $number = 0;
                          $subject_query = mysqli_query($conn, "SELECT *, basic_info.id AS teacher_id FROM employment_informations LEFT JOIN basic_info ON basic_info.id = employment_informations.id WHERE employment_informations.department = '$dept_id' AND basic_info.id != '$user_id'");
                          while($rows_co_teachers = mysqli_fetch_assoc($subject_query)){
                            $number+=1;
                            $teacher_id = $rows_co_teachers['teacher_id'];
                            $isEvaluated = "No";
                            $btnDesc="Evaluate";
                            $btnColor = "btn-success";
                            $btnDisabled = "";
                            $eval_check_query = mysqli_query($conn, "SELECT * FROM p2p_evaluation WHERE acad_year = '$academic_year' AND evaluator_id = '$user_id' AND teacher_id = '$teacher_id'");
                            if(mysqli_num_rows($eval_check_query) > 0){
                              $isEvaluated = "Yes";
                              $btnDesc="Evaluated";
                              $btnColor = "btn-danger";
                              $btnDisabled = "disabled";
                            }
                            


                            $teacher = $rows_co_teachers['firstname'].' '.$rows_co_teachers['middlename'].' '.$rows_co_teachers['lastname'];
                            echo '
                              <tr>
                                <td>'.$number.'</td>
                                <td>'.$teacher.'</td>
                                <td>'.$isEvaluated.'</td>
                                <td>
                                  <form action="p2p_evaluation.php" method="POST">
                                    <input type="hidden" value="'.$rows_co_teachers['teacher_id'].'" name="id">
                                    <button type="submit" class="btn cur-p '.$btnColor.' btn-color btn-sm" '.$btnDisabled.'>'.$btnDesc.'</button>
                                  </form>
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
          </div>
        </main>

        <!-- ### $App Screen Footer ### -->
        <?php include('../footer.php'); ?>
      </div>
    </div>
  </body>
  </html>

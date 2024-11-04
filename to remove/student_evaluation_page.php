<?php
include('dbconnection.php');
include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>Instructors</title>
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
        <?php include('navbar.php'); ?>

        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="bgc-white bd bdrs-3 p-20">
                    <h4 class="c-grey-900 mB-20">List of Instructors</h4>
                    <div class="row">
                      <div class="row">
                        <div class="mb-3 col-md-2">
                          <input type="text" class="form-control" id="inputEmail4" placeholder="Join Code">
                        </div>
                        <div class="mb-3 col-md-6">
                          <button class="btn btn-info">JOIN</button>
                        </div>
                      </div>
                    </div>
                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Teacher</th>
                          <th>Subject</th>
                          <th>Join Code</th>
                          <th>Evaluated</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Teacher</th>
                          <th>Subject</th>
                          <th>Join Code</th>
                          <th>Evaluated</th>
                          <th>Option</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                          $number = 0;
                          $subject_query = mysqli_query($conn, "SELECT * FROM student_subjects WHERE student_id = '$user_id' AND acad_year = '$academic_year'");
                          while($rows_subject_load = mysqli_fetch_assoc($subject_query)){
                            $number+=1;
                            $isEvaluated = "No";

                            $subject_load_id = $rows_subject_load['subject_load_id'];

                            $get_subject_details_query = mysqli_query($conn, "SELECT *, basic_info.id AS teacher_id FROM subject_loads LEFT JOIN subjects ON subject_loads.subject = subjects.id LEFT JOIN basic_info ON basic_info.id = subject_loads.teacher WHERE subject_loads.id = '$subject_load_id' AND subject_loads.acad_year = '$academic_year'");
                            $subject_details_row = mysqli_fetch_assoc($get_subject_details_query);

                            $teacher = $subject_details_row['firstname'].' '.$subject_details_row['middlename'].' '.$subject_details_row['lastname'];
                        
                            echo '
                              <tr>
                                <td>'.$number.'</td>
                                <td>'.$teacher.'</td>
                                <td>'.$subject_details_row['description'].'</td>
                                <td>'.$subject_details_row['join_code'].'</td>
                                <td>'.$isEvaluated.'</td>
                                <td>
                                  <form action="student_evaluation.php" method="POST">
                                    <input type="hidden" value="'.$subject_details_row['teacher_id'].'" name="id">
                                    <button type="submit" class="btn cur-p btn-danger btn-color">Evaluate</button>
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
        <?php include('footer.php'); ?>
      </div>
    </div>
  </body>
  </html>

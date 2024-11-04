<?php
include('../dbconnection.php');
include('../session.php');
include('instructor_session.php');
$subject_load_id = $_GET['id'];
$get_lod_query = mysqli_query($conn, "SELECT * FROM subject_loads LEFT JOIN subjects ON subjects.id = subject_loads.subject   WHERE subject_loads.id = '$subject_load_id'");
$subject_row = mysqli_fetch_assoc($get_lod_query);
$subject = $subject_row['description'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>List of Students</title>
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
                    <h4 class="c-grey-900 mB-20">List of Students for <?php echo $subject; ?></h4>
                    
                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Latname</th>
                          <th>Firstname</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Latname</th>
                          <th>Firstname</th>
                          <th>Option</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                          $number = 0;
                          $student_query = mysqli_query($conn, "SELECT *, student_subjects.id AS sid FROM student_subjects LEFT JOIN step_users ON step_users.id = student_subjects.student_id WHERE student_subjects.subject_load_id = '$subject_load_id' ORDER BY step_users.lastname ASC");
                          while($rows_student = mysqli_fetch_assoc($student_query)){
                            $number+=1;
                            $total_students = 0;
                            echo '
                              <tr>
                                <td>'.$number.'</td>
                                <td>'.$rows_student['lastname'].'</td>
                                <td>'.$rows_student['firstname'].'</td>
                                <td>
                                  <button type="button" class="btn btn-danger btn-sm btn-color" data-bs-toggle="modal" data-bs-target="#remove'.$rows_student['sid'].'">Remove</button>
                                </td>
                              </tr>
                              <div class="modal fade" id="remove'.$rows_student['sid'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="../backend_scripts/remove_student.php" method="POST">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Subject Load</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <h4>Are you sure you want to remove '.$rows_student['firstname'].' ' .$rows_student['lastname']. '? </h4>
                                        <input type="hidden" value="'.$subject_load_id.'" name ="sub_load_id">
                                        <input type="hidden" value="'.$rows_student['sid'].'" name="id">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger btn-sm btn-color">Remove</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
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

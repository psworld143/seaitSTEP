<?php
include('dbconnection.php');
include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>List of Subjects</title>
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
              <h4 class="c-grey-900 mT-10 mB-30">Faculty Loading</h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="bgc-white bd bdrs-3 p-20">
                    <h4 class="c-grey-900 mB-20">List of Subjects</h4>
                    <div class="peer">
                      <button type="button" class="btn btn-primary btn-color" data-bs-toggle="modal" data-bs-target="#addSubjectLoad">Add Subject Load</button>
                      Can't find subject? add it <a class="" data-bs-toggle="modal" data-bs-target="#registerSubject"> here</a>
                    </div>

                    <div class="modal fade" id="addSubjectLoad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="backend_scripts/add_subject_load.php" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Add Subject Load</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="mb-3 col-md-12">
                                <label class="form-label" for="inputState">Subject</label>
                                <select id="inputState" name="subject" class="form-control" id="select-country" data-live-search="true" required>
                                  <?php
                                  $subject_query = mysqli_query($conn, "SELECT * FROM subjects ORDER BY code ASC");
                                  while($subject_row = mysqli_fetch_assoc($subject_query)){
                                    echo '<option value="'.$subject_row['id'].'">'.$subject_row['code'].'-'.$subject_row['description'].'</option>';
                                  }
                                  ?>
                                  
                                </select>
                              </div>
                              <div class="mb-3">
                                <label class="form-label" for="exampleInputEmail1">Year and Block</label>
                                <input type="text" class="form-control" name="year_block" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Year and Block" required>
                              </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Add Subject</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="registerSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <form action="backend_scripts/register_subject.php" method="POST">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Register Subject</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <p>Seems like you can't find your subject code when adding your subject load. Please register it here.</p>
                              <div class="mb-3">
                                <label class="form-label" for="exampleInputEmail1">Subject Code</label>
                                <input type="text" class="form-control" name="subject_code" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Subject Code" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label" for="exampleInputPassword1">Descriptive Title</label>
                                <input type="text" class="form-control" name="desc_title" id="exampleInputPassword1" placeholder="Descriptive Title" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>


                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Subject</th>
                          <th>Total Students</th>
                          <th>Join Code</th>
                          <th>Progress</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Subject</th>
                          <th>Total Students</th>
                          <th>Join Code</th>
                          <th>Progress</th>
                          <th>Option</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                          $number = 0;
                          $subject_query = mysqli_query($conn, "SELECT *, subject_loads.id AS sub_load_id FROM subject_loads LEFT JOIN subjects ON subject_loads.subject = subjects.id ORDER BY subjects.description ASC");
                          while($rows_subject_load = mysqli_fetch_assoc($subject_query)){
                            $subject_load_id = $rows_subject_load['sub_load_id'];
                            $number+=1;
                            $total_students = 0;
                            $get_total_students_query = mysqli_query($conn, "SELECT COUNT(*) AS total_students FROM student_subjects WHERE subject_load_id = '$subject_load_id' AND acad_year = '$academic_year'");
                            if(mysqli_num_rows($get_total_students_query) > 0){
                              $total_students_row = mysqli_fetch_assoc($get_total_students_query);
                              $total_students = $total_students_row['total_students'];
                            }
                            else{
                              $total_students = 0;
                            }
                            echo '
                              <tr>
                                <td>'.$number.'</td>
                                <td>'.$rows_subject_load['description'].'</td>
                                <td>0</td>
                                <td>'.$rows_subject_load['join_code'].'</td>
                                <td>'.$total_students.'</td>
                                <td>
                                  <a href="" class="btn btn-success">View Students</a>
                                  <a href="" class="btn btn-danger">Evaluations</a>
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

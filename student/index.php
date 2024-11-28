<?php
include('../dbconnection.php');
include('student_session.php');

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>STEP-Student</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../style.css">
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
      0% {
        -webkit-transform: scale(0)
      }

      100% {
        -webkit-transform: scale(1.0);
        opacity: 0;
      }
    }

    @keyframes sk-scaleout {
      0% {
        -webkit-transform: scale(0);
        transform: scale(0);
      }

      100% {
        -webkit-transform: scale(1.0);
        transform: scale(1.0);
        opacity: 0;
      }
    }
  </style>
  <script defer="defer" src="../assets/main.js"></script>
</head>

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
        <?php
        if (isset($_SESSION['success'])) {
          echo '
                        <script>
                            Swal.fire({
                              title: "Success",
                              text: "' . $_SESSION['success'] . '",
                              icon: "success"
                            });
                        </script>
                    ';
          unset($_SESSION['success']);
        } else if (isset($_SESSION['error'])) {
          echo '
                        <script>
                            Swal.fire({
                              title: "Error",
                              text: "' . $_SESSION['error'] . '",
                              icon: "error"
                            });
                        </script>
                    ';
          unset($_SESSION['error']);
        }

        ?>
        <div id="mainContent">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20">
                  <h4 class="c-grey-900 mB-20">List of Instructors</h4>
                  <form method="POST" action="../backend_scripts/join_class.php">
                    <div class="row">
                      <!--<div class="row">-->

                      <!--    <div class="mb-3 col-md-2">-->
                      <!--      <input type="text" name="code" class="form-control" id="inputEmail4" placeholder="Join Code">-->
                      <!--    </div>-->
                      <!--    <div class="mb-3 col-md-6">-->
                      <!--      <button type="submit" class="btn btn-success btn-color">JOIN</button>-->
                      <!--    </div>-->

                      <!--</div>-->
                    </div>
                  </form>
                  <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Teacher</th>
                        <!--<th>Subject</th>-->
                        <!--<th>Join Code</th>-->
                        <th>Evaluated</th>
                        <th>Option</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th>Teacher</th>
                        <!--<th>Subject</th>-->
                        <!--<th>Join Code</th>-->
                        <th>Evaluated</th>
                        <th>Option</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $number = 0;
                      $dept = $_SESSION['dept_id'];
                      $subject_query = mysqli_query($conn, "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id WHERE employment_informations.department = $dept");
                      while ($rows_subject_load = mysqli_fetch_assoc($subject_query)) {
                        $number += 1;
                        $teacher_id = $rows_subject_load['id'];


                        $subject_load_id = $rows_subject_load['id'];

                        //$get_subject_details_query = mysqli_query($conn, "SELECT *, subjects.id AS subject_id, basic_info.id AS teacher_id FROM subject_loads LEFT JOIN subjects ON subject_loads.subject = subjects.id LEFT JOIN basic_info ON basic_info.id = subject_loads.teacher WHERE subject_loads.id = '$subject_load_id' AND subject_loads.acad_year = '$academic_year'");
                        $get_subject_details_query = mysqli_query($conn, "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id WHERE employment_informations.department = 5");
                        $subject_details_row = mysqli_fetch_assoc($get_subject_details_query);
                        // $sub_id = $subject_details_row['subject_id'];
                        // $sub_name = $subject_details_row['description'];

                        $teacher = $rows_subject_load['firstname'] . ' ' . $rows_subject_load['middlename'] . ' ' . $rows_subject_load['lastname'];

                        $isEvaluated = "No";
                        $btnDesc = "Evaluate";
                        $btnColor = "btn-info";
                        $disable = "";

                        $eval_check_query = mysqli_query($conn, "SELECT * FROM student_evaluation WHERE acad_year = '$academic_year' AND student_id = '$user_id;' AND teacher_id ='$teacher_id'");
                        if (mysqli_num_rows($eval_check_query) > 0) {
                          $isEvaluated = "Yes";
                          $btnDesc = "Evaluated";
                          $btnColor = "btn-success";
                          $disable = "disabled";
                        }



                        echo '
                              <tr>
                                <td><img src="../' . $rows_subject_load['photo_location'] . '" style="border-radius: 100%; width: 40px; height: 40px;"></td>
                                <td>' . $teacher . '</td>

                                <td>' . $isEvaluated . '</td>
                                <td>
                                  <form action="student_evaluation.php" method="POST">
                                    <input type="hidden" value="' . $rows_subject_load['id'] . '" name="id">
                                    <input type="hidden" value="A" name="subject_load_id">
                                    <input type="hidden" value="A" name="subject_id">
                                    <input type="hidden" value="A" name="subject_name">
                                    <button type="submit" class="btn cur-p ' . $btnColor . ' btn-color btn-sm" ' . $disable . '>' . $btnDesc . '</button>
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
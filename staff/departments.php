<?php
include('../dbconnection.php');
include('../session.php');
include('staff_session.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <link rel="stylesheet" href="../style.css">
  <title>Departments</title>
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
            <!-- <h4 class="c-grey-900 mT-10 mB-30">Departments</h4> -->

            <div class="row">
              <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                  <h4 class="c-grey-900 mB-20">List of Departments</h4>
                  <!--Modal-->
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add New Department</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="../backend_scripts/add_department.php" method="POST">
                            <div class="bgc-white p-20 bd">
                              <h6 class="c-grey-900">Department Name</h6>
                              <div class="mT-30">

                                <div class="mb-3">
                                  <input type="text" class="form-control" name="dept_name" aria-describedby="emailHelp" placeholder="Type Department Name">
                                </div>

                              </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!--Modal-->

                  <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th># of Employees</th>
                        <th>Option</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Name</th>
                        <th># of Employees</th>
                        <th>Option</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM departments ORDER BY dept_name ASC";
                      $query = mysqli_query($conn, $sql);
                      while ($rows = mysqli_fetch_assoc($query)) {
                        $id = $rows['id'];
                        echo '
                          <tr>
                          <td>' . $rows['dept_name'] . '</td>';
                        $total = 0;
                        $sql_get_num_emp = "SELECT COUNT(*) AS total_emp FROM employment_informations WHERE department = '" . $id . "'";
                        $res_num_emp = mysqli_query($conn, $sql_get_num_emp);

                        if (mysqli_num_rows($res_num_emp) > 0) {
                          $num_emp = mysqli_fetch_assoc($res_num_emp);
                          $total = $num_emp['total_emp'];
                        } else {
                          $total = 0;
                        }


                        echo '<td>' . $total . '</td>';

                        echo '
                          <td>

                            <a href="view_instructors.php?dept_id=' . $id . '" class="btn cur-p btn-info btn-sm btn-color"><i class="ti-user"></i> Instructors</a>
                            
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
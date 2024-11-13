<?php
  include('../dbconnection.php');
  include('../session.php');
  include('admin_session.php');
  $dep_id = $_GET['dept_id'];
  $sql_dept_name_query = mysqli_query($conn, "SELECT * FROM departments WHERE id = '$dep_id'");
  $sql_dept_name_query= mysqli_fetch_assoc($sql_dept_name_query);

  $dataPoints = array();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    
  <link rel="stylesheet" href="../style.css">
    <title><?php echo $sql_dept_name_query['dept_name']; ?></title>
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
<script src="../assets/canvas.min.js"></script>

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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bgc-white bd bdrs-3 p-20">
                                    <div class="col-md-12">
                                        <div id="chartContainer" style="height: 280px;"></div>
                                    </div>

                                    <h4 class="c-grey-900 mB-20">List of Instructors</h4>
                                    <div class="peer">
                                        <a href="add_employee.php" class="btn btn-sm cur-p btn-info btn-color">Add New
                                            Faculty</a>
                                    </div>
                                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Option</th>
                                                <th>Evaluation</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Option</th>
                                                <th>Evaluation</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT *, basic_info.id AS teacher_id FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id WHERE employment_informations.department = '$dep_id' ORDER BY lastname ASC";
                                                $query = mysqli_query($conn, $sql);
                                                while($rows = mysqli_fetch_assoc($query)){
                                                  echo '
                                                  <tr>
                                                  <td><img src="../'.$rows['photo_location'].'" style="border-radius: 100%; width: 40px; height: 40px;"></td>
                                                  <td>'.$rows['lastname'].', '.$rows['firstname'].' '.$rows['middlename'].'</td>
                                                  <td>'.$rows['dept_name'].'</td> 
                                                  <td>
                                                    <a href="profile.php?eid='.$rows['id'].'" class="btn cur-p btn-success btn-color btn-sm">View Profile</a>
                                                    <a href="" class="btn cur-p btn-danger btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#delete'.$rows['teacher_id'].'" >Delete Faculty</a>
                                                  </td> 
                                                  <td>
                                                    <form action="subject_evaluations.php" method="POST">
                                                      <input type="hidden" name="id" value="'.$rows['id'].'">
                                                      <button type="submit" class="btn cur-p btn-danger btn-color btn-sm">STUDENT</button>
                                                      <a href="p2p_evaluation_result.php?id='.$rows['id'].'" class="btn cur-p btn-info btn-color btn-sm">PEER</a>
                                                    </form>
                                                  </td>
                                                  </tr>
                                                  ';
                                                  $total_evaluators = 0;
                                                  $teacher_id = $rows['teacher_id'];

                                                  $get_total_evaluator = mysqli_query($conn, "SELECT * FROM student_evaluation WHERE teacher_id = '$teacher_id' GROUP BY student_id");
                                                  $total_evaluators = mysqli_num_rows($get_total_evaluator);

                                                  array_push($dataPoints, array("y" => $total_evaluators, "label" => $rows['lastname'].', '.$rows['firstname'].' '.$rows['middlename'] ));
                                                  

                                                  echo '
                                                  <div class="modal fade" id="delete'.$rows['teacher_id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel">Delete Faculty</h5>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                          <form action="../backend_scripts/delete_faculty.php" method="POST">
                                                            <h6 class="c-grey-900">Are you sure you want to delete '.$rows['lastname'].', '.$rows['firstname'].' '.$rows['middlename'].'</h6>
                                                            <div class="mT-30">
                                                              <input type="hidden" value="'.$rows['teacher_id'].'" name="id">
                                                              <input type="hidden" value="'.$dep_id.'" name="dept_id">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-secondary btn-color btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                          <button type="submit" class="btn btn-danger btn-color btn-sm">Delete</button>
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
<script>
window.onload = function() {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: "<?php echo $sql_dept_name_query['dept_name'];?>"
        },
        axisY: {
            title: "Total Evaluators"
        },
        data: [{
            type: "column",
            yValueFormatString: "# total evaluations",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

}
</script>

</html>
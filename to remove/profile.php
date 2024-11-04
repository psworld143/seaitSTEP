<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('dbconnection.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>Employee Profile</title>
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
    .emp_image{
      width: 100px;
      height: 100px;
      border-radius: 100%;
      margin-bottom: 2%;
    }
    td{
      text-align: left;
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
        <?php include('navbar.php'); ?>
        <?php
        $eid = $_GET['eid'];
        $sql = "SELECT *, YEAR(CURRENT_TIMESTAMP) - YEAR(birthdate) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(birthdate, 5)) as age  FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id LEFT JOIN identifications ON identifications.id = basic_info.id  WHERE basic_info.id = '$eid'";
        $query = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($query);
        ?>

        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="row gap-20 masonry pos-r">
              <div class="masonry-sizer col-md-6"></div>
              <div class="masonry-item col-md-6">
                <div class="bgc-white p-20 bd">
                  <img src="<?php echo $rows['photo_location']; ?>" class="emp_image">
                  <h6 class="c-grey-900">Basic Information</h6>
                  <div class="mT-30">

                    <table class="table table-striped">

                      <tbody>
                        <tr>

                          <td>Lastname</td>
                          <th scope="row"><?php echo $rows['lastname']; ?></th>               
                        </tr>
                        <tr>   
                          <td>Firstname</td>
                          <th scope="row"><?php echo $rows['firstname']; ?></th>
                        </tr>
                        <tr>
                          <td>Middlename</td>
                          <th scope="row"><?php echo $rows['middlename']; ?></th>
                        </tr>
                        <?php
                        $birthDate = $rows['birthdate'];
                        $birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $birthDate))))));
                        $today= new DateTime(date("Y-m-d"));           
                        $age = $birthdate->diff($today)->y +1;

                        
                        ?>
                        <tr>
                          <td>Age</td>
                          <th scope="row"><?php echo $age; ?></th>
                        </tr>
                        <tr>
                          <td>Birthdate</td>
                          <th scope="row"><?php echo $rows['birthdate']; ?></th>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Contact Information</h6>
                  <div class="mT-30">
                    <table class="table table-striped">

                      <tbody>
                        <tr>

                          <td>Phone Number</td>
                          <th scope="row"><?php echo $rows['mobile_number']; ?></th>               
                        </tr>
                        <tr>   
                          <td>Email Address</td>
                          <th scope="row"><?php echo $rows['email']; ?></th>
                        </tr>
                        <tr>
                          <td>City</td>
                          <th scope="row"><?php echo $rows['address1'].', '.$rows['address2']; ?></th>
                        </tr>
                        <tr>
                          <td>Municipality</td>
                          <th scope="row"><?php echo $rows['municipality']; ?></th>
                        </tr>
                        <tr>
                          <td>Provice</td>
                          <th scope="row"><?php echo $rows['province']; ?></th>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Identification Numbers</h6>
                  <div class="mT-30">
                    <table class="table table-striped">

                      <tbody>
                        <tr>

                          <td>Social Security System</td>
                          <th scope="row"><?php echo $rows['sss']; ?></th>               
                        </tr>
                        <tr>   
                          <td>PhilHealt</td>
                          <th scope="row"><?php echo $rows['phic']; ?></th>
                        </tr>
                        <tr>
                          <td>Pag-Ibig</td>
                          <th scope="row"><?php echo $rows['hdmf']; ?></th>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>


              <div class="masonry-item col-md-6">
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Employment Informations</h6>
                  <div class="mT-30">
                    <table class="table table-striped">

                      <tbody>
                        <tr>

                          <td>Status</td>
                          <th scope="row">
                            <?php
                            if($rows['status'] == 1){
                              echo 'Probationary';
                            }
                            else if($rows['status'] == 2){
                              echo 'Contractual';
                            }
                            else if($rows['status'] == 3){
                              echo 'Part Time';
                            }
                            else if($rows['status'] == 4){
                              echo 'Regular';
                            }

                            ?>
                            
                            <span style="width: 4px;"></span>
                            <button type="button" class="btn btn-info btn-color" data-bs-toggle="modal" data-bs-target="#exampleModal">Update Status</button>
                          </th>               
                        </tr>
                        <tr>   
                          <td>Date of Hire</td>
                          <th scope="row"><?php echo $rows['date_of_hire']; ?></th>

                        </tr>
                        <tr>
                          <td>Position</td>
                          <th scope="row"><?php echo $rows['position']; ?></th>
                        </tr>
                        <tr>
                          <td>Assignment</td>
                          <th scope="row"><?php echo $rows['dept_name']; ?></th>
                        </tr>
                      </tbody>
                    </table>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="update_emp_status.php" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Update Employee Status</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                             <div class="mb-3 col-lg-6">
                              <label class="form-label" for="inputState">Change Status</label>
                              <input type="hidden" name="emp_id" value="<?php echo $_GET['eid']; ?>">
                              <select id="inputState" name="status" class="form-control">
                                <option selected="selected">Choose...</option>
                                <option value="1">Probationary</option>
                                <option value="2">Contractual</option>
                                <option value="3">Part Time</option>
                                <option value="4">Regular</option>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>




                </div>
              </div>
            </div>

            <div class="masonry-item col-md-6">
              
              <div class="bgc-white p-20 bd">
                <h6 class="c-grey-900">Employee Sanctions</h6>
                <button type="button" class="btn btn-info btn-color" data-bs-toggle="modal" data-bs-target="#addSanctionModal">Add Report</button>
                <div class="mT-30">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">

                        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Action Taken</th>
                              <th>View</th>
                              
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Date</th>
                              <th>Action Taken</th>
                              <th>View</th>
                             
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php
                              $sql_report = "SELECT * FROM emp_report WHERE emp_id = ".$_GET['eid']."";
                              $res_report = mysqli_query($conn, $sql_report);
                              while($rows_report = mysqli_fetch_assoc($res_report)){
                                $reportdate = $rows_report['date_of_report'];
                                $action = $rows_report['action'];
                                $details = $rows_report['details'];
                                echo '
                                  <tr>
                                    <td>'.$reportdate.'</td>
                                    <td>'.$action.'</td>
                                    <td> <button type="button" class="btn btn-sm btn-danger btn-color" data-bs-toggle="popover" title="Report Details" 
                                    data-bs-content="'.$details.'">View Details</button>
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
                <div class="modal fade" id="addSanctionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="add_emp_report.php" method="POST">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Sanction</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="emp_id" value="<?php echo $_GET['eid']; ?>">
                          <label class="form-label fw-500">Incident Date</label>
                          <!--Date Picker-->
                          <div class="timepicker-input input-icon mb-3">
                            <div class="input-group">
                              <div class="input-group-text bgc-white bd bdwR-0">
                                <i class="ti-calendar"></i>
                              </div>
                              <input type="text" name="reportdate" class="form-control bdc-grey-200 start-date" placeholder="Date of Report" data-provide="datepicker">
                            </div>
                          </div>
                         
                          <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" name="details" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Details of Report</label>
                          </div>
                          <br>
                          <div class="mb-3 col-md-12">
                          <label class="form-label" for="inputState">Action Taken</label>
                          <select id="inputState" name="action" class="form-control">
                            <option selected="selected">Choose...</option>
                            <option value="Suspension">Suspension</option>
                            <option value="Resign">For to Resign</option>
                          </select>
                        </div>



                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Add Sanction</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div style="margin-top: 2%;">
          <center><a href="employees.php" class="btn btn-danger btn-color">CLOSE EMPLOYEE PROFILE</a></center>
        </div>



      </main>


      <!-- ### $App Screen Footer ### -->
      <?php include('footer.php'); ?>
    </div>
  </div>
</body>
</html>

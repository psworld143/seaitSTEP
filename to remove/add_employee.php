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
  <title>Add New Employee</title>
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
          <form action="add_new_employee.php" method="POST" enctype="multipart/form-data">
            <div id="mainContent">
              <div class="row gap-20 masonry pos-r">
                <div class="masonry-sizer col-md-6"></div>
                <div class="masonry-item col-md-6">
                  <div class="bgc-white p-20 bd">
                    <h6 class="c-grey-900">Basic Information</h6>
                    <div class="mT-30">
                      <?php
                            $rowID = 1;
                            $sqlID = "SELECT MAX(id)+1 AS nextID FROM basic_info";
                            $queryID = mysqli_query($conn, $sqlID);
                            $rows = mysqli_fetch_assoc($queryID);
                            $nextID = $rows['nextID'];
                            if($nextID == ''){
                              echo '<input type="hidden" value="1" name="emp_id">';
                            }else{
                              echo '<input type="hidden" value="'.$nextID.'" name="emp_id">';
                            }
                          ?>
                      

                      <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Lastname</label>
                        <input type="text" class="form-control" name="lastname" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Lastname" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Firstname</label>
                        <input type="text" class="form-control" name="firstname"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Firstname" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Middlename</label>
                        <input type="text" class="form-control" name="middlename" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Middlename" required>
                      </div>
                      <div class="mb-3 col-md-6">
                        <label class="form-label fw-500">Birthdate</label>
                        <div class="timepicker-input input-icon mb-3">
                          <div class="input-group">
                            <div class="input-group-text bgc-white bd bdwR-0">
                              <i class="ti-calendar"></i>
                            </div>
                            <input type="text" class="form-control bdc-grey-200 start-date"  name="birthdate"  placeholder="Birthdate" data-provide="datepicker" required>
                          </div>
                        </div>
                        <label class="form-label fw-500">Photo</label>
                          <input class="form-control" type="file"  name="photo" id="formFile" required>
                      </div>
                      

                    </div>
                  </div>
                </div>
                <div class="masonry-item col-md-6">
                  <div class="bgc-white p-20 bd">
                    <h6 class="c-grey-900">Contact Information</h6>
                    <div class="mT-30">

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label class="form-label" for="inputEmail4">Email</label>
                          <input type="email" class="form-control" name="email"  id="inputEmail4" placeholder="Email" required>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="form-label" for="inputPassword4">Mobile Number</label>
                          <input type="number" class="form-control" name="mobilenumber" id="inputPassword4" placeholder="Mobile Number" required>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="inputAddress">Address</label>
                        <input type="text" class="form-control" name="address"  id="inputAddress" placeholder="1234 Main St" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="inputAddress2">Address 2</label>
                        <input type="text" class="form-control" name="address2"  id="inputAddress2" placeholder="Apartment, studio, or floor" required>
                      </div>
                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label class="form-label" for="inputCity">Municipality</label>
                          <input type="text" class="form-control" name="municipality"  id="inputCity" required>
                        </div>
                        <div class="mb-3 col-md-4">
                          <label class="form-label" for="inputCity">Province</label>
                          <input type="text" class="form-control" name="province"  id="inputCity" required>
                        </div>
                        <div class="mb-3 col-md-2">
                          <label class="form-label" for="inputZip">Zip Code</label>
                          <input type="text" class="form-control" name="zipcode"  id="inputZip" required>
                        </div>
                      </div>
                      <div class="row">

                      </div>
                      
                      

                    </div>
                  </div>
                </div>

                <div class="masonry-item col-md-6">
                  <div class="bgc-white p-20 bd">
                    <h6 class="c-grey-900">Employment Informations</h6>
                    <div class="mT-30">
                      <label class="form-label fw-500">Date of Hire</label>
                      <div class="timepicker-input input-icon mb-3">
                        <div class="input-group">
                          <div class="input-group-text bgc-white bd bdwR-0">
                            <i class="ti-calendar"></i>
                          </div>
                          <input type="text" name="dateofhire"  class="form-control bdc-grey-200 start-date" placeholder="Date of Hire" data-provide="datepicker" required>
                        </div>
                      </div>


                      <div class="mb-3">
                        <label class="form-label" for="disabledTextInput">Position</label>
                        <input type="text" name="position"  id="disabledTextInput" class="form-control" placeholder="Position" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="disabledSelect">Department</label>
                        <select id="disabledSelect" name="department"  class="form-control" required>
                          <?php
                          $sql = "SELECT * FROM departments ORDER BY dept_name ASC";
                          $query = mysqli_query($conn, $sql);
                          while($rows = mysqli_fetch_assoc($query)){
                            echo '<option value="'.$rows['id'].'">'.$rows['dept_name'].'</option>';

                          }

                          ?>
                          
                        </select>
                      </div>




                    </div>
                  </div>
                </div>
                <div class="masonry-item col-md-6">
                  <div class="bgc-white p-20 bd">
                    <h6 class="c-grey-900">Identifications</h6>
                    <div class="mT-30">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationCustom01">Social Security System</label>
                          <input type="text" class="form-control" name="sss" id="validationCustom01" placeholder="SSS No." required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationCustom02">PhilHealth Number</label>
                          <input type="text" class="form-control" name="phic" id="validationCustom02" placeholder="PhilHealth Number" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationCustom03">HDMF No.</label>
                          <input type="text" class="form-control" name="hdmf" id="validationCustom03" placeholder="HDMF" required>
                          <div class="invalid-feedback">
                            Please provide a valid city.
                          </div>
                        </div>
                        
                        
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div style="margin-top: 2%;">
              <center><button type="submit" class="btn btn-primary btn-color">ADD NEW EMPLOYEE</button></center>
            </div>
          </form>


        </main>


        <!-- ### $App Screen Footer ### -->
        <?php include('footer.php'); ?>
      </div>
    </div>
  </body>
  </html>

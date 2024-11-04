<?php
  include('dbconnection.php');
  $dep_id = $_GET['dept_id'];
  $sql_dept_name_query = mysqli_query($conn, "SELECT * FROM departments WHERE id = '$dep_id'");
  $sql_dept_name_query= mysqli_fetch_assoc($sql_dept_name_query);


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
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
          <div id="mainContent">
            <div class="container-fluid">
              <h4 class="c-grey-900 mT-10 mB-30"><?php echo $sql_dept_name_query['dept_name']; ?></h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="bgc-white bd bdrs-3 p-20">
                    <h4 class="c-grey-900 mB-20">List of Instructors</h4>
                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                      <thead>
                        <tr>
                          <th>Photo</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Mobile Number</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Photo</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Mobile Number</th>
                          <th>Option</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                        $sql = "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id WHERE employment_informations.department = '$dep_id' ORDER BY lastname ASC";
                        $query = mysqli_query($conn, $sql);
                        while($rows = mysqli_fetch_assoc($query)){
                          echo '
                          <tr>
                          <td><img src="'.$rows['photo_location'].'" style="border-radius: 100%; width: 40px; height: 40px;"></td>
                          <td>'.$rows['lastname'].', '.$rows['firstname'].' '.$rows['middlename'].'</td>
                          <td>'.$rows['dept_name'].'</td> 
                          <td>'.$rows['mobile_number'].'</td> 
                          <td><a href="profile.php?eid='.$rows['id'].'" class="btn cur-p btn-success btn-color">View Profile</a></td> 
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

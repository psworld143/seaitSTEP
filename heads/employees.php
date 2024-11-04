<?php
  include('../dbconnection.php');
  include('../session.php');
  include('head_session.php');
  $dept_id = $_SESSION['dept_id'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Employees</title>
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
                    <h4 class="c-grey-900 mB-20">List of Faculty</h4>
                    <!-- <div class="peer">
                        <a href="add_employee.php" class="btn btn-sm cur-p btn-info btn-color">Add New Employee</a>
                    </div> -->
          
                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%" style="table-layout: fixed;">
                      <thead>
                        <tr>
                          <th width="18%">Photo</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Evaluation</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Photo</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Evaluation</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                        $sql = "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id WHERE employment_informations.department ='$dept_id'  ORDER BY lastname ASC";
                        $query = mysqli_query($conn, $sql);
                        while($rows = mysqli_fetch_assoc($query)){
                          //Decrypt
                          $simple_string = $rows['id'];//$_GET['id'];
                                                                    
                          // Store the cipher method
                          $ciphering = "AES-256-CTR";
                                                                       
                          // Use OpenSSl Encryption method
                          $iv_length = openssl_cipher_iv_length($ciphering);
                          $options = 0;
                                                                       
                          // Non-NULL Initialization Vector for encryption
                          $encryption_iv = '1234567891011121';
                                                                       
                          // Store the encryption key
                          $encryption_key = "Seait123";
                                                                       
                          // Use openssl_encrypt() function to encrypt the data
                          $encrypted_id = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);

                                                                       
                          // Non-NULL Initialization Vector for decryption
                          $decryption_iv = '1234567891011121';
                                                                       
                          // Store the decryption key
                          $decryption_key = "Seait123";
                                                                       
                          // Use openssl_decrypt() function to decrypt the data
                          $decrypted_id =openssl_decrypt ($simple_string, $ciphering, $decryption_key, $options, $decryption_iv);

                          $isEvaluated = "No";
                          $btnDesc = "Evaluate";
                          $btnColor = "btn-success";
                          $disable = "disabled";
                          $eval_check_query = mysqli_query($conn, "SELECT * FROM h2f_evaluation WHERE acad_year = '$academic_year' AND teacher_id = '".$rows['id']."' AND evaluator_id ='$user_id;'");
                            if(mysqli_num_rows($eval_check_query) > 0){
                              $isEvaluated = "Yes";
                              $btnDesc = "Evaluated";
                              $btnColor = "btn-success";
                              $disable = "disabled";
                            }


                          echo '
                          <tr>
                          <td width="10%"><img src="../'.$rows['photo_location'].'" style="border-radius: 100%; width: 40px; height: 40px;"></td>
                          <td>
                            <a href="profile.php?eid='.$encrypted_id.'">'.$rows['lastname'].', '.$rows['firstname'].' '.$rows['middlename'].'</a>
                          </td>
                          <td>'.$rows['dept_name'].'</td> 
                          <td>
                            <form action="subject_evaluations.php" method="POST">
                              <input type="hidden" name="id" value="'.$rows['id'].'">
                              <button type="submit" class="btn cur-p btn-danger btn-color btn-sm">STUDENT</button>
                              <a href="p2p_evaluation_result.php?id='.$encrypted_id.'" class="btn cur-p btn-info btn-color btn-sm">PEER</a>';

                              if($isEvaluated == "No"){
                                echo '<a href="head_evaluation.php?id='.$encrypted_id.'" class="btn cur-p btn-success btn-color btn-sm" style="margin-left: 1%;">'.$btnDesc.'</a>';
                              }
                              else{
                                echo '<button class="btn cur-p btn-warning btn-color btn-sm" '.$disable.' style="margin-left: 1%;">'.$btnDesc.'</button>'; 
                              }
                              

                            echo'
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
        </main>

        <!-- ### $App Screen Footer ### -->
        <?php include('footer.php'); ?>
      </div>
    </div>
  </body>
</html>

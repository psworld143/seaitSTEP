<?php
include('../dbconnection.php');
include('../session.php');
include('head_session.php');

$simple_string = $_GET['id'];
                                                                    
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

$id = $decrypted_id;
// $subject_load_id = $_POST['subject_load_id'];

$teacher = mysqli_query($conn, "SELECT * FROM basic_info LEFT JOIN employment_informations ON employment_informations.id = basic_info.id LEFT JOIN departments ON departments.id = employment_informations.department LEFT JOIN contact_information ON contact_information.id = basic_info.id WHERE basic_info.id = '$id'");
$row_teacher = mysqli_fetch_assoc($teacher);
$fullname = $row_teacher['firstname'].' '. $row_teacher['middlename'].' '.$row_teacher['lastname'];
$department = $row_teacher['dept_name'];
$photo = $row_teacher['photo_location'];
//Make it dynamic later
// $subject_id = $_POST['subject_id'];
// $sub_name = $_POST['subject_name'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>Evaluation</title>
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
    input#q156 {
      transform: scale(1.6);
      cursor: pointer;
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
        <?php include('../navbar.php'); ?>

        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="full-container">
              <div class="email-content-wrapper">

                <div class="peers ai-c jc-sb pX-40 pY-30">
                  <div class="peers peer-greed">
                    <div class="peer mR-20">
                      <img class="bdrs-50p w-3r h-3r" alt="" src="../<?php echo $photo; ?>">
                    </div>
                    <div class="peer">
                      <small><?php echo $department; ?></small>
                      <h5 class="c-grey-900 mB-5"><?php echo $fullname; ?></h5>
                      <!-- <span><?php //echo $sub_name; ?></span> -->
                    </div>
                  </div>
                  <div class="peer">
                    <a href="employees.php" class="btn btn-danger bdrs-50p p-15 lh-0">
                      <i class="fa fa-reply"></i>
                    </a>

                  </div>
                </div>

                <!--Modal-->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="../backend_scripts/add_new_specific_questionaire.php" method="POST">

                          <h6 class="c-grey-900">Function/Specific Task</h6>
                          <div class="mT-30">
                            
                              <div class="mb-3">                   
                                <input type="text" class="form-control" name="description"aria-describedby="emailHelp" placeholder="Type Task here">
                                <input type="hidden" class="form-control" name="teacher_id" value="<?php echo $_GET['id']; ?>" aria-describedby="emailHelp">
                              </div>  
                            
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-color btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-color btn-sm">Add New</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="bdT pX-40 pY-30">
                <form action="../backend_scripts/submit_h2f_evaluation.php" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4>INSTRUCTIONS</h4>
                        <p>
                          Employee Performance Appraisal shall be conducted periodically and designed to measure the effectiveness of South East Asian Institute of Technology Inc. Employee in performing his assigned duties and responsibilities. This shall also serve as a tool in pinpointing their performance deficiencies.
                        </p>
                        
                      </div>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Rating scale is as follows:</h4>
                        <p><b>Employees shall be rated using the range of 5 to 1 as 5 as the highest and 1 as the lowest rating.</b></p>
                        <table class="table table-striped">

                          <tbody>
                            <tr>
                              <th scope="row">(1) Fail</th>
                              <td>The Instructor does not demonstrates this behavior at all.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(2) Poor</th>
                              <td>The Instructor demonstrates this behavior rarely/not at all.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(3) Satisfactory</th>
                              <td>The Instructor demonstrates this behavior sometimes.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(4) Very Satisfactory</th>
                              <td>The Instructor demonstrates this behavior most of the times.</td>
                            </tr> 
                            <tr>
                              <th scope="row">(5) Outstanding</th>
                              <td>The Instructor demonstrates this behavior all the times.</td>
                            </tr> 
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <?php
                          $categories = mysqli_query($conn, "SELECT * FROM h2f_category ORDER BY added ASC");
                          $count = 0;
                          while($cat_rows = mysqli_fetch_assoc($categories)){
                            $cat_id = $cat_rows['id'];
                            echo '
                            <div class="col-md-12">
                              <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <h4 class="c-grey-900 mB-20">'.$cat_rows['cat_name'].'</h4>
                                  <table class="table">
                                  <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"></th>
                                        <th scope="col"><center>1</center></th>
                                        <th scope="col"><center>2</center></th>
                                        <th scope="col"><center>3</center></th>
                                        <th scope="col"><center>4</center></th>
                                        <th scope="col"><center>5</center></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                ';
                                    $questions = mysqli_query($conn, "SELECT * FROM h2f_questionaires WHERE cat_id='$cat_id' ORDER BY added ASC");
                                    $q_number = 0;
                                    while($row_question = mysqli_fetch_assoc($questions)){
                                      $q_id = $row_question['id'];
                                      $q_number+=1;
                                      echo '
                                      <tr>
                                        <td><span class="badge rounded-pill fl-l bg-success lh-0 p-10">'.$q_number.'</badge></td>
                                        <td><b>'.$row_question['description'].'</b></td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="1" required>  
                                          </center>
                                        </td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="2" required>
                                          </center>
                                        </td>
                                        <td> 
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="3" required> 
                                          </center>
                                        </td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="4" required>  
                                          </center>     
                                        </td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id.'" value="5" required>  
                                          </center>     
                                        </td>
                                      </tr>

                                      ';
                                    }
                            echo' 
                                    </tbody>
                                  </table>   
                              </div>
                            </div>

                            ';
                            
                          }
                          
                        ?>
                  </div>
                  <div class="row">
               
                         
                            <div class="col-md-12">
                              <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <h4 class="c-grey-900 mB-20">Functions/Specific Tasks</h4>
                                <button type="button" class="btn cur-p btn-info btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-bottom: 2%;">Add New Function/Specific Task </button>
                                  <table class="table">
                                  
                                <?php
                                    $questions_a = mysqli_query($conn, "SELECT * FROM h2f_questionaires WHERE cat_id='0' AND added_by = '".$_SESSION['user_id']."' ORDER BY added ASC");
                                    $q_number_a = 0;
                                    if(mysqli_num_rows($questions_a) > 0){
                                      echo '
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col"></th>
                                            <th scope="col"><center>1</center></th>
                                            <th scope="col"><center>2</center></th>
                                            <th scope="col"><center>3</center></th>
                                            <th scope="col"><center>4</center></th>
                                            <th scope="col"><center>5</center></th>
                                          </tr>
                                        </thead>
                                    <tbody>

                                      ';

                                    }
                                    while($row_question_a = mysqli_fetch_assoc($questions_a)){
                                      $q_id_a = $row_question_a['id'];
                                      $q_number_a+=1;
                                      echo '
                                      <tr>
                                        <td><span class="badge rounded-pill fl-l bg-success lh-0 p-10">'.$q_number_a.'</badge></td>
                                        <td><b>'.$row_question_a['description'].'</b> <span><button  type="button" class="btn cur-p btn-danger btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#delete'.$q_id_a.'" ><i class="c-white-500 ti ti-trash "></i></button></span></td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id_a.'" value="1" required>  
                                          </center>
                                        </td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id_a.'" value="2" required>
                                          </center>
                                        </td>
                                        <td> 
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id_a.'" value="3" required> 
                                          </center>
                                        </td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id_a.'" value="4" required>  
                                          </center>     
                                        </td>
                                        <td>
                                          <center>
                                            <input class="form-check-input" id="q156" type="radio" name="q'.$q_id_a.'" value="5" required>  
                                          </center>     
                                        </td>
                                      </tr>

                                      <div class="modal fade" id="delete'.$q_id_a.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Remove Question</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                             

                                                <h6 class="c-grey-900">Do you want to remove this question?</h6>
                                                <div class="mT-30">
                                                
                                                    
                                                  
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary btn-color btn-sm" data-bs-dismiss="modal">Cancel</button>
                                              <a href="../backend_scripts/delete_specific_questionaire.php?id='.$q_id_a.'&fid='.$_GET['id'].'" class="btn btn-danger btn-color btn-sm">Remove</a>
                                            </div>
                                            
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
                  <div class="row">
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mB-20">Recommended Areas for improvement</h4>
                        <div class="layer w-100">
                          <div class="p-20 bdT bgc-white">
                            <div class="pos-r">
                              <input type="text" name="comment" class="form-control bdrs-10em m-0" placeholder="Say something..." required>
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <div class="layer w-100">                        
                          <div class="p-20 bdT bgc-white">
                            <center>Thank you for taking the time to answer this.</center>
                            <center>Your responses will be confidential, and will not affect your grades.</center>
                            <div class="pos-r">
                            <br>                             
                              <center>
                                <input type="hidden" name="teacher_id" value="<?php echo $id;?>">
                                <!-- <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                                <input type="hidden" name="subject_load_id" value="<?php echo $subject_load_id; ?>"> -->
                                <button type="submit" class="btn btn-primary btn-color">
                                 <i class="fa fa-paper-plane-o"></i>
                                  SUBMIT EVALUATION
                                </button>
                              </center>
                           </div>
                         </div>
                       </div>                    
                     </div>
                   </div>                 
                 </div>
               </form>
               </div>


             </div>
           </div>
         </main>

         <!-- ### $App Screen Footer ### -->
         <?php //include('footer.php'); ?>
       </div>
     </div>
     <?php
        $questions_a1 = mysqli_query($conn, "SELECT * FROM h2f_questionaires WHERE cat_id='0' AND added_by = '".$_SESSION['user_id']."' ORDER BY added ASC");
        $q_number_a1 = 0;
        if(mysqli_num_rows($questions_a1) > 0){
          echo '
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col"></th>
                <th scope="col"><center>1</center></th>
                <th scope="col"><center>2</center></th>
                <th scope="col"><center>3</center></th>
                <th scope="col"><center>4</center></th>
                <th scope="col"><center>5</center></th>
              </tr>
            </thead>
        <tbody>

          ';

        }
        while($row_question_a1 = mysqli_fetch_assoc($questions_a)){
          $q_id_a1 = $row_question_a['id'];
          $q_number_a1+=1;
          echo '
          
          <div class="modal fade" id="delete'.$q_id_a1.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Remove Question</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                 

                    <h6 class="c-grey-900">Do you want to remove this question?</h6>
                    <div class="mT-30">
                    
                        
                      
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-color btn-sm" data-bs-dismiss="modal">Cancel</button>
                  <a href="../backend_scripts/delete_specific_questionaire.php?id='.$q_id_a1.'&fid='.$id .'" class="btn btn-danger btn-color btn-sm">Remove</a>
                </div>
                
              </div>
            </div>
          </div>

          ';



        }
        ?>
   </body>
   
  
   </html>

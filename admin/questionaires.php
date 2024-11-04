<?php
include('../dbconnection.php');
include('../session.php');
include('admin_session.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Questionaires</title>
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
        <?php include('../navbar.php'); ?>

        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="row">
                <div class="col-md-12">
                  <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h4 class="c-grey-900 mB-20">Evaluation Questionaires</h4>
                    <button type="button" class="btn cur-p btn-info btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-bottom: 2%;">Add New </button>
                    <!--Modal-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Questionaire</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="../backend_scripts/add_new_questionaire.php" method="POST">
    
                              <h6 class="c-grey-900">Questioanire</h6>
                              <div class="mT-30">
                                <div class="mb-3">
                                  <label class="form-label" for="inputState">Question Category</label>
                                  <select id="inputState" name="cat_id" class="form-control">
                                    <?php
                                      $cat = mysqli_query($conn, "SELECT * FROM category ORDER BY added ASC");
                                      while($category_rows = mysqli_fetch_assoc($cat)){
                                        echo '<option value="'.$category_rows['id'].'">'.$category_rows['cat_name'].'</option>';
                                      }
                                    ?>
                                    
                                  </select>
                                </div>
                                
                                  <div class="mb-3">   
                                  <label class="form-label" for="ques">Questionaire</label>                
                                    <textarea type="text" id="ques" class="form-control" name="description" aria-describedby="emailHelp" placeholder="Type Criteria Here"></textarea>
                                  </div>  
                                
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-color btn-sm">Add New</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    
                        <?php
                          $categories = mysqli_query($conn, "SELECT * FROM category ORDER BY added ASC");
                          $count = 0;
                          while($cat_rows = mysqli_fetch_assoc($categories)){
                            $cat_id = $cat_rows['id'];
                            echo '
                            <div class="col-md-12">
                              <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <h4 class="c-grey-900 mB-20">'.$cat_rows['cat_name'].'</h4>
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Questionaire</th>
                                        <th scope="col">Options</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                ';
                                    $questions = mysqli_query($conn, "SELECT * FROM questionaires WHERE cat_id='$cat_id' ORDER BY added ASC");
                                    $q_number = 0;
                                    while($row_question = mysqli_fetch_assoc($questions)){
                                      $q_number+=1;
                                      echo '
                                      <tr>
                                        <td><span class="badge rounded-pill fl-l bg-success lh-0 p-10">'.$q_number.'</badge></td>
                                        <td>'.$row_question['description'].'</td>
                                        <td>
                                          <button type="button" class="btn cur-p btn-info btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#edit'.$row_question['id'].'"><i class="ti-pencil-alt2"></i></button>
                                          <div class="modal fade" id="edit'.$row_question['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                  <form action="../backend_scripts/edit_questionaire.php" method="POST">
                          
                                                    <div class="mT-30">
                                                        <div class="mb-3">  
                                                        <input type="hidden" name="id" value="'.$row_question['id'].'"> 
                                                        <label class="form-label" for="ques">Question</label>                
                                                          <textarea type="text" id="ques" class="form-control" name="description" value="" aria-describedby="emailHelp">'.$row_question['description'].'</textarea>
                                                        </div>  
                                                      
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Cancel</button>
                                                  <button type="submit" class="btn btn-primary btn-sm btn-color">Save</button>
                                                </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>


                                          <button type="button" class="btn cur-p btn-danger btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#delete'.$row_question['id'].'"><i class="ti-trash"></i></button>
                                          <div class="modal fade" id="delete'.$row_question['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Delete Question</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="../backend_scripts/delete_questionaire.php" method="POST">
                                                    <div class="mb-3">   
                                                      Are you sure? you want to delete this question?
                                                      <input type="hidden" name="id" value="'.$row_question['id'].'">
                                                    </div>  
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Cancel</button>
                                                  <button type="submit" class="btn btn-danger btn-color btn-sm">Delete</button>
                                                </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>

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

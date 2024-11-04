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
    <title>Peer to Peer Evaluation Category</title>
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
                    <h4 class="c-grey-900 mB-20">Peer to Peer Evaluation Category</h4>
                    <button type="button" class="btn cur-p btn-info btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-bottom: 2%;">Add New </button>
                    <!--Modal-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="../backend_scripts/add_new_p2p_category.php" method="POST">
    
                              <h6 class="c-grey-900">Category Name</h6>
                              <div class="mT-30">
                                
                                  <div class="mb-3">                   
                                    <input type="text" class="form-control" name="category_name"aria-describedby="emailHelp" placeholder="Type Category Name">
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
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Category Name</th>
                          <th scope="col">Total Questions</th>
                          <th scope="col">Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $categories = mysqli_query($conn, "SELECT * FROM p2p_category ORDER BY added ASC");
                          $count = 0;
                          while($cat_rows = mysqli_fetch_assoc($categories)){
                            $count +=1;
                            $id = $cat_rows['id'];
                            $cat_count = 0;
                            $total_questions = mysqli_query($conn, "SELECT COUNT(*) AS total_questionaires FROM p2p_questionaires WHERE cat_id = '$id'");
                            if(mysqli_num_rows($total_questions) > 0){
                              $questions = mysqli_fetch_assoc($total_questions);
                              $cat_count = $questions['total_questionaires'];
                            }
                            else{
                              $cat_count = 0;
                            }
                            echo '
                            <tr>
                              <th scope="row"><span class="badge rounded-pill fl-l bg-info lh-0 p-10">'.$count.'</span></th>
                              <td>'.$cat_rows['cat_name'].'</td>
                              <td><span class="badge rounded-pill fl-l bg-success lh-0 p-10">'.$cat_count.'</span></td>
                              <td>
                              <button type="button" class="btn cur-p btn-danger btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#delete'.$id .'" style="margin-bottom: 2%;">DELETE</button>
                                  <!--Modal-->
                                  <div class="modal fade" id="delete'.$id .'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="../backend_scripts/delete_p2p_category.php" method="POST">
                  
                                            <h6 class="c-grey-900">Are you sure you want to delete '.$cat_rows['cat_name'].'</h6>
                                            <div class="mT-30">
                                              
                                                <div class="mb-3">                   
                                                  <input type="hidden" class="form-control" value="'.$id .'" name="category_id"aria-describedby="emailHelp" placeholder="Type Category Name">
                                                </div>  
                                              
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

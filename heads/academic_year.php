<?php

include('../dbconnection.php');
include('../session.php');
include('head_session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>Academic Year</title>
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
            <div class="container-fluid">
              <!-- <h4 class="c-grey-900 mT-10 mB-30">Departments</h4> -->
              
              <div class="row">
                <div class="col-md-12">
                  <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <h4 class="c-grey-900 mB-20">List of Academic Years</h4>
                    <!-- <button type="button" class="btn cur-p btn-info btn-sm btn-color" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-bottom: 2%;">Add New </button> -->
                    <!--Modal-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Academic Year</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="../backend_scripts/add_academic_year.php" method="POST">
                            <div class="bgc-white p-20 bd">
                              <h6 class="c-grey-900">Academic Year</h6>
                              <div class="mb-3 col-md-12">
                                
                                  <div class="mb-3">                   
                                    <input type="text" class="form-control" name="acad_year" aria-describedby="emailHelp" placeholder="Type Academic Year Name" required>
                                  </div>  
                                
                              </div>
                              <div class="mb-3 col-md-12">
                                <label class="form-label" for="inputState">Semester</label>
                                <select id="inputState" class="form-control" name="semester" required>
                                  <option selected="selected" value="">Choose Semester</option>
                                  <option value="First Semester">First Semester</option>
                                  <option value="Second Semester">Second Semester</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-color btn-sm">Add</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Modal-->

                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%" >
                      <thead>
                        <tr>
                          <th>Academic Year</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Academic Year</th>
                          <th>Option</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                        $sql = "SELECT * FROM academic_year ORDER BY id DESC";
                        $query = mysqli_query($conn, $sql);
                        while($rows = mysqli_fetch_assoc($query)){
                          $id = $rows['id'];

                          echo '<td>'.$rows['acad_year'].' - '.$rows['semester'].'</td>'; 
                          
                          echo '
                          <td>

                            <button type="button" class="btn cur-p btn-success btn-color btn-sm" data-bs-toggle="modal" data-bs-target="#active'.$id.'"><i class="ti-export"></i> Open</button>
                                          <div class="modal fade" id="active'.$id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Open academic year</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="../backend_scripts/change_acadyear_heads.php" method="POST">
                                                    <div class="mb-3">   
                                                      Are you sure? you want to open this academic year?
                                                      <input type="hidden" name="id" value="'.$id.'">
                                                    </div>  
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary btn-color btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                  <button type="submit" class="btn btn-danger btn-color btn-sm">Open</button>
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
          </div>
        </main>

        <!-- ### $App Screen Footer ### -->
        <?php include('footer.php'); ?>
      </div>
    </div>
  </body>
  </html>

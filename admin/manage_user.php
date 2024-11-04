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
    <link rel="stylesheet" href="../style.css">
    <title>User Management</title>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bgc-white bd bdrs-3 p-20">
                                    <div class="peer">
                                        <button type="button" class="btn btn-primary btn-sm btn-color"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Add New User
                                        </button>
                                        <?php include('notification.php'); ?>

                                    </div>
                                    <h4 class="c-grey-900 mB-20">List of Users</h4>

                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="../backend_scripts/add_system_user.php">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">System User</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="usertype">Usertype</label>
                                                            <select id="usertype" name="usertype" class="form-control"
                                                                required onchange="showDept()">
                                                                <option value="">Select Below</option>
                                                                <option value="1">Guidance Office</option>
                                                                <option value="2">Admin Department</option>
                                                                <option value="4">Department Head</option>
                                                            </select>
                                                        </div>
                                                        <!-- Dept Head -->
                                                        <div id="dept" class="mb-3" style="display: none;">
                                                            <label class="form-label" for="usertype">Department</label>
                                                            <select id="usertype" name="department"
                                                                class="form-control">
                                                                <option value="">Select Below</option>

                                                                <?php
                                                                  $dept_query = mysqli_query($conn, "SELECT * FROM departments ORDER BY dept_name ASC");
                                                                  while($dep_row = mysqli_fetch_assoc($dept_query)){
                                                                    echo '<option value="'.$dep_row['id'].'">'.$dep_row['dept_name'].'</option>';
                                                                  }

                                                                ?>

                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="exampleInputEmail1">Email</label>
                                                            <input type="email" value="" class="form-control"
                                                                name="email" id="exampleInputEmail1"
                                                                aria-describedby="emailHelp" placeholder="Email">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="exampleInputEmail1">Firstname</label>
                                                            <input type="text" class="form-control" name="firstname"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                placeholder="Firstname" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="exampleInputEmail1">Lastname</label>
                                                            <input type="text" class="form-control" name="lastname"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                placeholder="Lastname" required>
                                                        </div>
                                                        <!-- guidance -->
                                                        <div id="userDetails" style="display:none;">

                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="exampleInputEmail1">Password</label>
                                                                <input type="pasword" class="form-control"
                                                                    name="password" id="exampleInputEmail1"
                                                                    aria-describedby="emailHelp" placeholder="Password">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="exampleInputEmail1">Confirm Password</label>
                                                                <input type="password" class="form-control"
                                                                    name="password1" id="exampleInputEmail1"
                                                                    aria-describedby="emailHelp"
                                                                    placeholder="Confirm Password">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm btn-color"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit"
                                                            class="btn btn-primary btn-color btn-sm">Add User</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="dataTable" class="table table-striped table-bordered" cellspacing="0"
                                        width="100%" style="table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th>Option</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                          $get_users = mysqli_query($conn, "SELECT * FROM step_users WHERE usertype != 3 ORDER BY lastname ASC");
                          
                          while($row_users = mysqli_fetch_assoc($get_users)){
                            $user_id = $row_users['id'];
                            $dept_id = $row_users['dept'];
                            $usertype = $row_users['usertype'];
                            $department = "Guidance Office";
                            $email_add = "Not Available";
                            $email = $row_users['email'];
                            if($email == ' ' || is_null($email)){
                              $email_add = "Not Available";
                            }
                            else{
                              $email_add = $row_users['email'];
                            }
                            
                            if($usertype == 4){
                              $get_dept = mysqli_query($conn, "SELECT * FROM departments WHERE id ='$dept_id'");
                              if(mysqli_num_rows($get_dept) > 0){
                                $dept_row = mysqli_fetch_assoc($get_dept );
                                $department = $dept_row['dept_name'];
                              }
                            }
                            else if($usertype == 2){
                              $department = "Admin Department";

                            }
                            else{
                              
                              $department = "Guidance Office";
                            }
                            echo '
                              <tr>
                                <td>'.$row_users['firstname'].', '.$row_users['lastname'].'</td>
                                <td>'.$email_add.'</td>
                                <td>'.$department.'</td>
                                <td>
                                  <button type="button" class="btn btn-danger btn-sm btn-color" data-bs-toggle="modal" data-bs-target="#deleteUser'.$user_id.'">
                                    Remove
                                  </button>
                                  <div class="modal fade" id="deleteUser'.$user_id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <form action="../backend_scripts/delete_admin_user.php" method="POST">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Remove User</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          Do you want to remove '.$row_users['firstname'].', '.$row_users['lastname'].'?
                                          <input type="hidden" value="'.$user_id .'" name="user_id">
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-danger btn-color btn-sm btn-color">Remove</button>
                                        </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                  <button type="button" class="btn btn-success btn-sm btn-color" data-bs-toggle="modal" data-bs-target="#resetUser'.$user_id.'">
                                    Reset
                                  </button>
                                  <div class="modal fade" id="resetUser'.$user_id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <form action="../backend_scripts/reset_admin_user.php" method="POST">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Reset User Password</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          Do you want to reset '.$row_users['firstname'].', '.$row_users['lastname'].' password to Seait123?
                                          <input type="hidden" value="'.$user_id .'" name="user_id">
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-danger btn-color btn-sm">Reset</button>
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
        </div>
    </div>
</body>
<script type="text/javascript">
function showDept() {
    selectElement = document.querySelector('#usertype');

    var dept = document.getElementById("dept");
    var details = document.getElementById("userDetails");

    output = selectElement.options[selectElement.selectedIndex].value;

    if (output == 4) {
        dept.style.display = "block";
        details.style.display = "none";
    } else if (output == 1) {
        details.style.display = "block";
        dept.style.display = "none";

    } else {
        dept.style.display = "none";
        details.style.display = "none";
    }
    //
}
</script>

</html>
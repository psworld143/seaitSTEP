<?php  
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>SEAIT-STEP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    
</head>
<style type="text/css">
    .card-container{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .card-img-top{
        margin: auto;
        margin-top: 2%;
        margin-bottom: 2%;
        -webkit-animation: mover 2s infinite alternate;
        animation: mover 1s infinite alternate;
    }
    @-webkit-keyframes mover {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-20px);
        }
    }

    @keyframes mover {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-20px);
        }
    }
</style>

<script defer="defer" src="assets/main.js"></script>
<body>
    <div id="loader">
      <div class="spinner"></div>
  </div>

  <script>
      window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
          loader.classList.add('fadeOut');
      }, 500);
    });
</script>
<main class="main-content bgc-grey-100 " style="align-content: center; ">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="masonry-item col-md-4">
            <div class="bgc-white p-20 bd">
               <center><img class="card-img-top" src="images/guidance_logo.png" alt="Card image cap" style="width: 120px; height: 120px;"></center>
               <div class="card-body">
                <div class="bgc-white p-20" style="border-radius: 2%;">
                    <div class="mT-30">
                        <form action="backend_scripts/add_new_user.php" method="POST">
                            <div class="row" style="margin-top: -1%;">
                                <center><h4>User Registration</h4></center>
                                <fieldset class="mb-3">
                                    <center>
                                        <div class="row">
                                    <!--      <div class="col-md-4">-->
                                    <!--        <div class="form-check">-->
                                    <!--          <label class="form-label form-check-label">-->
                                    <!--            <input class="form-check-input" type="radio" name="usertype" id="gridRadios1" value="3" required>-->
                                    <!--            Student-->
                                    <!--        </label>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="col-md-4">
                                        <div class="form-check">
                                          <label class="form-label form-check-label">
                                            <input class="form-check-input" type="radio" name="usertype" id="gridRadios1" value="2" required>
                                            Instructor
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                      <label class="form-label form-check-label">
                                        <input class="form-check-input" type="radio" name="usertype" id="gridRadios1" value="1" required>
                                        Staff
                                    </label>
                                </div>
                            </div>
                        </div>
                    </center>
                </fieldset>
                <div class="mb-3 col-md-12">
                    <label class="form-label" for="inputEmail4">Email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="inputEmail4">Password</label>
                    <input type="password" name="password" class="form-control" id="inputEmail4" placeholder="Password" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="inputPassword4">Confirm Password</label>
                    <input type="password" name="password1" class="form-control" id="inputPassword4" placeholder="Confirm Password" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="inputEmail4">School ID No.</label>
                    <input type="text" name="school_id" class="form-control" id="inputEmail4" placeholder="School ID No." required>
                </div>
                <div class="mb-3 col-md-12">
                    <label class="form-label" for="inputEmail4">Lastname</label>
                    <input type="text" name="lastname" class="form-control" id="inputEmail4" placeholder="Lastname" required>
                </div>
                <div class="mb-3 col-md-12">
                    <label class="form-label" for="inputEmail4">Firstname</label>
                    <input type="text" name="firstname" class="form-control" id="inputEmail4" placeholder="Firstname" required>
                </div>
                <div class="mb-3 col-md-12">
                    <div class="checkbox checkbox-info peers ai-c">
                      <input type="checkbox" id="inputCall2" name="terms" value="1" class="" required>
                      <label for="inputCall2" class="form-label peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">I accept the terms and conditions governing the use of this platform.</span>
                    </label>
                </div>
            </div>
            <?php include('index_notification.php');?>
            <center><button type="submit" class="btn btn-primary btn-color" style="width:90%;">SIGNUP</button></center>
        </div>
    </form>
</div>
<br>
<br>
<center>Do you have an account? Login <a href="index.php" id="login">here</a></center>


</div>
</div>
</div>
</div>
</div>
</main>

</body>
</html>
<?php
session_destroy();

?>
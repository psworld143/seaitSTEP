<?php  
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>SEAIT-STEP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style type="text/css">
.card img {
    margin: auto;
    margin-top: 15%;
    margin-bottom: 2%;
    width: 30%;
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

.modala {

    display: none;
    /* Hidden by default */

    position: fixed;
    /* Stay in place */

    z-index: 2;
    /* Sit on top */

    left: 0;

    top: 0;

    width: 100%;

    height: 100%;

    background-color: rgba(0, 0, 0, 0);
    /* Black with opacity */

}


.modala-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
}

.closea {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

/* Background image container */
.background-image {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('images/faculty1.png');
    /* Replace with your image path */
    background-size: cover;
    background-position: center;
    z-index: -1;
}

/* Gradient overlay */
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg,
            rgba(2, 0, 36, 0.7) 0%,
            /* Dark blue with 70% opacity */
            rgba(141, 222, 238, 0.6) 0%,
            /* Light blue with 60% opacity */
            rgba(231, 197, 128, 0.5) 21%,
            /* Light orange with 50% opacity */
            rgba(241, 182, 62, 0.6) 100%
            /* Orange with 60% opacity */
        );
}

/* Card Container Styling */
.card-container {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    /* Align to the right */
    height: 100vh;
    position: relative;
    z-index: 1;
    padding-right: 70px;
    /* Optional: add some padding from the right edge */
}

/* Card Styling */
.card {
    background-color: rgba(255, 255, 255, 0.6);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 24rem;
    /* You can keep this or adjust as necessary */
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

    <!-- Background Video
    <video class="bg-video" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
        <source src="video/bg.mp4" type="video/mp4" />
    </video>-->

    <!-- Background Image with Gradient Overlay -->
    <div class="background-image">
        <div class="overlay"></div>
    </div>

    <!-- Login Card Container -->
    <div class="card-container">
        <div class="card" style="width: 24rem;">
            <img class="card-img-top" src="images/guidance_logo1.png" alt="Card image cap">
            <div class="card-body">
                <div class="bgc-white p-20" style="border-radius: 2%;">
                    <center>
                        <h6 class="c-grey-900">Login to continue</h6>
                    </center>
                    <form action="backend_scripts/user_login.php" method="POST" autocomplete="false">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="text" name="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Username">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="ti ti-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                placeholder="Password">
                        </div>
                        <?php include('index_notification.php'); ?>
                        <button type="submit" class="btn btn-primary btn-color" style="width:100%;">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="myModala" class="modala">

        <div class="modala-content" style="width: 280px;">

            <span class="closea">&times;</span>
            <center>
                <h4>Forgot Password?</h4>
                <hr>
                <div style="display: none;" id="error_email">
                    <center style="color: red;">Email provided is invalid or does not exist!</center>
                </div>
                <div style="display: none;" id="error_code">
                    <center style="color: red;">Invalid Reset Code</center>
                </div>
                <br>
                <form id="email_form" class="form-signin" method="post">
                    <center>Please type your email for reset code</center>
                    <input type="text" class="input-block-level" id="email" name="email" placeholder="Username"
                        required>
                    <button data-placement="right" title="" id="send_email" name="send_email" class="badge btn-warning"
                        type="submit" style="border: none; width: 100%;height: 36px;"><i
                            class="icon-signin icon-large"></i> Send</button>
                </form>
                <form id="code_form" class="form-signin" method="post" style="display: none;">
                    <center>Please check your email and enter the reset code</center>
                    <input type="number" class="input-block-level" id="reset_code" name="reset_code"
                        placeholder="Reset Code" required>
                    <button data-placement="right" title="" id="reset_code" name="reset_code" class="badge btn-warning"
                        type="submit" style="border: none; width: 100%;height: 36px;"><i
                            class="icon-signin icon-large"></i> Verify</button>
                </form>
                <form id="password_form" class="form-signin" method="post" style="display: none;">
                    <center>Please enter new password</center>
                    <input type="password" class="input-block-level" id="new_password" name="new_password"
                        placeholder="" required>
                    <center><input type="checkbox" onclick="myFunctionReset()" style="margin-bottom: 2%;"> Show Password
                    </center>
                    <button data-placement="right" title="" id="change_pass" name="change_pass"
                        class="badge btn-warning" type="submit" style="border: none; width: 100%;height: 36px;"><i
                            class="icon-signin icon-large"></i> Change</button>
                </form>

            </center>

            <div />
        </div>

</body>

</html>
<?php
    session_destroy();

?>
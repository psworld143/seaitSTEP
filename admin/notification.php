<?php
// session_start();
if (isset($_SESSION['success'])) {
    echo '
        <div class="alert alert-success" role="alert" id="notification">
        <button type="button" class="btn-close" aria-label="Close" onclick="closeNotif()"></button>
            '.$_SESSION['success'].'
        </div>
    ';
    unset($_SESSION['success']);
}
else if (isset($_SESSION['error'])) {
    echo '
        <div class="alert alert-danger" role="alert" id="notification">
        <button type="button" class="btn-close" aria-label="Close" onclick="closeNotif()"></button>
            '.$_SESSION['error'].'
        </div>
    ';
    unset($_SESSION['error']);
    
}


?>
<script type="text/javascript">
function closeNotif() {
  var x = document.getElementById("notification");
  x.style.display = "none";
  
}
    
</script>
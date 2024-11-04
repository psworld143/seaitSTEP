<?php
if (isset($_SESSION['index_success'])) {
    echo '
        <script>
            Swal.fire({
              title: "Success",
              text: "'.$_SESSION['index_success'].'",
              icon: "success"
            });
        </script>
    ';
    unset($_SESSION['index_success']);
}
else if (isset($_SESSION['index_error'])) {
    echo '
        <script>
            Swal.fire({
              title: "Error",
              text: "'.$_SESSION['index_error'].'",
              icon: "error"
            });
        </script>
    ';
    unset($_SESSION['index_error']);
       
}

?>
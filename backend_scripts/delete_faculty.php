<?php
include('../dbconnection.php');
if(isset($_POST['id'])){
    $dept_id = $_POST['dept_id'];
    $emp_id = $_POST['id'];
    
    mysqli_query($conn, "DELETE FROM basic_info WHERE id = '$emp_id'");
    mysqli_query($conn, "DELETE FROM contact_information WHERE id = '$emp_id'");
    mysqli_query($conn, "DELETE FROM employment_informations WHERE id = '$emp_id'");
    mysqli_query($conn, "DELETE FROM contact_information WHERE id = '$emp_id'");
    mysqli_query($conn, "DELETE FROM identifications WHERE id = '$emp_id'");
    
}

?>
<script>
    window.location.href="../admin/view_instructors.php?dept_id=<?php echo $dept_id;?>";
</script>
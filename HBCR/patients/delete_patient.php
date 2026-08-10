<?php
include("../config/database.php");

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM patients WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Patient deleted successfully.');
                window.location='patient_list.php';
              </script>";

    } else {

        echo "<script>
                alert('Unable to delete patient.');
                window.location='patient_list.php';
              </script>";

    }

} else {

    header("Location: patient_list.php");
    exit();

}
?>
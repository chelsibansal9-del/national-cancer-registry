<?php
include("../config/database.php");

$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM treatment WHERE id='$id'");

echo "<script>
alert('Treatment Deleted');
window.location='treatment.php';
</script>";
?>
<?php

include("../config/database.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>
        alert('Invalid Diagnosis ID');
        window.location='diagnosis_list.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM diagnosis WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    echo "<script>
        alert('Diagnosis deleted successfully');
        window.location='diagnosis_list.php';
    </script>";

} else {

    echo "<script>
        alert('Error deleting diagnosis');
        window.location='diagnosis_list.php';
    </script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
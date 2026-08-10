<?php

include("../config/database.php");


/* =====================================================
   CHECK ID
===================================================== */

$id = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;


if ($id <= 0) {

    echo "<script>

        alert('Invalid follow-up record.');

        window.location='followup.php';

    </script>";

    exit();

}


/* =====================================================
   CHECK RECORD EXISTS
===================================================== */

$check = mysqli_prepare(
    $conn,
    "SELECT id FROM followup WHERE id = ?"
);

mysqli_stmt_bind_param(
    $check,
    "i",
    $id
);

mysqli_stmt_execute($check);

$result = mysqli_stmt_get_result($check);


if (mysqli_num_rows($result) === 0) {

    mysqli_stmt_close($check);

    echo "<script>

        alert('Follow-up record not found.');

        window.location='followup.php';

    </script>";

    exit();

}

mysqli_stmt_close($check);


/* =====================================================
   DELETE
===================================================== */

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM followup WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


if (mysqli_stmt_execute($stmt)) {

    echo "<script>

        alert('Follow-up deleted successfully.');

        window.location='followup.php';

    </script>";

} else {

    echo "<script>

        alert('Unable to delete follow-up record.');

        window.location='followup.php';

    </script>";

}


mysqli_stmt_close($stmt);

mysqli_close($conn);

?>
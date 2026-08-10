<?php

include("../config/database.php");

/* =====================================================
   REQUEST CHECK
===================================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: treatment.php");
    exit();

}


/* =====================================================
   GET FORM DATA
===================================================== */

$patient_id = $_POST['patient_id'] ?? '';

$treatment_context =
    $_POST['treatment_context'] ?? '';

$treatment_given_before_registration =
    $_POST['treatment_given_before_registration'] ?? '';

$treatment_type_given =
    $_POST['treatment_type_given'] ?? '';

$treatment_modality =
    $_POST['treatment_modality'] ?? '';

$intention_to_treat =
    $_POST['intention_to_treat'] ?? '';

$treatment_role =
    $_POST['treatment_role'] ?? '';

$cdt_details =
    $_POST['cdt_details'] ?? '';


/* =====================================================
   TREATMENT DETAILS
===================================================== */

$treatment_type =
    $_POST['treatment_type'] ?? '';

$treatment_date =
    $_POST['treatment_date'] ?? '';

$start_date =
    $_POST['start_date'] ?? '';

$end_date =
    $_POST['end_date'] ?? '';

$targeted_therapy_type =
    $_POST['targeted_therapy_type'] ?? '';

$performance_status_ecog =
    $_POST['performance_status_ecog'] ?? '';

$doctor =
    $_POST['doctor'] ?? '';

$status =
    $_POST['status'] ?? '';

$date_of_death =
    $_POST['date_of_death'] ?? '';


/* =====================================================
   FORM COMPLETION
===================================================== */

$person_completing_form =
    $_POST['person_completing_form'] ?? '';

$completion_date =
    $_POST['completion_date'] ?? '';

$signature =
    $_POST['signature'] ?? '';

$remarks =
    $_POST['remarks'] ?? '';


/* =====================================================
   REQUIRED FIELD CHECK
===================================================== */

if (
    empty($patient_id) ||
    empty($treatment_context) ||
    empty($treatment_given_before_registration) ||
    empty($treatment_type_given) ||
    empty($treatment_modality) ||
    empty($intention_to_treat) ||
    empty($treatment_role) ||
    empty($treatment_type) ||
    empty($treatment_date) ||
    empty($start_date) ||
    empty($performance_status_ecog) ||
    empty($doctor) ||
    empty($status) ||
    empty($person_completing_form) ||
    empty($completion_date) ||
    empty($signature)
) {

    echo "<script>

        alert('Please fill all mandatory treatment fields.');

        window.history.back();

    </script>";

    exit();

}


/* =====================================================
   CHECK PATIENT EXISTS
===================================================== */

$check = mysqli_prepare(
    $conn,
    "SELECT id FROM patients WHERE id = ?"
);

if (!$check) {

    die(
        "Patient Check Prepare Error: " .
        mysqli_error($conn)
    );

}


mysqli_stmt_bind_param(
    $check,
    "i",
    $patient_id
);


mysqli_stmt_execute($check);


$result =
    mysqli_stmt_get_result($check);


if (
    !$result ||
    mysqli_num_rows($result) === 0
) {

    mysqli_stmt_close($check);

    echo "<script>

        alert('Selected patient does not exist.');

        window.history.back();

    </script>";

    exit();

}


mysqli_stmt_close($check);


/* =====================================================
   INSERT TREATMENT
===================================================== */

$sql = "

    INSERT INTO treatment (

        patient_id,

        treatment_context,
        treatment_given_before_registration,
        treatment_type_given,
        treatment_modality,
        intention_to_treat,
        treatment_role,
        cdt_details,

        treatment_type,
        treatment_date,
        start_date,
        end_date,
        targeted_therapy_type,
        performance_status_ecog,
        doctor,
        status,
        date_of_death,

        person_completing_form,
        completion_date,
        signature,
        remarks

    )

    VALUES (

        ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?

    )

";


$stmt = mysqli_prepare($conn, $sql);


if (!$stmt) {

    $error = mysqli_error($conn);

    echo "<script>

        alert(" .
        json_encode(
            "Database Prepare Error: " . $error
        ) .
        ");

        window.history.back();

    </script>";

    exit();

}


/* =====================================================
   BIND PARAMETERS
===================================================== */

mysqli_stmt_bind_param(

    $stmt,

    "issssssssssssssssssss",

    $patient_id,

    $treatment_context,
    $treatment_given_before_registration,
    $treatment_type_given,
    $treatment_modality,
    $intention_to_treat,
    $treatment_role,
    $cdt_details,

    $treatment_type,
    $treatment_date,
    $start_date,
    $end_date,
    $targeted_therapy_type,
    $performance_status_ecog,
    $doctor,
    $status,
    $date_of_death,

    $person_completing_form,
    $completion_date,
    $signature,
    $remarks

);


/* =====================================================
   SAVE
===================================================== */

if (mysqli_stmt_execute($stmt)) {

    echo "<script>

        alert('Treatment Saved Successfully.');

        window.location='treatment.php';

    </script>";

} else {

    $error =
        mysqli_stmt_error($stmt);

    echo "<script>

        alert(" .
        json_encode(
            "Database Error: " . $error
        ) .
        ");

        window.history.back();

    </script>";

}


/* =====================================================
   CLOSE
===================================================== */

mysqli_stmt_close($stmt);

mysqli_close($conn);

?>
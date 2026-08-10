<?php

include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: followup.php");
    exit();
}


/* =====================================================
   GET FOLLOW-UP ID
===================================================== */

$id = $_POST['id'] ?? '';

if (empty($id) || !is_numeric($id)) {

    echo "<script>
        alert('Invalid follow-up record.');
        window.location='followup.php';
    </script>";

    exit();
}


/* =====================================================
   GET FORM DATA
===================================================== */

$patient_id = $_POST['patient_id'] ?? '';
$visit_no = $_POST['visit_no'] ?? '';

$followup_date = $_POST['followup_date'] ?? '';
$followup_method = $_POST['followup_method'] ?? '';

$vital_status = $_POST['vital_status'] ?? '';
$disease_status = $_POST['disease_status'] ?? '';
$first_recurrence_date = $_POST['first_recurrence_date'] ?? '';

$treatment_given = $_POST['treatment_given'] ?? '';
$treatment_type = $_POST['treatment_type'] ?? '';

$surgery = $_POST['surgery'] ?? '';
$surgery_start_date = $_POST['surgery_start_date'] ?? '';
$surgery_end_date = $_POST['surgery_end_date'] ?? '';

$radiotherapy = $_POST['radiotherapy'] ?? '';
$radiotherapy_start_date = $_POST['radiotherapy_start_date'] ?? '';
$radiotherapy_end_date = $_POST['radiotherapy_end_date'] ?? '';

$chemotherapy = $_POST['chemotherapy'] ?? '';
$chemotherapy_start_date = $_POST['chemotherapy_start_date'] ?? '';
$chemotherapy_end_date = $_POST['chemotherapy_end_date'] ?? '';

$hormone_therapy = $_POST['hormone_therapy'] ?? '';
$hormone_therapy_start_date = $_POST['hormone_therapy_start_date'] ?? '';
$hormone_therapy_end_date = $_POST['hormone_therapy_end_date'] ?? '';

$targeted_therapy = $_POST['targeted_therapy'] ?? '';
$targeted_therapy_start_date = $_POST['targeted_therapy_start_date'] ?? '';
$targeted_therapy_end_date = $_POST['targeted_therapy_end_date'] ?? '';

$other_treatment = $_POST['other_treatment'] ?? '';
$other_treatment_given = $_POST['other_treatment_given'] ?? '';
$other_treatment_start_date = $_POST['other_treatment_start_date'] ?? '';
$other_treatment_end_date = $_POST['other_treatment_end_date'] ?? '';

$date_of_death = $_POST['date_of_death'] ?? '';
$place_of_death = $_POST['place_of_death'] ?? '';
$death_information_source = $_POST['death_information_source'] ?? '';

$immediate_cause = $_POST['immediate_cause'] ?? '';
$antecedent_cause = $_POST['antecedent_cause'] ?? '';
$underlying_cause = $_POST['underlying_cause'] ?? '';
$contributing_conditions = $_POST['contributing_conditions'] ?? '';

$ucod = $_POST['ucod'] ?? '';
$major_cause_group = $_POST['major_cause_group'] ?? '';

$person_completing = $_POST['person_completing'] ?? '';
$completion_date = $_POST['completion_date'] ?? '';

/*
 * Digital signature
 *
 * IMPORTANT:
 * Your follow-up form uses:
 *
 * name="digital_signature"
 *
 */

$signature = $_POST['digital_signature'] ?? '';


/* =====================================================
   REQUIRED BASIC CHECK
===================================================== */

if (
    empty($patient_id) ||
    empty($followup_date) ||
    empty($followup_method) ||
    empty($vital_status) ||
    empty($disease_status) ||
    empty($treatment_given)
) {

    echo "<script>
        alert('Please fill all mandatory follow-up fields.');
        window.history.back();
    </script>";

    exit();
}


/* =====================================================
   CHECK FOLLOW-UP EXISTS
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
   UPDATE FOLLOW-UP
===================================================== */

$sql = "UPDATE followup SET

    patient_id = ?,
    visit_no = ?,
    followup_date = ?,
    followup_method = ?,
    vital_status = ?,
    disease_status = ?,
    first_recurrence_date = ?,

    treatment_given = ?,
    treatment_type = ?,

    surgery = ?,
    surgery_start_date = ?,
    surgery_end_date = ?,

    radiotherapy = ?,
    radiotherapy_start_date = ?,
    radiotherapy_end_date = ?,

    chemotherapy = ?,
    chemotherapy_start_date = ?,
    chemotherapy_end_date = ?,

    hormone_therapy = ?,
    hormone_therapy_start_date = ?,
    hormone_therapy_end_date = ?,

    targeted_therapy = ?,
    targeted_therapy_start_date = ?,
    targeted_therapy_end_date = ?,

    other_treatment = ?,
    other_treatment_given = ?,
    other_treatment_start_date = ?,
    other_treatment_end_date = ?,

    date_of_death = ?,
    place_of_death = ?,
    death_information_source = ?,

    immediate_cause = ?,
    antecedent_cause = ?,
    underlying_cause = ?,
    contributing_conditions = ?,

    ucod = ?,
    major_cause_group = ?,

    person_completing = ?,
    completion_date = ?,
    digital_signature = ?

WHERE id = ?";


$stmt = mysqli_prepare($conn, $sql);


if (!$stmt) {

    die(
        "Prepare Error: " .
        mysqli_error($conn)
    );

}


/* =====================================================
   BIND PARAMETERS
===================================================== */

mysqli_stmt_bind_param(
    $stmt,
    "isssssssssssssssssssssssssssssssssssssssi",

    $patient_id,
    $visit_no,
    $followup_date,
    $followup_method,
    $vital_status,
    $disease_status,
    $first_recurrence_date,

    $treatment_given,
    $treatment_type,

    $surgery,
    $surgery_start_date,
    $surgery_end_date,

    $radiotherapy,
    $radiotherapy_start_date,
    $radiotherapy_end_date,

    $chemotherapy,
    $chemotherapy_start_date,
    $chemotherapy_end_date,

    $hormone_therapy,
    $hormone_therapy_start_date,
    $hormone_therapy_end_date,

    $targeted_therapy,
    $targeted_therapy_start_date,
    $targeted_therapy_end_date,

    $other_treatment,
    $other_treatment_given,
    $other_treatment_start_date,
    $other_treatment_end_date,

    $date_of_death,
    $place_of_death,
    $death_information_source,

    $immediate_cause,
    $antecedent_cause,
    $underlying_cause,
    $contributing_conditions,

    $ucod,
    $major_cause_group,

    $person_completing,
    $completion_date,
    $signature,

    $id
);


/* =====================================================
   SAVE UPDATE
===================================================== */

if (mysqli_stmt_execute($stmt)) {

    echo "<script>

        alert('Follow-up Updated Successfully');

        window.location='followup.php';

    </script>";

} else {

    echo "<script>

        alert('Database Error: " .
        mysqli_real_escape_string(
            $conn,
            mysqli_stmt_error($stmt)
        ) .
        "');

        window.history.back();

    </script>";

}


mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
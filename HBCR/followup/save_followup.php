<?php

include("../config/database.php");


/* =====================================================
   REQUEST CHECK
===================================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: followup.php");
    exit();

}


/* =====================================================
   EDIT ID
===================================================== */

$edit_id = isset($_POST['edit_id'])
    ? (int)$_POST['edit_id']
    : 0;


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


/* =====================================================
   IF DEAD SECTION
   OPTIONAL
===================================================== */

$date_of_death = $_POST['date_of_death'] ?? '';
$place_of_death = $_POST['place_of_death'] ?? '';
$death_information_source = $_POST['death_information_source'] ?? '';

$immediate_cause = $_POST['immediate_cause'] ?? '';
$antecedent_cause = $_POST['antecedent_cause'] ?? '';
$underlying_cause = $_POST['underlying_cause'] ?? '';
$contributing_conditions = $_POST['contributing_conditions'] ?? '';


/* =====================================================
   FINAL INFORMATION
===================================================== */

$ucod = $_POST['ucod'] ?? '';
$major_cause_group = $_POST['major_cause_group'] ?? '';

$person_completing = $_POST['person_completing'] ?? '';
$completion_date = $_POST['completion_date'] ?? '';


/* =====================================================
   DIGITAL SIGNATURE
===================================================== */

$signature =
    $_POST['digital_signature'] ?? '';



/* =====================================================
   REQUIRED MAIN FIELD CHECK
===================================================== */

if (
    empty($patient_id) ||
    empty($followup_date) ||
    empty($followup_method) ||
    empty($vital_status) ||
    empty($disease_status) ||
    empty($treatment_given) ||
    empty($ucod) ||
    empty($major_cause_group) ||
    empty($person_completing) ||
    empty($completion_date)
) {

    echo "<script>

        alert('Please fill all mandatory follow-up fields.');

        window.history.back();

    </script>";

    exit();

}


/* =====================================================
   CHECK PATIENT
===================================================== */

$check = mysqli_prepare(
    $conn,
    "SELECT id FROM patients WHERE id = ?"
);


if (!$check) {

    die(
        "Patient Check Error: " .
        mysqli_error($conn)
    );

}


mysqli_stmt_bind_param(
    $check,
    "i",
    $patient_id
);


mysqli_stmt_execute($check);


$result = mysqli_stmt_get_result($check);


if (!$result || mysqli_num_rows($result) === 0) {

    mysqli_stmt_close($check);

    echo "<script>

        alert('Selected patient does not exist.');

        window.history.back();

    </script>";

    exit();

}


mysqli_stmt_close($check);



/* =====================================================
   UPDATE EXISTING RECORD
===================================================== */

if ($edit_id > 0) {


    /* =================================================
       CHECK EDIT RECORD
    ================================================= */

    $checkEdit = mysqli_prepare(
        $conn,
        "SELECT id FROM followup WHERE id = ?"
    );


    mysqli_stmt_bind_param(
        $checkEdit,
        "i",
        $edit_id
    );


    mysqli_stmt_execute(
        $checkEdit
    );


    $editResult =
        mysqli_stmt_get_result(
            $checkEdit
        );


    if (
        !$editResult ||
        mysqli_num_rows($editResult) === 0
    ) {

        mysqli_stmt_close($checkEdit);

        echo "<script>

            alert('Follow-up record not found.');

            window.location='followup.php';

        </script>";

        exit();

    }


    mysqli_stmt_close($checkEdit);



    /* ================================================
       UPDATE QUERY
    ================================================ */

    $sql = "

        UPDATE followup SET

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

        WHERE id = ?

    ";


    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if (!$stmt) {

        die(
            "Prepare Error: " .
            mysqli_error($conn)
        );

    }


    mysqli_stmt_bind_param(

        $stmt,

        "issssssssssssssssssssssssssssssssssssssi",

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

        $digital_signature,

        $edit_id

    );


    if (
        mysqli_stmt_execute($stmt)
    ) {

        echo "<script>

            alert('Follow-up Updated Successfully.');

            window.location='followup.php';

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


    mysqli_stmt_close($stmt);

}


/* =====================================================
   NEW FOLLOW-UP
===================================================== */

else {


    $sql = "

        INSERT INTO followup (

            patient_id,
            visit_no,

            followup_date,
            followup_method,

            vital_status,
            disease_status,
            first_recurrence_date,

            treatment_given,
            treatment_type,

            surgery,
            surgery_start_date,
            surgery_end_date,

            radiotherapy,
            radiotherapy_start_date,
            radiotherapy_end_date,

            chemotherapy,
            chemotherapy_start_date,
            chemotherapy_end_date,

            hormone_therapy,
            hormone_therapy_start_date,
            hormone_therapy_end_date,

            targeted_therapy,
            targeted_therapy_start_date,
            targeted_therapy_end_date,

            other_treatment,
            other_treatment_given,
            other_treatment_start_date,
            other_treatment_end_date,

            date_of_death,
            place_of_death,
            death_information_source,

            immediate_cause,
            antecedent_cause,
            underlying_cause,
            contributing_conditions,

            ucod,
            major_cause_group,

            person_completing,
            completion_date,

            digital_signature

        ) VALUES (

            ?, ?, ?, ?, ?, ?, ?,
            ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?,
            ?, ?, ?

        )

    ";


    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if (!$stmt) {

        die(
            "Prepare Error: " .
            mysqli_error($conn)
        );

    }


    mysqli_stmt_bind_param(

        $stmt,

        "isssssssssssssssssssssssssssssssssssssss",

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

        $digital_signature

    );


    if (
        mysqli_stmt_execute($stmt)
    ) {

        echo "<script>

            alert('Follow-up Saved Successfully.');

            window.location='followup.php';

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


    mysqli_stmt_close($stmt);

}


mysqli_close($conn);

?>
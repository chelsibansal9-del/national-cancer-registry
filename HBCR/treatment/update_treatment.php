<?php

include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'] ?? '';
    $patient_id = $_POST['patient_id'] ?? '';

    $treatment_context = $_POST['treatment_context'] ?? '';
    $treatment_given_before_registration =
        $_POST['treatment_given_before_registration'] ?? '';
    $treatment_type_given = $_POST['treatment_type_given'] ?? '';
    $treatment_modality = $_POST['treatment_modality'] ?? '';
    $intention_to_treat = $_POST['intention_to_treat'] ?? '';
    $treatment_role = $_POST['treatment_role'] ?? '';
    $cdt_details = $_POST['cdt_details'] ?? '';

    $treatment_type = $_POST['treatment_type'] ?? '';
    $treatment_date = $_POST['treatment_date'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    $targeted_therapy_type =
        $_POST['targeted_therapy_type'] ?? '';

    $performance_status_ecog =
        $_POST['performance_status_ecog'] ?? '';

    $date_of_death = $_POST['date_of_death'] ?? '';

    $person_completing_form =
        $_POST['person_completing_form'] ?? '';

    $completion_date =
        $_POST['completion_date'] ?? '';

    $signature = $_POST['signature'] ?? '';
    $doctor = $_POST['doctor'] ?? '';
    $status = $_POST['status'] ?? '';
    $remarks = $_POST['remarks'] ?? '';


    $sql = "UPDATE treatment SET

        patient_id = '$patient_id',

        treatment_context =
        '$treatment_context',

        treatment_given_before_registration =
        '$treatment_given_before_registration',

        treatment_type_given =
        '$treatment_type_given',

        treatment_modality =
        '$treatment_modality',

        intention_to_treat =
        '$intention_to_treat',

        treatment_role =
        '$treatment_role',

        cdt_details =
        '$cdt_details',

        treatment_type =
        '$treatment_type',

        treatment_date =
        '$treatment_date',

        start_date =
        '$start_date',

        end_date =
        '$end_date',

        targeted_therapy_type =
        '$targeted_therapy_type',

        performance_status_ecog =
        '$performance_status_ecog',

        date_of_death =
        '$date_of_death',

        person_completing_form =
        '$person_completing_form',

        completion_date =
        '$completion_date',

        signature =
        '$signature',

        doctor =
        '$doctor',

        status =
        '$status',

        remarks =
        '$remarks'

        WHERE id = '$id'
    ";


    if (mysqli_query($conn, $sql)) {

        echo "<script>

            alert('Treatment Updated Successfully');

            window.location='treatment.php';

        </script>";

    } else {

        echo "<script>

            alert('Database Error: " .
            mysqli_error($conn) .
            "');

            window.history.back();

        </script>";

    }

}

?>
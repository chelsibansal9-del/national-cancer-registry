<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");

$id = $_GET['id'] ?? '';

if (!$id) {
    echo "<script>
        alert('Invalid treatment record.');
        window.location='treatment.php';
    </script>";
    exit;
}


/* =========================================
   GET TREATMENT RECORD
========================================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM treatment WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$treatment = mysqli_fetch_assoc($result);


if (!$treatment) {

    echo "<script>
        alert('Treatment record not found.');
        window.location='treatment.php';
    </script>";

    exit;
}


/* =========================================
   GET PATIENTS
========================================= */

$patients = mysqli_query(
    $conn,
    "SELECT id, hbcr_no, first_name, last_name
     FROM patients
     ORDER BY first_name, last_name"
);

?>

<div class="main-content">

<div class="page-header">

    <h2>
        <i class="fa fa-edit"></i>
        Edit Treatment
    </h2>

    <p>
        Hospital Based Cancer Registry System
    </p>

</div>


<form action="update_treatment.php" method="POST">

<input
    type="hidden"
    name="id"
    value="<?php echo htmlspecialchars($treatment['id']); ?>"
>


<!-- =========================================
     PATIENT
========================================= -->

<div class="card">

<h3>Patient Information</h3>

<div class="row">

<div class="form-group full">

<label>Select Patient</label>

<select
    name="patient_id"
    class="form-control"
    required
>

<option value="">-- Select Patient --</option>

<?php

while ($p = mysqli_fetch_assoc($patients)) {

    $selected =
        ($p['id'] == $treatment['patient_id'])
        ? 'selected'
        : '';

?>

<option
    value="<?php echo $p['id']; ?>"
    <?php echo $selected; ?>
>

<?php

echo htmlspecialchars(
    $p['hbcr_no'] .
    " - " .
    $p['first_name'] .
    " " .
    $p['last_name']
);

?>

</option>

<?php } ?>

</select>

</div>

</div>

</div>


<!-- =========================================
     TREATMENT CONTEXT
========================================= -->

<div class="card">

<h3>Treatment Context</h3>

<div class="row">


<div class="form-group">

<label>Treatment Context</label>

<select name="treatment_context" class="form-control">

<option value="">Select</option>

<?php

$options = [
    "First Course",
    "Subsequent Course",
    "Recurrence",
    "Progression",
    "Palliative",
    "Other"
];

foreach ($options as $option) {

    $selected =
        ($treatment['treatment_context'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"" .
         htmlspecialchars($option) .
         "\" $selected>" .
         htmlspecialchars($option) .
         "</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Treatment Given Before Registration</label>

<select
    name="treatment_given_before_registration"
    class="form-control"
>

<option value="">Select</option>

<?php

$options = ["Yes", "No", "Unknown"];

foreach ($options as $option) {

    $selected =
        ($treatment['treatment_given_before_registration'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"$option\" $selected>$option</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Treatment Type Given</label>

<select name="treatment_type_given" class="form-control">

<option value="">Select</option>

<?php

$options = [
    "Surgery",
    "Chemotherapy",
    "Radiotherapy",
    "Immunotherapy",
    "Hormone Therapy",
    "Targeted Therapy",
    "Other"
];

foreach ($options as $option) {

    $selected =
        ($treatment['treatment_type_given'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"" .
         htmlspecialchars($option) .
         "\" $selected>" .
         htmlspecialchars($option) .
         "</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Treatment Modality</label>

<select name="treatment_modality" class="form-control">

<option value="">Select</option>

<?php

$options = [
    "Surgery",
    "Chemotherapy",
    "Radiotherapy",
    "Chemotherapy + Radiotherapy",
    "Surgery + Chemotherapy",
    "Surgery + Radiotherapy",
    "Multimodality",
    "Immunotherapy",
    "Hormone Therapy",
    "Targeted Therapy",
    "Other"
];

foreach ($options as $option) {

    $selected =
        ($treatment['treatment_modality'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"" .
         htmlspecialchars($option) .
         "\" $selected>" .
         htmlspecialchars($option) .
         "</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Intention to Treat</label>

<select name="intention_to_treat" class="form-control">

<option value="">Select</option>

<?php

$options = [
    "Curative",
    "Palliative",
    "Supportive",
    "Unknown"
];

foreach ($options as $option) {

    $selected =
        ($treatment['intention_to_treat'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"$option\" $selected>$option</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Treatment Role</label>

<select name="treatment_role" class="form-control">

<option value="">Select</option>

<?php

$options = [
    "Primary",
    "Adjuvant",
    "Neoadjuvant",
    "Concurrent",
    "Palliative",
    "Supportive",
    "Other"
];

foreach ($options as $option) {

    $selected =
        ($treatment['treatment_role'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"" .
         htmlspecialchars($option) .
         "\" $selected>" .
         htmlspecialchars($option) .
         "</option>";
}

?>

</select>

</div>


<div class="form-group full">

<label>CDT Details</label>

<input
    type="text"
    name="cdt_details"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['cdt_details'] ?? ''); ?>"
>

</div>

</div>

</div>


<!-- =========================================
     TREATMENT DETAILS
========================================= -->

<div class="card">

<h3>Treatment Details</h3>

<div class="row">


<div class="form-group">

<label>Treatment Type</label>

<select name="treatment_type" class="form-control">

<option value="">Select</option>

<?php

$options = [
    "Surgery",
    "Chemotherapy",
    "Radiotherapy",
    "Immunotherapy",
    "Hormone Therapy",
    "Targeted Therapy",
    "Other"
];

foreach ($options as $option) {

    $selected =
        ($treatment['treatment_type'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"" .
         htmlspecialchars($option) .
         "\" $selected>" .
         htmlspecialchars($option) .
         "</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Treatment Date</label>

<input
    type="date"
    name="treatment_date"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['treatment_date'] ?? ''); ?>"
>

</div>


<div class="form-group">

<label>Start Date</label>

<input
    type="date"
    name="start_date"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['start_date'] ?? ''); ?>"
>

</div>


<div class="form-group">

<label>End Date</label>

<input
    type="date"
    name="end_date"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['end_date'] ?? ''); ?>"
>

</div>


<div class="form-group">

<label>Targeted Therapy Type</label>

<select
    name="targeted_therapy_type"
    class="form-control"
>

<option value="">Select</option>

<?php

$options = [
    "None",
    "Monoclonal Antibody",
    "Tyrosine Kinase Inhibitor",
    "Other Targeted Therapy"
];

foreach ($options as $option) {

    $selected =
        ($treatment['targeted_therapy_type'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"" .
         htmlspecialchars($option) .
         "\" $selected>" .
         htmlspecialchars($option) .
         "</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Performance Status (ECOG)</label>

<select
    name="performance_status_ecog"
    class="form-control"
>

<option value="">Select</option>

<?php

$options = [
    "0 - Fully Active",
    "1 - Restricted Activity",
    "2 - Ambulatory",
    "3 - Limited Self Care",
    "4 - Completely Disabled",
    "5 - Dead",
    "Unknown"
];

foreach ($options as $option) {

    $selected =
        ($treatment['performance_status_ecog'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"" .
         htmlspecialchars($option) .
         "\" $selected>" .
         htmlspecialchars($option) .
         "</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Doctor</label>

<input
    type="text"
    name="doctor"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['doctor'] ?? ''); ?>"
>

</div>


<div class="form-group">

<label>Status</label>

<select name="status" class="form-control">

<option value="">Select</option>

<?php

$options = [
    "Ongoing",
    "Completed",
    "Stopped",
    "Not Started",
    "Unknown"
];

foreach ($options as $option) {

    $selected =
        ($treatment['status'] == $option)
        ? 'selected'
        : '';

    echo "<option value=\"$option\" $selected>$option</option>";
}

?>

</select>

</div>


<div class="form-group">

<label>Date of Death</label>

<input
    type="date"
    name="date_of_death"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['date_of_death'] ?? ''); ?>"
>

</div>

</div>

</div>


<!-- =========================================
     FORM COMPLETION
========================================= -->

<div class="card">

<h3>Form Completion</h3>

<div class="row">


<div class="form-group">

<label>Person Completing Form</label>

<input
    type="text"
    name="person_completing_form"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['person_completing_form'] ?? ''); ?>"
>

</div>


<div class="form-group">

<label>Completion Date</label>

<input
    type="date"
    name="completion_date"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['completion_date'] ?? ''); ?>"
>

</div>


<div class="form-group">

<label>Signature</label>

<input
    type="text"
    name="signature"
    class="form-control"
    value="<?php echo htmlspecialchars($treatment['signature'] ?? ''); ?>"
>

</div>


<div class="form-group full">

<label>Remarks</label>

<textarea
    name="remarks"
    class="form-control"
    rows="4"
><?php echo htmlspecialchars($treatment['remarks'] ?? ''); ?></textarea>

</div>

</div>

</div>


<!-- =========================================
     BUTTONS
========================================= -->

<div style="margin:30px 0;">

<button
    type="submit"
    class="btn btn-primary btn-lg"
>

<i class="fa fa-save"></i>
Update Treatment

</button>


<a
    href="treatment.php"
    class="btn btn-secondary btn-lg"
>

<i class="fa fa-arrow-left"></i>
Back

</a>

</div>

</form>

</div>

<?php
include("../includes/footer.php");
?>
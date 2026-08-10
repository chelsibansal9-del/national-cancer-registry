<?php
include("../config/database.php");
include("../includes/header.php");
include("../includes/sidebar.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Patient ID'); window.location='patient_list.php';</script>";
    exit;
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM patients WHERE id='$id'");

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Patient not found'); window.location='patient_list.php';</script>";
    exit;
}

$patient = mysqli_fetch_assoc($result);
?>

<div class="main-content">

<div class="page-header">
    <h2><i class="fa fa-user-edit"></i> Edit Patient</h2>
    <p>Update Hospital Based Cancer Registry Patient Information</p>
</div>

<form action="update_patient.php" method="POST" id="editPatientForm">

<input type="hidden" name="id"
       value="<?php echo htmlspecialchars($patient['id']); ?>">


<!-- =====================================================
     IDENTIFYING INFORMATION
===================================================== -->

<div class="card">

<h3>Section I - Identifying Information / Demographic Details</h3>

<div class="row">

<div class="form-group">
<label>Reporting Institution</label>
<select name="institution" class="form-control">

<option value="">Select Institution</option>

<?php
$institutions = [
    "Government Hospital",
    "Private Hospital",
    "Medical College",
    "Cancer Institute",
    "Other"
];

foreach ($institutions as $value) {
    $selected = (($patient['institution'] ?? '') == $value) ? "selected" : "";
    echo "<option $selected>$value</option>";
}
?>

</select>
</div>


<div class="form-group">
<label>Centre Code</label>
<input type="text"
       name="centre_code"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['centre_code'] ?? ''); ?>">
</div>


<div class="form-group">
<label>HBCR Registration No.</label>
<input type="text"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['hbcr_no'] ?? ''); ?>"
       readonly>
</div>


<div class="form-group">
<label>Department</label>
<input type="text"
       name="department"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['department'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Unit Number</label>
<input type="text"
       name="unit_number"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['unit_number'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Hospital Registration No.</label>
<input type="text"
       name="hospital_no"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['hospital_no'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Date of Reporting at RI</label>
<input type="date"
       name="report_date"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['report_date'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Date of First Diagnosis</label>
<input type="date"
       name="first_diagnosis_date"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['first_diagnosis_date'] ?? ''); ?>">
</div>

</div>
</div>


<!-- =====================================================
     CASE REGISTRATION & REFERRAL
===================================================== -->

<div class="card">

<h3>Case Registration & Referral</h3>

<div class="row">

<div class="form-group">
<label>Case Registered Through</label>

<select name="case_registered_through" class="form-control">

<?php
$options = [
    "",
    "Out-patient",
    "In-patient",
    "In-patient (Emergency)",
    "Other"
];

foreach ($options as $value) {
    $selected = (($patient['case_registered_through'] ?? '') == $value)
        ? "selected" : "";

    $label = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
         . htmlspecialchars($label) .
         "</option>";
}
?>

</select>
</div>


<div class="form-group">
<label>Type of Referral</label>

<select name="referral_type" class="form-control">

<?php
$options = [
    "",
    "Self",
    "Other Hospital / Health Facility",
    "Screen Detected Referral",
    "Unknown"
];

foreach ($options as $value) {
    $selected = (($patient['referral_type'] ?? '') == $value)
        ? "selected" : "";

    $label = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
         . htmlspecialchars($label) .
         "</option>";
}
?>

</select>
</div>


<div class="form-group full">
<label>Name of Referral Facility</label>
<input type="text"
       name="referral_facility"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['referral_facility'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Referral City</label>
<input type="text"
       name="referral_city"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['referral_city'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Referral District</label>
<input type="text"
       name="referral_district"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['referral_district'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Referral PIN Code</label>
<input type="text"
       name="referral_pin"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['referral_pin'] ?? ''); ?>">
</div>

</div>
</div>


<!-- =====================================================
     PATIENT INFORMATION
===================================================== -->

<div class="card">

<h3>Patient Information</h3>

<div class="row">

<div class="form-group">
<label>First Name *</label>
<input type="text"
       name="first_name"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['first_name'] ?? ''); ?>"
       required>
</div>


<div class="form-group">
<label>Middle Name</label>
<input type="text"
       name="middle_name"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['middle_name'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Last Name</label>
<input type="text"
       name="last_name"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['last_name'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Age (Completed Years)</label>
<input type="number"
       name="age"
       class="form-control"
       min="0"
       value="<?php echo htmlspecialchars($patient['age'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Date of Birth</label>
<input type="date"
       name="dob"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['dob'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Sex *</label>

<select name="gender" class="form-control" required>

<?php
$options = ["", "Male", "Female", "Other", "Unknown"];

foreach ($options as $value) {

    $selected = (($patient['gender'] ?? '') == $value)
        ? "selected" : "";

    $label = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($label) .
        "</option>";
}
?>

</select>

</div>

</div>
</div>


<!-- =====================================================
     UNIQUE IDENTIFICATION
===================================================== -->

<div class="card">

<h3>Unique Identification / Beneficiary Information</h3>

<div class="row">

<div class="form-group">
<label>Aadhaar</label>
<input type="text"
       name="aadhaar"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['aadhaar'] ?? ''); ?>">
</div>


<div class="form-group">
<label>ABHA (Health ID)</label>
<input type="text"
       name="abha_id"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['abha_id'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Beneficiary Health Scheme Name / No.</label>
<input type="text"
       name="health_scheme"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['health_scheme'] ?? ''); ?>">
</div>


<div class="form-group">
<label>ID Status</label>

<select name="id_status" class="form-control">

<?php
$options = ["", "Known", "Unknown"];

foreach ($options as $value) {

    $selected = (($patient['id_status'] ?? '') == $value)
        ? "selected" : "";

    $label = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($label) .
        "</option>";
}
?>

</select>

</div>

</div>
</div>


<!-- =====================================================
     NEXT OF KIN
===================================================== -->

<div class="card">

<h3>Relative / Next of Kin / Accompanying Person</h3>

<div class="row">

<div class="form-group">

<label>Relationship</label>

<select name="next_kin_relation" class="form-control">

<?php
$options = [
    "",
    "Father",
    "Mother",
    "Husband",
    "Wife",
    "Son",
    "Daughter",
    "Other"
];

foreach ($options as $value) {

    $selected = (($patient['next_kin_relation'] ?? '') == $value)
        ? "selected" : "";

    $label = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($label) .
        "</option>";
}
?>

</select>

</div>


<div class="form-group">
<label>Name</label>
<input type="text"
       name="next_kin_name"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['next_kin_name'] ?? ''); ?>">
</div>


<div class="form-group">
<label>Mobile</label>
<input type="text"
       name="next_kin_mobile"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['next_kin_mobile'] ?? ''); ?>">
</div>

</div>
</div>


<!-- =====================================================
     CURRENT ADDRESS
===================================================== -->

<div class="card">

<h3>Address of Residence of Patient</h3>

<div class="row">

<div class="form-group">
<label>Place of Usual Residence</label>

<select name="residence_type" class="form-control">

<?php
$options = [
    "",
    "Urban Area (Town / Cities)",
    "Non-urban / Rural Area"
];

foreach ($options as $value) {

    $selected = (($patient['residence_type'] ?? '') == $value)
        ? "selected" : "";

    $label = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($label) .
        "</option>";
}
?>

</select>
</div>


<?php
$textFields = [

    "house_no" => "House / Building No.",
    "street_name" => "Road / Street Name",
    "locality" => "Area / Locality / Panchayat",
    "ward" => "Ward / Corporation",
    "city" => "Village / City / Town",
    "sub_district" => "Sub-Unit of District (Taluk / Tehsil / Other)",
    "district" => "District",
    "pin" => "PIN Code",
    "state" => "State / UT",
    "mobile" => "Mobile No. 1",
    "mobile2" => "Mobile No. 2",
    "email" => "Email ID"
];

foreach ($textFields as $name => $label) {

    $type = ($name == "email") ? "email" : "text";
?>

<div class="form-group">

<label><?php echo $label; ?></label>

<input type="<?php echo $type; ?>"
       name="<?php echo $name; ?>"
       class="form-control"
       value="<?php echo htmlspecialchars($patient[$name] ?? ''); ?>">

</div>

<?php } ?>


<div class="form-group">

<label>Duration at Residence (Years)</label>

<input type="number"
       name="residence_duration"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['residence_duration'] ?? ''); ?>">

</div>

</div>
</div>


<!-- =====================================================
     PERMANENT ADDRESS
===================================================== -->

<div class="card">

<h3>Permanent Address</h3>

<div class="row">

<?php

$permanentFields = [

    "permanent_village" => "Village",
    "permanent_city" => "Town / City",
    "permanent_district" => "District",
    "permanent_pin" => "PIN Code",
    "permanent_state" => "State / UT"

];

foreach ($permanentFields as $name => $label) {
?>

<div class="form-group">

<label><?php echo $label; ?></label>

<input type="text"
       name="<?php echo $name; ?>"
       class="form-control"
       value="<?php echo htmlspecialchars($patient[$name] ?? ''); ?>">

</div>

<?php } ?>

</div>
</div>


<!-- =====================================================
     DEMOGRAPHIC
===================================================== -->

<div class="card">

<h3>Demographic Details</h3>

<div class="row">

<div class="form-group">

<label>Marital Status</label>

<select name="marital_status" class="form-control">

<?php
$options = [
    "",
    "Unmarried",
    "Married",
    "Widowed",
    "Divorced",
    "Separated",
    "Other",
    "Unknown"
];

foreach ($options as $value) {

    $selected = (($patient['marital_status'] ?? '') == $value)
        ? "selected" : "";

    $label = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($label) .
        "</option>";
}
?>

</select>

</div>


<div class="form-group">

<label>Education</label>

<select name="education" class="form-control">

<?php
$options = [
    "",
    "Not applicable",
    "Illiterate",
    "Literate",
    "Primary",
    "Middle",
    "Secondary / Higher Secondary",
    "Technical - After Matric",
    "Graduate and Above",
    "Other",
    "Unknown"
];

foreach ($options as $value) {

    $selected = (($patient['education'] ?? '') == $value)
        ? "selected" : "";

    $label = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($label) .
        "</option>";
}
?>

</select>

</div>

</div>
</div>


<!-- =====================================================
     HABITS
===================================================== -->

<div class="card">

<h3>Habits</h3>

<div class="row">

<?php

$habitFields = [

    "smoking" => "Smoking",
    "smokeless" => "Smokeless Tobacco",
    "betelnut_tobacco" => "Betel Nut with Tobacco",
    "betelnut" => "Betel Nut without Tobacco",
    "alcohol" => "Alcohol Use"

];

foreach ($habitFields as $name => $label) {
?>

<div class="form-group">

<label><?php echo $label; ?></label>

<select name="<?php echo $name; ?>" class="form-control">

<?php
$options = ["", "Yes", "Never", "Unknown"];

foreach ($options as $value) {

    $selected = (($patient[$name] ?? '') == $value)
        ? "selected" : "";

    $display = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($display) .
        "</option>";
}
?>

</select>

</div>


<div class="form-group">

<label><?php echo $label; ?> Duration (Months)</label>

<input type="number"
       name="<?php echo $name; ?>_duration"
       class="form-control"
       value="<?php echo htmlspecialchars($patient[$name . '_duration'] ?? ''); ?>">

</div>

<?php } ?>

</div>
</div>


<!-- =====================================================
     CO-MORBIDITIES
===================================================== -->

<div class="card">

<h3>Co-morbidities</h3>

<div class="row">

<?php

$conditions = [

    "tuberculosis" => "Tuberculosis",
    "hypertension" => "Hypertension",
    "diabetes" => "Diabetes",
    "ischemic_heart" => "Ischemic Heart Disease",
    "copd" => "Bronchial Asthma / COPD",
    "stroke" => "Stroke",
    "depression" => "Depression",
    "hepatitis_b" => "Chronic Hepatitis B",
    "hepatitis_c" => "Chronic Hepatitis C",
    "nafld" => "NAFLD",
    "kidney_disease" => "Chronic Kidney Disease",
    "hiv" => "HIV/AIDS",
    "hypothyroidism" => "Hypothyroidism"

];

foreach ($conditions as $name => $label) {

?>

<div class="form-group">

<label><?php echo $label; ?></label>

<select name="<?php echo $name; ?>" class="form-control">

<?php

$options = ["", "Yes", "No", "Unknown"];

foreach ($options as $value) {

    $selected = (($patient[$name] ?? '') == $value)
        ? "selected" : "";

    $display = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($display) .
        "</option>";
}

?>

</select>

</div>

<?php } ?>


<div class="form-group">

<label>Other Co-morbidity</label>

<input type="text"
       name="other_comorbidity"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['other_comorbidity'] ?? ''); ?>">

</div>

</div>
</div>


<!-- =====================================================
     ANTHROPOMETRIC
===================================================== -->

<div class="card">

<h3>Anthropometric Measurements</h3>

<div class="row">

<div class="form-group">

<label>Height (cm)</label>

<input type="number"
       step="0.1"
       name="height"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['height'] ?? ''); ?>">

</div>


<div class="form-group">

<label>Weight (kg)</label>

<input type="number"
       step="0.1"
       name="weight"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['weight'] ?? ''); ?>">

</div>

</div>
</div>


<!-- =====================================================
     FAMILY CANCER HISTORY
===================================================== -->

<div class="card">

<h3>History of Familial Cancers</h3>

<div class="row">

<div class="form-group">

<label>Family History of Cancer</label>

<select name="family_cancer_history" class="form-control">

<?php
$options = ["", "Yes", "No", "Unknown"];

foreach ($options as $value) {

    $selected = (($patient['family_cancer_history'] ?? '') == $value)
        ? "selected" : "";

    $display = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($display) .
        "</option>";
}
?>

</select>

</div>


<div class="form-group">

<label>Type of Family Cancer</label>

<select name="family_cancer_type" class="form-control">

<?php
$options = ["", "Same Cancer", "Other Cancer"];

foreach ($options as $value) {

    $selected = (($patient['family_cancer_type'] ?? '') == $value)
        ? "selected" : "";

    $display = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($display) .
        "</option>";
}
?>

</select>

</div>


<div class="form-group">

<label>Relationship</label>

<select name="family_relation" class="form-control">

<?php
$options = [
    "",
    "First Degree Relative",
    "Second Degree Relative",
    "Other"
];

foreach ($options as $value) {

    $selected = (($patient['family_relation'] ?? '') == $value)
        ? "selected" : "";

    $display = $value == "" ? "Select" : $value;

    echo "<option value=\"" . htmlspecialchars($value) . "\" $selected>"
        . htmlspecialchars($display) .
        "</option>";
}
?>

</select>

</div>


<div class="form-group full">

<label>Primary Site of Tumour for Relative</label>

<input type="text"
       name="family_cancer_site"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['family_cancer_site'] ?? ''); ?>">

</div>


<div class="form-group">

<label>Age at Diagnosis (Years)</label>

<input type="number"
       name="family_cancer_age"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['family_cancer_age'] ?? ''); ?>">

</div>


<div class="form-group">

<label>Date of Diagnosis</label>

<input type="date"
       name="family_cancer_date"
       class="form-control"
       value="<?php echo htmlspecialchars($patient['family_cancer_date'] ?? ''); ?>">

</div>

</div>
</div>


<!-- =====================================================
     BUTTONS
===================================================== -->

<div style="margin:30px 0;">

<button type="submit" class="btn btn-primary btn-lg">
    <i class="fa fa-save"></i> Update Patient
</button>

<a href="patient_list.php" class="btn btn-secondary btn-lg">
    Cancel
</a>

</div>

</form>

</div>

<?php
include("../includes/footer.php");
?>
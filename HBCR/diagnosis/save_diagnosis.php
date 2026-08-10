<?php

include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: diagnosis_form.php");
    exit;
}


/* =========================
   GET FORM DATA
========================= */

$patient_id = $_POST['patient_id'] ?? '';

$diagnosis_date = $_POST['diagnosis_date'] ?? '';
$diagnosis_method = $_POST['diagnosis_method'] ?? '';
$symptom_duration = $_POST['symptom_duration'] ?? '';
$microscopic_confirmation = $_POST['microscopic_confirmation'] ?? '';
$specimen_site = $_POST['specimen_site'] ?? '';
$pathology_slide_no = $_POST['pathology_slide_no'] ?? '';
$pathology_report_date = $_POST['pathology_report_date'] ?? '';

$primary_site = $_POST['primary_site'] ?? '';
$icd_code = $_POST['icd_code'] ?? '';
$topography = $_POST['topography'] ?? '';
$laterality = $_POST['laterality'] ?? '';
$secondary_site = $_POST['secondary_site'] ?? '';

$histology = $_POST['histology'] ?? '';
$morphology = $_POST['morphology'] ?? '';
$tumour_behaviour = $_POST['tumour_behaviour'] ?? '';

$clinical_extent = $_POST['clinical_extent'] ?? '';
$lymph_node_involvement = $_POST['lymph_node_involvement'] ?? '';
$distant_metastasis = $_POST['distant_metastasis'] ?? '';

$staging_system = $_POST['staging_system'] ?? '';
$t_category = $_POST['t_category'] ?? '';
$n_category = $_POST['n_category'] ?? '';
$m_category = $_POST['m_category'] ?? '';
$tnm_stage = $_POST['tnm_stage'] ?? '';
$stage = $_POST['stage'] ?? '';

$remarks = $_POST['remarks'] ?? '';


/* =========================
   REQUIRED FIELD CHECK
========================= */

if (
    empty($patient_id) ||
    empty($diagnosis_date) ||
    empty($diagnosis_method) ||
    empty($primary_site) ||
    empty($histology)
) {

    echo "<script>
        alert('Please fill all mandatory diagnosis fields.');
        window.history.back();
    </script>";

    exit;
}


/* =========================
   CHECK PATIENT EXISTS
========================= */

$checkPatient = mysqli_prepare(
    $conn,
    "SELECT id FROM patients WHERE id = ?"
);

if (!$checkPatient) {
    die("Database Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $checkPatient,
    "i",
    $patient_id
);

mysqli_stmt_execute($checkPatient);

$patientResult = mysqli_stmt_get_result($checkPatient);

if (mysqli_num_rows($patientResult) == 0) {

    mysqli_stmt_close($checkPatient);

    echo "<script>
        alert('Selected patient does not exist.');
        window.history.back();
    </script>";

    exit;
}

mysqli_stmt_close($checkPatient);


/* =========================
   DIAGNOSIS TEXT
========================= */

$diagnosis = $primary_site;


/* =========================
   INSERT DIAGNOSIS
========================= */

$sql = "INSERT INTO diagnosis (

    patient_id,
    diagnosis,
    diagnosis_date,
    diagnosis_method,
    symptom_duration,
    microscopic_confirmation,
    specimen_site,
    pathology_slide_no,
    pathology_report_date,

    primary_site,
    topography,
    morphology,
    histology,
    laterality,
    secondary_site,
    tumour_behaviour,

    clinical_extent,
    lymph_node_involvement,
    distant_metastasis,

    staging_system,
    t_category,
    n_category,
    m_category,
    tnm_stage,
    stage,

    icd_code,
    remarks

) VALUES (

    ?,?,?,?,?,?,?,?,?,
    ?,?,?,?,?,?,?,
    ?,?,?,
    ?,?,?,?,?,?,
    ?,?

)";


$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {

    echo "<script>
        alert('Prepare Error: " .
        addslashes(mysqli_error($conn)) .
        "');
        window.history.back();
    </script>";

    exit;
}


/* =========================
   BIND PARAMETERS
========================= */

mysqli_stmt_bind_param(
    $stmt,

    "issssssssssssssssssssssssss",

    $patient_id,
    $diagnosis,
    $diagnosis_date,
    $diagnosis_method,
    $symptom_duration,
    $microscopic_confirmation,
    $specimen_site,
    $pathology_slide_no,
    $pathology_report_date,

    $primary_site,
    $topography,
    $morphology,
    $histology,
    $laterality,
    $secondary_site,
    $tumour_behaviour,

    $clinical_extent,
    $lymph_node_involvement,
    $distant_metastasis,

    $staging_system,
    $t_category,
    $n_category,
    $m_category,
    $tnm_stage,
    $stage,

    $icd_code,
    $remarks
);


/* =========================
   SAVE
========================= */

if (mysqli_stmt_execute($stmt)) {

    $diagnosis_id = mysqli_insert_id($conn);

    echo "<script>

        alert('Diagnosis Saved Successfully');

        window.location='diagnosis_list.php';

    </script>";

} else {

    echo "<script>

        alert('Database Error: " .
        addslashes(mysqli_stmt_error($stmt)) .
        "');

        window.history.back();

    </script>";
}


mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
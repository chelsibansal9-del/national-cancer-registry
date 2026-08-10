 <?php

include("../config/database.php");

/*
=========================================================
UPDATE DIAGNOSIS
=========================================================
*/


/* -------------------------------------------------------
   CHECK DATABASE CONNECTION
------------------------------------------------------- */

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


/* -------------------------------------------------------
   CHECK IF FORM WAS SUBMITTED
------------------------------------------------------- */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../diagnosis/diagnosis_list.php");
    exit();

}


/* -------------------------------------------------------
   GET DIAGNOSIS ID
------------------------------------------------------- */

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {

    die("Invalid diagnosis ID.");

}


/* -------------------------------------------------------
   GET FORM VALUES
------------------------------------------------------- */

$diagnosis_date = $_POST['diagnosis_date'] ?? '';

$diagnosis_method = $_POST['diagnosis_method'] ?? '';

$symptom_duration = $_POST['symptom_duration'] ?? '';

$microscopic_confirmation =
    $_POST['microscopic_confirmation'] ?? '';

$specimen_site =
    $_POST['specimen_site'] ?? '';

$pathology_slide_no =
    $_POST['pathology_slide_no'] ?? '';

$pathology_report_date =
    $_POST['pathology_report_date'] ?? '';

$primary_site =
    $_POST['primary_site'] ?? '';

$icd_code =
    $_POST['icd_code'] ?? '';

$topography =
    $_POST['topography'] ?? '';

$morphology =
    $_POST['morphology'] ?? '';

$histology =
    $_POST['histology'] ?? '';

$laterality =
    $_POST['laterality'] ?? '';

$secondary_site =
    $_POST['secondary_site'] ?? '';

$tumour_behaviour =
    $_POST['tumour_behaviour'] ?? '';

$clinical_extent =
    $_POST['clinical_extent'] ?? '';

$lymph_node_involvement =
    $_POST['lymph_node_involvement'] ?? '';

$distant_metastasis =
    $_POST['distant_metastasis'] ?? '';

$staging_system =
    $_POST['staging_system'] ?? '';

$t_category =
    $_POST['t_category'] ?? '';

$n_category =
    $_POST['n_category'] ?? '';

$m_category =
    $_POST['m_category'] ?? '';

$tnm_stage =
    $_POST['tnm_stage'] ?? '';

$stage =
    $_POST['stage'] ?? '';

$remarks =
    $_POST['remarks'] ?? '';



/* -------------------------------------------------------
   UPDATE QUERY
------------------------------------------------------- */

$sql = "UPDATE diagnosis SET

    diagnosis_date = ?,
    diagnosis_method = ?,
    symptom_duration = ?,
    microscopic_confirmation = ?,
    specimen_site = ?,
    pathology_slide_no = ?,
    pathology_report_date = ?,
    primary_site = ?,
    icd_code = ?,
    topography = ?,
    morphology = ?,
    histology = ?,
    laterality = ?,
    secondary_site = ?,
    tumour_behaviour = ?,
    clinical_extent = ?,
    lymph_node_involvement = ?,
    distant_metastasis = ?,
    staging_system = ?,
    t_category = ?,
    n_category = ?,
    m_category = ?,
    tnm_stage = ?,
    stage = ?,
    remarks = ?

    WHERE id = ?";


/* -------------------------------------------------------
   PREPARE QUERY
------------------------------------------------------- */

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {

    die(
        "Prepare failed: " .
        mysqli_error($conn)
    );

}


/* -------------------------------------------------------
   BIND PARAMETERS
-------------------------------------------------------

   25 string values
   +
   1 integer ID

   Therefore:

   sssssssssssssssssssssssss = 25 strings
   i = integer ID

------------------------------------------------------- */

$stmt->bind_param(

    "sssssssssssssssssssssssssi",

    $diagnosis_date,
    $diagnosis_method,
    $symptom_duration,
    $microscopic_confirmation,
    $specimen_site,
    $pathology_slide_no,
    $pathology_report_date,
    $primary_site,
    $icd_code,
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
    $remarks,
    $id

);


/* -------------------------------------------------------
   EXECUTE UPDATE
------------------------------------------------------- */

if ($stmt->execute()) {

    /*
       SUCCESS
       Return to diagnosis list
    */

    $stmt->close();

    header(
        "Location: ../diagnosis/diagnosis_list.php?updated=1"
    );

    exit();

}


/* -------------------------------------------------------
   UPDATE ERROR
------------------------------------------------------- */

else {

    echo "<div style='
        margin:40px;
        padding:25px;
        background:#fff3f3;
        border:1px solid #e0a0a0;
        border-radius:8px;
        font-family:Arial,sans-serif;
        color:#8b0000;
    '>";

    echo "<h3>Diagnosis Update Failed</h3>";

    echo "<p>";

    echo htmlspecialchars($stmt->error);

    echo "</p>";

    echo "<p>";

    echo "<a href='../diagnosis/diagnosis_list.php'>
            Back to Diagnosis List
          </a>";

    echo "</p>";

    echo "</div>";

}


$stmt->close();

mysqli_close($conn);

?>
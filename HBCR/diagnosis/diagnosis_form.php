<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");

/* =====================================================
   FETCH PATIENTS
===================================================== */

$patients = mysqli_query(
    $conn,
    "SELECT
        id,
        aadhaar,
        abha_id,
        hbcr_no,
        hospital_no,
        first_name,
        middle_name,
        last_name,
        age,
        gender,
        mobile,
        address,
        house_no,
        street_name,
        locality,
        ward,
        city,
        sub_district,
        district,
        pin,
        state
     FROM patients
     ORDER BY first_name, last_name"
);

if (!$patients) {
    die("Database Error: " . mysqli_error($conn));
}
?>

<div class="main-content">

<div class="page-header">
    <h2><i class="fa fa-stethoscope"></i> Diagnosis Entry</h2>
    <p>Hospital Based Cancer Registry System</p>
</div>


<form action="save_diagnosis.php" method="POST" id="diagnosisForm" novalidate>


<!-- =====================================================
     PATIENT SELECTION
===================================================== -->

<div class="card">

<h3>Select Patient</h3>

<div class="form-group">

<label class="required">Search / Select Patient</label>

<!-- ONE FIELD ONLY -->

<input
    type="text"
    id="patient_search"
    class="form-control"
    list="patientList"
    placeholder="Type Aadhaar number or select patient"
    autocomplete="off"
    required>

<datalist id="patientList">

<?php while($row = mysqli_fetch_assoc($patients)) {

    $full_name = trim(
        ($row['first_name'] ?? '') . " " .
        ($row['middle_name'] ?? '') . " " .
        ($row['last_name'] ?? '')
    );

    /*
       Create address in ONE LINE
    */

    $addressParts = [];

    if (!empty($row['address'])) {
        $addressParts[] = $row['address'];
    }

    if (!empty($row['house_no'])) {
        $addressParts[] = $row['house_no'];
    }

    if (!empty($row['street_name'])) {
        $addressParts[] = $row['street_name'];
    }

    if (!empty($row['locality'])) {
        $addressParts[] = $row['locality'];
    }

    if (!empty($row['ward'])) {
        $addressParts[] = $row['ward'];
    }

    if (!empty($row['city'])) {
        $addressParts[] = $row['city'];
    }

    if (!empty($row['sub_district'])) {
        $addressParts[] = $row['sub_district'];
    }

    if (!empty($row['district'])) {
        $addressParts[] = $row['district'];
    }

    if (!empty($row['pin'])) {
        $addressParts[] = $row['pin'];
    }

    if (!empty($row['state'])) {
        $addressParts[] = $row['state'];
    }

    $address = implode(", ", array_unique($addressParts));

    /*
       IMPORTANT:
       The visible value contains Aadhaar + Name.
       This allows the dropdown to show both.
    */

    $displayValue =
        ($row['aadhaar'] ?? '') .
        " - " .
        $full_name;
?>

<option
    value="<?php echo htmlspecialchars($displayValue); ?>"
    data-id="<?php echo htmlspecialchars($row['id']); ?>"
    data-aadhaar="<?php echo htmlspecialchars($row['aadhaar'] ?? ''); ?>"
    data-abha="<?php echo htmlspecialchars($row['abha_id'] ?? ''); ?>"
    data-hbcr="<?php echo htmlspecialchars($row['hbcr_no'] ?? ''); ?>"
    data-hospital="<?php echo htmlspecialchars($row['hospital_no'] ?? ''); ?>"
    data-name="<?php echo htmlspecialchars($full_name); ?>"
    data-age="<?php echo htmlspecialchars($row['age'] ?? ''); ?>"
    data-gender="<?php echo htmlspecialchars($row['gender'] ?? ''); ?>"
    data-mobile="<?php echo htmlspecialchars($row['mobile'] ?? ''); ?>"
    data-address="<?php echo htmlspecialchars($address); ?>"
>

<?php echo htmlspecialchars($displayValue); ?>

</option>

<?php } ?>

</datalist>


<!-- Hidden patient ID sent to save_diagnosis.php -->

<input
    type="hidden"
    name="patient_id"
    id="patient_id">


<small class="field-help">
    Type Aadhaar number or open the list and select Aadhaar - Patient Name.
</small>

</div>

</div>


<!-- =====================================================
     PATIENT INFORMATION
===================================================== -->

<div class="card">

<h3>Patient Information</h3>

<div class="row">


<div class="form-group">

<label>Aadhaar No.</label>

<input
    type="text"
    id="aadhaar"
    class="form-control"
    readonly>

</div>


<div class="form-group">

<label>ABHA ID</label>

<input
    type="text"
    id="abha"
    class="form-control"
    readonly>

</div>


<div class="form-group">

<label>HBCR No.</label>

<input
    type="text"
    id="hbcr"
    class="form-control"
    readonly>

</div>


<div class="form-group">

<label>Hospital Registration No.</label>

<input
    type="text"
    id="hospital"
    class="form-control"
    readonly>

</div>


<div class="form-group">

<label>Patient Name</label>

<input
    type="text"
    id="name"
    class="form-control"
    readonly>

</div>


<div class="form-group">

<label>Age</label>

<input
    type="text"
    id="age"
    class="form-control"
    readonly>

</div>


<div class="form-group">

<label>Gender</label>

<input
    type="text"
    id="gender"
    class="form-control"
    readonly>

</div>


<div class="form-group">

<label>Mobile</label>

<input
    type="text"
    id="mobile"
    class="form-control"
    readonly>

</div>


<div class="form-group full">

<label>Address</label>

<input
    type="text"
    id="address"
    class="form-control"
    readonly>

</div>

</div>

</div>


<!-- =====================================================
     DIAGNOSIS INFORMATION
===================================================== -->

<div class="card">

<h3>Diagnosis Information</h3>

<div class="row">


<div class="form-group">

<label class="required">Date of Diagnosis</label>

<input
    type="date"
    name="diagnosis_date"
    class="form-control"
    value="<?php echo date('Y-m-d'); ?>"
    required>

</div>


<div class="form-group">

<label class="required">Method of Diagnosis</label>

<select
    name="diagnosis_method"
    class="form-control"
    required>

<option value="">-- Select Method --</option>

<option>Clinical Examination</option>
<option>Biopsy</option>
<option>FNAC</option>
<option>Histopathology</option>
<option>Cytology</option>
<option>Imaging</option>
<option>Other</option>

</select>

</div>


<div class="form-group">

<label>Duration of Symptoms</label>

<input
    type="text"
    name="symptom_duration"
    class="form-control"
    placeholder="Example: 3 months">

</div>


<div class="form-group">

<label>Microscopic Confirmation</label>

<select
    name="microscopic_confirmation"
    class="form-control">

<option value="">-- Select --</option>

<option>Yes</option>
<option>No</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group full">

<label>Site of Specimen / Biopsy</label>

<input
    type="text"
    name="specimen_site"
    class="form-control"
    placeholder="Anatomical site">

</div>


<div class="form-group">

<label>Pathology / Slide No.</label>

<input
    type="text"
    name="pathology_slide_no"
    class="form-control">

</div>


<div class="form-group">

<label>Pathology Report Date</label>

<input
    type="date"
    name="pathology_report_date"
    class="form-control">

</div>

</div>

</div>


<!-- =====================================================
     PRIMARY SITE
===================================================== -->

<div class="card">

<h3>Primary Site / Topography</h3>

<div class="row">


<div class="form-group">

<label class="required">Primary Site</label>

<select
    name="primary_site"
    class="form-control"
    required>

<option value="">-- Select Primary Site --</option>

<option>Oral Cavity</option>
<option>Oropharynx</option>
<option>Nasopharynx</option>
<option>Hypopharynx</option>
<option>Larynx</option>
<option>Oesophagus</option>
<option>Stomach</option>
<option>Colon</option>
<option>Rectum</option>
<option>Liver</option>
<option>Pancreas</option>
<option>Lung</option>
<option>Breast</option>
<option>Cervix Uteri</option>
<option>Corpus Uteri</option>
<option>Ovary</option>
<option>Prostate</option>
<option>Kidney</option>
<option>Urinary Bladder</option>
<option>Brain</option>
<option>Thyroid</option>
<option>Skin</option>
<option>Other</option>

</select>

</div>


<div class="form-group">

<label>ICD-10 Code</label>

<input
    type="text"
    name="icd_code"
    class="form-control"
    placeholder="Example: C50.9">

</div>


<div class="form-group">

<label>ICD-O-3 Topography Code</label>

<input
    type="text"
    name="topography"
    class="form-control"
    placeholder="Example: C50.9">

</div>


<div class="form-group">

<label class="required">Laterality</label>

<select
    name="laterality"
    class="form-control"
    required>

<option value="">-- Select --</option>

<option>Right</option>
<option>Left</option>
<option>Bilateral</option>
<option>Not Applicable</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group">

<label>Secondary / Metastatic Site</label>

<input
    type="text"
    name="secondary_site"
    class="form-control">

</div>

</div>

</div>


<!-- =====================================================
     MORPHOLOGY
===================================================== -->

<div class="card">

<h3>Histology / Morphology</h3>

<div class="row">


<div class="form-group">

<label class="required">Histology</label>

<select
    name="histology"
    class="form-control"
    required>

<option value="">-- Select Histology --</option>

<option>Adenocarcinoma</option>
<option>Squamous Cell Carcinoma</option>
<option>Ductal Carcinoma</option>
<option>Lobular Carcinoma</option>
<option>Small Cell Carcinoma</option>
<option>Large Cell Carcinoma</option>
<option>Sarcoma</option>
<option>Lymphoma</option>
<option>Melanoma</option>
<option>Other</option>

</select>

</div>


<div class="form-group">

<label>ICD-O-3 Morphology Code</label>

<input
    type="text"
    name="morphology"
    class="form-control"
    placeholder="Example: 8500/3">

</div>


<div class="form-group">

<label class="required">Behaviour</label>

<select
    name="tumour_behaviour"
    class="form-control"
    required>

<option value="">-- Select --</option>

<option>Malignant</option>
<option>Benign</option>
<option>Uncertain</option>
<option>Unknown</option>

</select>

</div>

</div>

</div>


<!-- =====================================================
     EXTENT OF DISEASE
===================================================== -->

<div class="card">

<h3>Clinical Extent of Disease</h3>

<div class="row">


<div class="form-group">

<label class="required">Clinical Extent</label>

<select
    name="clinical_extent"
    class="form-control"
    required>

<option value="">-- Select --</option>

<option>Localized</option>
<option>Regional Spread</option>
<option>Distant Metastasis</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group">

<label>Regional Lymph Node Involvement</label>

<select
    name="lymph_node_involvement"
    class="form-control">

<option value="">-- Select --</option>

<option>Present</option>
<option>Absent</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group">

<label>Distant Metastasis</label>

<select
    name="distant_metastasis"
    class="form-control">

<option value="">-- Select --</option>

<option>Present</option>
<option>Absent</option>
<option>Unknown</option>

</select>

</div>

</div>

</div>


<!-- =====================================================
     TNM STAGING
===================================================== -->

<div class="card">

<h3>TNM Staging</h3>

<div class="row">


<div class="form-group">

<label>Staging System</label>

<select
    name="staging_system"
    class="form-control">

<option value="">-- Select --</option>

<option>TNM Clinical</option>
<option>TNM Pathological</option>
<option>Other</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group">

<label>T Category</label>

<select
    name="t_category"
    class="form-control">

<option value="">-- Select --</option>

<option>TX</option>
<option>T0</option>
<option>Tis</option>
<option>T1</option>
<option>T2</option>
<option>T3</option>
<option>T4</option>

</select>

</div>


<div class="form-group">

<label>N Category</label>

<select
    name="n_category"
    class="form-control">

<option value="">-- Select --</option>

<option>NX</option>
<option>N0</option>
<option>N1</option>
<option>N2</option>
<option>N2a</option>
<option>N2b</option>
<option>N3</option>

</select>

</div>


<div class="form-group">

<label>M Category</label>

<select
    name="m_category"
    class="form-control">

<option value="">-- Select --</option>

<option>MX</option>
<option>M0</option>
<option>M1</option>

</select>

</div>


<div class="form-group">

<label>TNM Stage</label>

<input
    type="text"
    name="tnm_stage"
    id="tnm_stage"
    class="form-control"
    placeholder="Example: T2N1M0">

</div>


<div class="form-group">

<label>Composite Stage</label>

<select
    name="stage"
    class="form-control">

<option value="">-- Select Stage --</option>

<option>Stage I</option>
<option>Stage II</option>
<option>Stage III</option>
<option>Stage IV</option>
<option>Unknown</option>

</select>

</div>

</div>

</div>


<!-- =====================================================
     ADDITIONAL INFORMATION
===================================================== -->

<div class="card">

<h3>Additional Information</h3>

<div class="form-group">

<label>Remarks / Additional Notes</label>

<textarea
    name="remarks"
    class="form-control"
    rows="4"
    placeholder="Enter any relevant clinical or diagnostic notes"></textarea>

</div>

</div>


<!-- =====================================================
     SAVE
===================================================== -->

<div style="margin:30px 0;">

<button
    type="submit"
    class="btn btn-primary btn-lg">

<i class="fa fa-save"></i>
Save Diagnosis

</button>

</div>

</form>

</div>


<script>

/* =====================================================
   PATIENT SEARCH / SELECTION
===================================================== */

const patientSearch =
    document.getElementById("patient_search");

const patientList =
    document.getElementById("patientList");

const patientId =
    document.getElementById("patient_id");


/*
   Find patient based on the value selected/typed.
*/

function findPatient(value) {

    const options =
        patientList.querySelectorAll("option");

    for (let option of options) {

        if (option.value === value) {

            return option;

        }

    }

    return null;
}


/*
   Also allow typing ONLY the Aadhaar number.
   Example:
   123456789012

   even though dropdown value is:

   123456789012 - Yash Sharma
*/

function findPatientByAadhaar(value) {

    const cleanValue =
        value.trim();

    const options =
        patientList.querySelectorAll("option");

    for (let option of options) {

        const aadhaar =
            option.dataset.aadhaar || "";

        if (aadhaar === cleanValue) {

            return option;

        }

    }

    return null;
}


/* =====================================================
   DISPLAY PATIENT DETAILS
===================================================== */

function displayPatient(option) {

    if (!option) {

        patientId.value = "";

        document.getElementById("aadhaar").value = "";
        document.getElementById("abha").value = "";
        document.getElementById("hbcr").value = "";
        document.getElementById("hospital").value = "";
        document.getElementById("name").value = "";
        document.getElementById("age").value = "";
        document.getElementById("gender").value = "";
        document.getElementById("mobile").value = "";
        document.getElementById("address").value = "";

        return;
    }


    patientId.value =
        option.dataset.id || "";


    document.getElementById("aadhaar").value =
        option.dataset.aadhaar || "";


    document.getElementById("abha").value =
        option.dataset.abha || "";


    document.getElementById("hbcr").value =
        option.dataset.hbcr || "";


    document.getElementById("hospital").value =
        option.dataset.hospital || "";


    document.getElementById("name").value =
        option.dataset.name || "";


    document.getElementById("age").value =
        option.dataset.age || "";


    document.getElementById("gender").value =
        option.dataset.gender || "";


    document.getElementById("mobile").value =
        option.dataset.mobile || "";


    document.getElementById("address").value =
        option.dataset.address || "";

}


/* =====================================================
   WHEN USER SELECTS FROM DROPDOWN
===================================================== */

patientSearch.addEventListener(
    "change",
    function() {

        let option =
            findPatient(this.value);

        /*
           If exact dropdown selection is not found,
           try Aadhaar number.
        */

        if (!option) {

            option =
                findPatientByAadhaar(this.value);

        }

        displayPatient(option);

    }
);


/* =====================================================
   WHEN USER TYPES AADHAAR
===================================================== */

patientSearch.addEventListener(
    "input",
    function() {

        let option =
            findPatient(this.value);

        if (!option) {

            option =
                findPatientByAadhaar(this.value);

        }

        if (option) {

            displayPatient(option);

        }

    }
);


/* =====================================================
   FORM VALIDATION
===================================================== */

document.getElementById("diagnosisForm").addEventListener(
    "submit",
    function(event) {

        /*
           Patient must be selected first.
        */

        if (patientId.value.trim() === "") {

            event.preventDefault();

            alert(
                "Please search or select a patient using Aadhaar number."
            );

            patientSearch.focus();

            return;

        }


        /*
           Other mandatory fields
        */

        const requiredFields =
            this.querySelectorAll("[required]");

        for (let field of requiredFields) {

            /*
               patient_search is already checked above.
            */

            if (
                field.id === "patient_search"
            ) {
                continue;
            }


            if (
                field.value.trim() === ""
            ) {

                event.preventDefault();

                let formGroup =
                    field.closest(".form-group");

                let label =
                    formGroup ?
                    formGroup.querySelector("label") :
                    null;

                let fieldName =
                    label ?
                    label.textContent
                        .replace("*", "")
                        .trim() :
                    "This field";

                alert(
                    fieldName +
                    " is mandatory."
                );

                field.focus();

                return;

            }

        }

    }
);

</script>


<style>
/* =========================================================
   HBCR DIAGNOSIS FORM
   PROFESSIONAL PATIENT-REGISTRATION STYLE
   DESIGN ONLY - DO NOT CHANGE FORM FIELDS
========================================================= */


/* =========================================================
   MAIN PAGE
========================================================= */

.main-content {
    padding: 28px 34px 50px;
    background: #f5f7f7;
    min-height: 100vh;
    box-sizing: border-box;
}


/* =========================================================
   PROFESSIONAL PAGE HEADER
========================================================= */

.page-header {
    position: relative;
    background: linear-gradient(135deg, #164e4a, #1d625d);
    border-radius: 12px;
    padding: 25px 30px;
    margin-bottom: 26px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(22, 78, 74, 0.16);
}

.page-header::after {
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    right: -55px;
    top: -85px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
}

.page-header::before {
    content: "";
    position: absolute;
    width: 100px;
    height: 100px;
    right: 80px;
    bottom: -65px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.page-header h2 {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;

    margin: 0;

    color: #ffffff;

    font-size: 25px;
    font-weight: 700;

    letter-spacing: 0.2px;
}

.page-header h2 i {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    width: 42px;
    height: 42px;

    margin-right: 13px;

    background: rgba(255,255,255,0.14);

    border: 1px solid rgba(255,255,255,0.18);

    border-radius: 9px;

    color: #ffffff;

    font-size: 18px;
}

.page-header p {
    position: relative;
    z-index: 2;

    margin: 7px 0 0 55px;

    color: rgba(255,255,255,0.78);

    font-size: 12px;

    letter-spacing: 0.3px;
}
/* =========================================================
   FORM
========================================================= */

#diagnosisForm {
    width: 100%;
}


/* =========================================================
   CARD / SECTION
========================================================= */

.card {
    width: 100%;
    box-sizing: border-box;

    background: #ffffff;

    border: 1px solid #dfe7e5;
    border-radius: 10px;

    padding: 25px 27px 28px;

    margin-bottom: 23px;

    box-shadow: 0 2px 9px rgba(0,0,0,0.035);
}


/* =========================================================
   SECTION TITLE
========================================================= */

.card h3 {
    margin: -25px -27px 25px;

    padding: 15px 22px;

    background: #f0f6f5;

    border-left: 4px solid #164e4a;
    border-bottom: 1px solid #dce7e5;

    border-radius: 10px 10px 0 0;

    color: #164e4a;

    font-size: 16px;
    font-weight: 700;

    line-height: 1.4;
}


/* =========================================================
   FORM GRID
========================================================= */

/*
   3 columns on large screens.
   This keeps the form compact but still spacious.
*/

.card .row {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    column-gap: 25px;
    row-gap: 21px;

    margin: 0;
    padding: 0;
}


/* =========================================================
   FORM GROUP
========================================================= */

.card .form-group {
    width: 100%;
    min-width: 0;

    margin: 0;
    padding: 0;

    box-sizing: border-box;
}


/* =========================================================
   FULL WIDTH FIELD
========================================================= */

.card .form-group.full {
    grid-column: 1 / -1;
}


/* =========================================================
   LABEL
========================================================= */

.card .form-group label {
    display: block;

    margin: 0 0 7px;

    color: #344545;

    font-size: 13px;
    font-weight: 600;

    line-height: 1.4;
}


/* =========================================================
   REQUIRED LABEL
========================================================= */

.card .form-group label.required {
    color: #344545;
}


/*
   Keep the required indicator visible
   without making the complete label red.
*/

.card .form-group label.required::after {
    content: " *";

    color: #dc3545;
    font-weight: 700;
}


/* =========================================================
   INPUT / SELECT / TEXTAREA
========================================================= */

.card .form-control {
    display: block;

    width: 100%;
    max-width: 100%;

    height: 43px;

    padding: 9px 12px;

    box-sizing: border-box;

    background: #ffffff;

    border: 1px solid #cfd9d7;
    border-radius: 7px;

    color: #263635;

    font-family: inherit;
    font-size: 13px;

    transition:
        border-color 0.18s ease,
        box-shadow 0.18s ease,
        background-color 0.18s ease;
}


/* =========================================================
   TEXTAREA
========================================================= */

.card textarea.form-control {
    height: auto;

    min-height: 105px;

    padding: 11px 12px;

    line-height: 1.5;

    resize: vertical;
}


/* =========================================================
   SELECT
========================================================= */

.card select.form-control {
    cursor: pointer;
}


/* =========================================================
   INPUT HOVER
========================================================= */

.card .form-control:hover {
    border-color: #aebdb9;
}


/* =========================================================
   INPUT FOCUS
========================================================= */

.card .form-control:focus {
    outline: none;

    border-color: #164e4a;

    box-shadow:
        0 0 0 3px rgba(22,78,74,0.09);

    background: #ffffff;
}


/* =========================================================
   PLACEHOLDER
========================================================= */

.card .form-control::placeholder {
    color: #9aa6a4;

    font-size: 12px;

    opacity: 1;
}


/* =========================================================
   READONLY PATIENT INFORMATION
========================================================= */

.card .form-control[readonly] {
    background: #f3f6f5;

    border-color: #d6dfdd;

    color: #5e6c6a;

    cursor: default;
}


/* =========================================================
   PATIENT SEARCH FIELD
========================================================= */

#patient_search {
    height: 45px;

    background: #ffffff;

    border: 1px solid #bfcfcb;

    font-size: 13px;
}


/* =========================================================
   HELP TEXT
========================================================= */

.field-help,
.form-help {
    display: block;

    margin-top: 6px;

    color: #778583;

    font-size: 11px;

    line-height: 1.5;
}


/* =========================================================
   BUTTON AREA
========================================================= */

form > div[style*="margin:30px"] {
    display: flex;

    justify-content: flex-end;
    align-items: center;

    margin: 27px 0 0 !important;

    padding: 0;
}


/* =========================================================
   SAVE BUTTON
========================================================= */

form .btn-primary {
    min-width: 155px;

    padding: 11px 23px;

    background: #164e4a !important;

    border: 1px solid #164e4a !important;
    border-radius: 7px;

    color: #ffffff !important;

    font-size: 13px;
    font-weight: 600;

    box-shadow: 0 3px 8px rgba(22,78,74,0.15);

    transition:
        background-color 0.18s ease,
        transform 0.18s ease,
        box-shadow 0.18s ease;
}


form .btn-primary:hover {
    background: #103d3a !important;

    border-color: #103d3a !important;

    transform: translateY(-1px);

    box-shadow: 0 5px 12px rgba(22,78,74,0.20);
}


form .btn-primary:active {
    transform: translateY(0);
}


/* =========================================================
   PHONE INPUT SUPPORT
========================================================= */

.phone-input {
    display: flex;

    width: 100%;
}


.phone-prefix {
    display: flex;

    align-items: center;
    justify-content: center;

    min-width: 55px;

    padding: 0 10px;

    background: #f1f4f4;

    border: 1px solid #cfd8d8;
    border-right: none;

    border-radius: 7px 0 0 7px;

    color: #445454;

    font-size: 13px;
    font-weight: 600;
}


.phone-input .form-control {
    border-radius: 0 7px 7px 0;
}


/* =========================================================
   NUMBER INPUT
========================================================= */

input[type="number"] {
    appearance: textfield;
    -moz-appearance: textfield;
}


input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1100px) {

    .main-content {
        padding: 24px 25px 45px;
    }

    .card .row {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        column-gap: 22px;
        row-gap: 20px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 700px) {

    .main-content {
        padding: 18px 15px 35px;
    }

    .page-header {
        padding: 19px 20px;
    }

    .page-header h2 {
        font-size: 20px;
    }

    .card {
        padding: 21px 19px 23px;

        margin-bottom: 18px;
    }

    .card h3 {
        margin: -21px -19px 22px;

        padding: 14px 17px;

        font-size: 15px;
    }

    .card .row {
        grid-template-columns: 1fr;

        row-gap: 17px;
    }

    .card .form-group.full {
        grid-column: auto;
    }

    form > div[style*="margin:30px"] {
        justify-content: stretch;
    }

    form .btn-primary {
        width: 100%;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 450px) {

    .main-content {
        padding: 14px 10px 30px;
    }

    .page-header {
        padding: 17px;
    }

    .page-header h2 {
        font-size: 19px;
    }

    .card {
        padding: 18px 15px 20px;
    }

    .card h3 {
        margin: -18px -15px 19px;

        padding: 13px 14px;

        font-size: 14px;
    }

    .card .form-control {
        height: 41px;
    }

    .card textarea.form-control {
        min-height: 95px;
    }

}
/* =========================================================
   FINAL DIAGNOSIS FORM SPACING
   KEEP EXISTING 3-COLUMN LAYOUT
========================================================= */

/* Give the whole form more breathing room */
.main-content {
    padding-left: 45px !important;
    padding-right: 45px !important;
}


/* Make the Diagnosis Entry heading look cleaner */
.page-header {
    padding: 24px 30px !important;
    margin-bottom: 28px !important;
    border-radius: 10px !important;
}

.page-header h2 {
    font-size: 25px !important;
    margin-bottom: 7px !important;
}

.page-header p {
    font-size: 13px !important;
}


/* Make each section comfortably spaced */
.card {
    padding: 27px 32px 30px !important;
    margin-bottom: 26px !important;
}


/* Keep your SAME 3 columns,
   only increase the space between them */
.card .row {
    grid-template-columns: repeat(3, minmax(0, 1fr)) !important;

    column-gap: 30px !important;
    row-gap: 24px !important;

    width: 100%;
}


/* Give every field proper breathing space */
.card .form-group {
    width: 100%;
    min-width: 0;
}


/* Labels */
.card .form-group label {
    margin-bottom: 8px !important;
}


/* Fields */
.card .form-control {
    width: 100% !important;
    height: 44px !important;

    padding-left: 13px !important;
    padding-right: 13px !important;

    box-sizing: border-box;
}


/* Full-width fields remain full-width */
.card .form-group.full {
    grid-column: 1 / -1 !important;
}


/* Patient information readonly fields */
.card .form-control[readonly] {
    background: #f4f6f6 !important;
}


/* Section headings */
.card h3 {
    margin-bottom: 27px !important;
    padding: 16px 22px !important;
}


/* Search patient area */
#patient_search {
    height: 45px !important;
}


/* Help text */
.field-help {
    margin-top: 7px !important;
}


/* Save button area */
form > div[style*="margin:30px"] {
    margin-top: 30px !important;
}


/* =========================================================
   SCREEN SIZE ADJUSTMENT
========================================================= */

@media (max-width: 1100px) {

    .main-content {
        padding-left: 28px !important;
        padding-right: 28px !important;
    }

    .card {
        padding-left: 27px !important;
        padding-right: 27px !important;
    }

    .card .row {
        column-gap: 24px !important;
        row-gap: 22px !important;
    }
}


@media (max-width: 700px) {

    .main-content {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .card {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }

    .card .row {
        grid-template-columns: 1fr !important;
        gap: 18px !important;
    }
}
/* =========================================================
   FINAL FIX - DIAGNOSIS CONTENT POSITION & SPACING
   DO NOT CHANGE HEADER
========================================================= */

/* Push ONLY the page content down below the header */
/* =========================================================
   FINAL FIX - CONTENT BELOW TOP HEADER
========================================================= */

body .main-content {
    padding-top: 85px !important;
    padding-left: 30px !important;
    padding-right: 30px !important;
    box-sizing: border-box !important;
}


/* Space between Diagnosis Entry banner and first card */
body .main-content .page-header {
    margin-top: 0 !important;
    margin-bottom: 24px !important;
}


/* Proper card spacing */
body .main-content .card {
    margin-top: 0 !important;
    margin-bottom: 24px !important;
    padding: 25px 28px 28px !important;
    box-sizing: border-box !important;
}


/* Section heading */
body .main-content .card h3 {
    margin-top: -25px !important;
    margin-left: -28px !important;
    margin-right: -28px !important;
    margin-bottom: 24px !important;

    padding: 15px 18px !important;

    line-height: 1.5 !important;
    box-sizing: border-box !important;
}


/* Proper field spacing */
body .main-content .card .row {
    column-gap: 26px !important;
    row-gap: 22px !important;
}


/* Labels */
body .main-content .card .form-group label {
    display: block !important;
    margin-bottom: 7px !important;
    line-height: 1.4 !important;
}


/* Input spacing */
body .main-content .card .form-control {
    height: 43px !important;
    box-sizing: border-box !important;
}


/* Patient search */
body .main-content #patient_search {
    height: 45px !important;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 700px) {

    body .main-content {
        padding-top: 25px !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    body .main-content .card {
        padding-left: 18px !important;
        padding-right: 18px !important;
    }

    body .main-content .card h3 {
        margin-left: -18px !important;
        margin-right: -18px !important;
    }
}
</style>

<?php
include("../includes/footer.php");
?>
<?php
include("../includes/header.php");
include("../includes/sidebar.php");
?>

<div class="main-content">

<div class="page-header">
    <h2><i class="fa fa-user-plus"></i> HBCR Patient Registration</h2>
    <p>Hospital Based Cancer Registry System</p>
</div>

<form action="save_patient.php" method="POST" id="patientForm" novalidate>

<!-- =====================================================
     SECTION 1 - IDENTIFYING INFORMATION
===================================================== -->

<div class="card">

<h3>Section I - Identifying Information / Demographic Details</h3>

<div class="row">

<div class="form-group">
<label>Reporting Institution <span class="required">*</span></label>
<select name="institution" class="form-control" required>
    <option value="">Select Institution</option>
    <option>Government Hospital</option>
    <option>Private Hospital</option>
    <option>Medical College</option>
    <option>Cancer Institute</option>
    <option>Other</option>
</select>
</div>

<div class="form-group">
<label>Centre Code <span class="required">*</span></label>
<input
    type="text"
    name="centre_code"
    class="form-control"
    required
    maxlength="20">
</div>

<div class="form-group">
<label>HBCR Registration No.</label>
<input
    type="text"
    class="form-control"
    value="Auto Generated"
    readonly>
</div>

<div class="form-group">
<label>Department <span class="required">*</span></label>
<input
    type="text"
    name="department"
    class="form-control"
    required
    maxlength="100">
</div>

<div class="form-group">
<label>Unit Number</label>
<input
    type="text"
    name="unit_number"
    class="form-control"
    maxlength="30">
</div>

<div class="form-group">
<label>Hospital Registration No.</label>
<input
    type="text"
    class="form-control"
    value="Auto Generated"
    readonly>
</div>

<div class="form-group">
<label>Date of Reporting at RI <span class="required">*</span></label>
<input
    type="date"
    name="report_date"
    id="report_date"
    class="form-control"
    value="<?php echo date('Y-m-d'); ?>"
    max="<?php echo date('Y-m-d'); ?>"
    required>
</div>

<div class="form-group">
<label>Date of First Diagnosis <span class="required">*</span></label>
<input
    type="date"
    name="first_diagnosis_date"
    id="first_diagnosis_date"
    class="form-control"
    max="<?php echo date('Y-m-d'); ?>"
    required>
</div>

</div>
</div>


<!-- =====================================================
     CASE REGISTRATION / REFERRAL
===================================================== -->

<div class="card">

<h3>Case Registration & Referral</h3>

<div class="row">

<div class="form-group">
<label>Case Registered Through <span class="required">*</span></label>
<select name="case_registered_through" class="form-control" required>
    <option value="">Select</option>
    <option>Out-patient</option>
    <option>In-patient</option>
    <option>In-patient (Emergency)</option>
    <option>Other</option>
</select>
</div>

<div class="form-group">
<label>Type of Referral <span class="required">*</span></label>
<select name="referral_type" class="form-control" required>
    <option value="">Select</option>
    <option>Self</option>
    <option>Other Hospital / Health Facility</option>
    <option>Screen Detected Referral</option>
    <option>Unknown</option>
</select>
</div>

<div class="form-group full">
<label>Name of Referral Facility</label>
<input
    type="text"
    name="referral_facility"
    class="form-control"
    maxlength="150">
</div>

<div class="form-group">
<label>Referral City</label>
<input
    type="text"
    name="referral_city"
    class="form-control"
    maxlength="100">
</div>

<div class="form-group">
<label>Referral District</label>
<input
    type="text"
    name="referral_district"
    class="form-control"
    maxlength="100">
</div>

<div class="form-group">
<label>Referral PIN Code</label>
<input
    type="text"
    name="referral_pin"
    class="form-control"
    inputmode="numeric"
    maxlength="6"
    pattern="[0-9]{6}">
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
<label>First Name <span class="required">*</span></label>
<input
    type="text"
    name="first_name"
    class="form-control"
    required
    maxlength="100"
    autocomplete="given-name">
</div>

<div class="form-group">
<label>Middle Name</label>
<input
    type="text"
    name="middle_name"
    class="form-control"
    maxlength="100">
</div>

<div class="form-group">
<label>Last Name <span class="required">*</span></label>
<input
    type="text"
    name="last_name"
    class="form-control"
    required
    maxlength="100"
    autocomplete="family-name">
</div>

<!-- AGE AUTOMATICALLY CALCULATED -->

<div class="form-group">
<label>Age (Completed Years) <span class="required">*</span></label>
<input
    type="number"
    name="age"
    id="age"
    class="form-control"
    min="0"
    max="120"
    readonly
    required>
<small class="field-help">
    
</small>
</div>

<div class="form-group">
<label>Date of Birth <span class="required">*</span></label>
<input
    type="date"
    name="dob"
    id="dob"
    class="form-control"
    max="<?php echo date('Y-m-d'); ?>"
    required>
</div>

<div class="form-group">
<label>Sex <span class="required">*</span></label>
<select name="gender" class="form-control" required>
    <option value="">Select</option>
    <option>Male</option>
    <option>Female</option>
    <option>Other</option>
    <option>Unknown</option>
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
<label>Aadhaar Number <span class="required">*</span></label>
<input
    type="text"
    name="aadhaar"
    id="aadhaar"
    class="form-control"
    required
    inputmode="numeric"
    maxlength="12"
    minlength="12"
    pattern="[0-9]{12}"
    placeholder="Enter 12 digit Aadhaar number">

<small class="field-help">
    Enter exactly 12 digits.
</small>
</div>

<div class="form-group">
<label>ABHA (Health ID)</label>
<input
    type="text"
    name="abha_id"
    class="form-control"
    maxlength="50">
</div>

<div class="form-group">
<label>Beneficiary Health Scheme Name / No.</label>
<input
    type="text"
    name="health_scheme"
    class="form-control"
    maxlength="150">
</div>

<div class="form-group">
<label>ID Status <span class="required">*</span></label>
<select name="id_status" class="form-control" required>
    <option value="">Select</option>
    <option>Known</option>
    <option>Unknown</option>
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
<label>Relationship <span class="required">*</span></label>
<select name="next_kin_relation" class="form-control" required>
    <option value="">Select</option>
    <option>Father</option>
    <option>Mother</option>
    <option>Husband</option>
    <option>Wife</option>
    <option>Son</option>
    <option>Daughter</option>
    <option>Other</option>
</select>
</div>

<div class="form-group">
<label>Name <span class="required">*</span></label>
<input
    type="text"
    name="next_kin_name"
    class="form-control"
    required
    maxlength="150">
</div>

<div class="form-group">

<label>Mobile <span class="required">*</span></label>

<div class="phone-input">

<span class="phone-prefix">+91</span>

<input
    type="tel"
    name="next_kin_mobile"
    class="form-control phone-field"
    required
    inputmode="numeric"
    maxlength="10"
    minlength="10"
    pattern="[0-9]{10}"
    placeholder="Enter 10 digit mobile number">

</div>

</div>

</div>
</div>


<!-- =====================================================
     ADDRESS
===================================================== -->

<div class="card">

<h3>Address of Residence of Patient</h3>

<div class="row">

<div class="form-group">
<label>Place of Usual Residence <span class="required">*</span></label>
<select name="residence_type" class="form-control" required>
    <option value="">Select</option>
    <option>Urban Area (Town / Cities)</option>
    <option>Non-urban / Rural Area</option>
</select>
</div>

<div class="form-group">
<label>House / Building No.</label>
<input
    type="text"
    name="house_no"
    class="form-control"
    maxlength="50">
</div>

<div class="form-group">
<label>Road / Street Name</label>
<input
    type="text"
    name="street_name"
    class="form-control"
    maxlength="150">
</div>

<div class="form-group">
<label>Area / Locality / Panchayat</label>
<input
    type="text"
    name="locality"
    class="form-control"
    maxlength="150">
</div>

<div class="form-group">
<label>Ward / Corporation</label>
<input
    type="text"
    name="ward"
    class="form-control"
    maxlength="100">
</div>

<div class="form-group">
<label>Village / City / Town <span class="required">*</span></label>
<input
    type="text"
    name="city"
    class="form-control"
    required
    maxlength="100">
</div>

<div class="form-group">
<label>Sub-Unit of District (Taluk / Tehsil / Other)</label>
<input
    type="text"
    name="sub_district"
    class="form-control"
    maxlength="100">
</div>

<div class="form-group">
<label>District <span class="required">*</span></label>
<input
    type="text"
    name="district"
    class="form-control"
    required
    maxlength="100">
</div>

<div class="form-group">
<label>PIN Code <span class="required">*</span></label>
<input
    type="text"
    name="pin"
    class="form-control"
    required
    inputmode="numeric"
    maxlength="6"
    minlength="6"
    pattern="[0-9]{6}"
    placeholder="6 digit PIN code">
</div>

<div class="form-group">
<label>State / UT <span class="required">*</span></label>
<input
    type="text"
    name="state"
    class="form-control"
    required
    maxlength="100">
</div>


<!-- MOBILE 1 -->

<div class="form-group">

<label>Mobile No. 1 <span class="required">*</span></label>

<div class="phone-input">

<span class="phone-prefix">+91</span>

<input
    type="tel"
    name="mobile"
    class="form-control phone-field"
    required
    inputmode="numeric"
    maxlength="10"
    minlength="10"
    pattern="[0-9]{10}"
    placeholder="Enter 10 digit mobile number">

</div>

</div>


<!-- MOBILE 2 -->

<div class="form-group">

<label>Mobile No. 2</label>

<div class="phone-input">

<span class="phone-prefix">+91</span>

<input
    type="tel"
    name="mobile2"
    class="form-control phone-field"
    inputmode="numeric"
    maxlength="10"
    minlength="10"
    pattern="[0-9]{10}"
    placeholder="Enter 10 digit mobile number">

</div>

</div>


<div class="form-group">
<label>Email ID</label>
<input
    type="email"
    name="email"
    id="email"
    class="form-control"
    maxlength="150"
    placeholder="example@email.com">
</div>

<div class="form-group">
<label>Duration at Residence (Years) <span class="required">*</span></label>
<input
    type="number"
    name="residence_duration"
    class="form-control"
    min="0"
    max="120"
    required>
</div>

</div>
</div>


<!-- =====================================================
     PERMANENT ADDRESS
===================================================== -->

<div class="card">

<h3>Permanent Address</h3>

<div class="row">

<div class="form-group">
<label>Village <span class="required">*</span></label>
<input
    type="text"
    name="permanent_village"
    class="form-control"
    required
    maxlength="100">
</div>

<div class="form-group">
<label>Town / City <span class="required">*</span></label>
<input
    type="text"
    name="permanent_city"
    class="form-control"
    required
    maxlength="100">
</div>

<div class="form-group">
<label>District <span class="required">*</span></label>
<input
    type="text"
    name="permanent_district"
    class="form-control"
    required
    maxlength="100">
</div>

<div class="form-group">
<label>PIN Code <span class="required">*</span></label>
<input
    type="text"
    name="permanent_pin"
    class="form-control"
    required
    inputmode="numeric"
    maxlength="6"
    minlength="6"
    pattern="[0-9]{6}"
    placeholder="6 digit PIN code">
</div>

<div class="form-group">
<label>State / UT <span class="required">*</span></label>
<input
    type="text"
    name="permanent_state"
    class="form-control"
    required
    maxlength="100">
</div>

</div>
</div>


<!-- =====================================================
     MARITAL + EDUCATION
===================================================== -->

<div class="card">

<h3>Demographic Details</h3>

<div class="row">

<div class="form-group">
<label>Marital Status <span class="required">*</span></label>
<select name="marital_status" class="form-control" required>
    <option value="">Select</option>
    <option>Unmarried</option>
    <option>Married</option>
    <option>Widowed</option>
    <option>Divorced</option>
    <option>Separated</option>
    <option>Other</option>
    <option>Unknown</option>
</select>
</div>

<div class="form-group">
<label>Education <span class="required">*</span></label>
<select name="education" class="form-control" required>
    <option value="">Select</option>
    <option>Not applicable</option>
    <option>Illiterate</option>
    <option>Literate</option>
    <option>Primary</option>
    <option>Middle</option>
    <option>Secondary / Higher Secondary</option>
    <option>Technical - After Matric</option>
    <option>Graduate and Above</option>
    <option>Other</option>
    <option>Unknown</option>
</select>
</div>

</div>
</div>


<!-- =====================================================
     HABITS
===================================================== -->

<div class="card">

<h3>Habits</h3>

<p class="form-help">
Record whether the patient has the habit and, where applicable,
the duration in months.
</p>

<div class="row">

<div class="form-group">
<label>Smoking <span class="required">*</span></label>
<select name="smoking" class="form-control" required>
    <option value="">Select</option>
    <option>Yes</option>
    <option>Never</option>
    <option>Unknown</option>
</select>
</div>

<div class="form-group">
<label>Smoking Duration (Months)</label>
<input
    type="number"
    name="smoking_duration"
    class="form-control"
    min="0">
</div>

<div class="form-group">
<label>Smokeless Tobacco <span class="required">*</span></label>
<select name="smokeless" class="form-control" required>
    <option value="">Select</option>
    <option>Yes</option>
    <option>Never</option>
    <option>Unknown</option>
</select>
</div>

<div class="form-group">
<label>Smokeless Tobacco Duration (Months)</label>
<input
    type="number"
    name="smokeless_duration"
    class="form-control"
    min="0">
</div>

<div class="form-group">
<label>Betel Nut with Tobacco <span class="required">*</span></label>
<select name="betelnut_tobacco" class="form-control" required>
    <option value="">Select</option>
    <option>Yes</option>
    <option>Never</option>
    <option>Unknown</option>
</select>
</div>

<div class="form-group">
<label>Betel Nut with Tobacco Duration (Months)</label>
<input
    type="number"
    name="betelnut_tobacco_duration"
    class="form-control"
    min="0">
</div>

<div class="form-group">
<label>Betel Nut without Tobacco <span class="required">*</span></label>
<select name="betelnut" class="form-control" required>
    <option value="">Select</option>
    <option>Yes</option>
    <option>Never</option>
    <option>Unknown</option>
</select>
</div>

<div class="form-group">
<label>Betel Nut Duration (Months)</label>
<input
    type="number"
    name="betelnut_duration"
    class="form-control"
    min="0">
</div>

<div class="form-group">
<label>Alcohol Use <span class="required">*</span></label>
<select name="alcohol" class="form-control" required>
    <option value="">Select</option>
    <option>Yes</option>
    <option>Never</option>
    <option>Unknown</option>
</select>
</div>

<div class="form-group">
<label>Alcohol Duration (Months)</label>
<input
    type="number"
    name="alcohol_duration"
    class="form-control"
    min="0">
</div>

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
    "Tuberculosis" => "tuberculosis",
    "Hypertension" => "hypertension",
    "Diabetes" => "diabetes",
    "Ischemic Heart Disease" => "ischemic_heart",
    "Bronchial Asthma / COPD" => "copd",
    "Stroke" => "stroke",
    "Depression" => "depression",
    "Chronic Hepatitis B" => "hepatitis_b",
    "Chronic Hepatitis C" => "hepatitis_c",
    "NAFLD" => "nafld",
    "Chronic Kidney Disease" => "kidney_disease",
    "HIV/AIDS" => "hiv",
    "Hypothyroidism" => "hypothyroidism"
];

foreach ($conditions as $label => $name) {
?>

<div class="form-group">

<label><?php echo $label; ?> <span class="required">*</span></label>

<select
    name="<?php echo $name; ?>"
    class="form-control"
    required>

    <option value="">Select</option>
    <option>Yes</option>
    <option>No</option>
    <option>Unknown</option>

</select>

</div>

<?php } ?>

<div class="form-group">
<label>Other Co-morbidity</label>
<input
    type="text"
    name="other_comorbidity"
    class="form-control"
    maxlength="255">
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
<label>Height (cm) <span class="required">*</span></label>
<input
    type="number"
    step="0.1"
    name="height"
    class="form-control"
    min="30"
    max="250"
    required>
</div>

<div class="form-group">
<label>Weight (kg) <span class="required">*</span></label>
<input
    type="number"
    step="0.1"
    name="weight"
    class="form-control"
    min="1"
    max="500"
    required>
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
<label>Family History of Cancer <span class="required">*</span></label>
<select
    name="family_cancer_history"
    class="form-control"
    required>

    <option value="">Select</option>
    <option>Yes</option>
    <option>No</option>
    <option>Unknown</option>

</select>
</div>

<div class="form-group">
<label>Type of Family Cancer</label>
<select name="family_cancer_type" class="form-control">
    <option value="">Select</option>
    <option>Same Cancer</option>
    <option>Other Cancer</option>
</select>
</div>

<div class="form-group">
<label>Relationship</label>
<select name="family_relation" class="form-control">
    <option value="">Select</option>
    <option>First Degree Relative</option>
    <option>Second Degree Relative</option>
    <option>Other</option>
</select>
</div>

<div class="form-group full">
<label>Primary Site of Tumour for Relative</label>
<input
    type="text"
    name="family_cancer_site"
    class="form-control"
    maxlength="150">
</div>

<div class="form-group">
<label>Age at Diagnosis (Years)</label>
<input
    type="number"
    name="family_cancer_age"
    class="form-control"
    min="0"
    max="120">
</div>

<div class="form-group">
<label>Date of Diagnosis</label>
<input
    type="date"
    name="family_cancer_date"
    class="form-control">
</div>

</div>
</div>


<!-- =====================================================
     SAVE
===================================================== -->

<div style="margin:30px 0;">

<button
    type="submit"
    class="btn btn-primary btn-lg">

    <i class="fa fa-save"></i> Save Patient

</button>

</div>

</form>

</div>


<script>

/* =====================================================
   TODAY'S DATE
===================================================== */

function getTodayLocal() {

    const today = new Date();

    const year = today.getFullYear();

    const month =
        String(today.getMonth() + 1).padStart(2, "0");

    const day =
        String(today.getDate()).padStart(2, "0");

    return year + "-" + month + "-" + day;
}

const todayString = getTodayLocal();


/* =====================================================
   DATE LIMITS
===================================================== */

const reportDate =
    document.getElementById("report_date");

const diagnosisDate =
    document.getElementById("first_diagnosis_date");

const dob =
    document.getElementById("dob");


/*
 * Reporting date cannot be future.
 */

reportDate.max = todayString;


/*
 * First diagnosis cannot be future.
 */

diagnosisDate.max = todayString;


/*
 * DOB cannot be future.
 */

dob.max = todayString;


/* =====================================================
   AUTOMATIC AGE CALCULATION
===================================================== */

const age =
    document.getElementById("age");


function calculateAge() {

    if (dob.value === "") {

        age.value = "";

        return;
    }


    /*
     * Convert selected DOB into local date.
     */

    const birthDateParts =
        dob.value.split("-");

    const birthYear =
        parseInt(birthDateParts[0], 10);

    const birthMonth =
        parseInt(birthDateParts[1], 10) - 1;

    const birthDay =
        parseInt(birthDateParts[2], 10);


    const birthDate =
        new Date(
            birthYear,
            birthMonth,
            birthDay
        );


    const today =
        new Date();

    today.setHours(0, 0, 0, 0);


    /*
     * Prevent future DOB.
     */

    if (birthDate > today) {

        age.value = "";

        return;
    }


    let calculatedAge =
        today.getFullYear() -
        birthDate.getFullYear();


    const monthDifference =
        today.getMonth() -
        birthDate.getMonth();


    if (
        monthDifference < 0 ||
        (
            monthDifference === 0 &&
            today.getDate() < birthDate.getDate()
        )
    ) {

        calculatedAge--;

    }


    age.value = calculatedAge;

}


/*
 * Calculate age whenever DOB changes.
 */

dob.addEventListener(
    "change",
    calculateAge
);

dob.addEventListener(
    "input",
    calculateAge
);


/* =====================================================
   PATIENT FORM VALIDATION
===================================================== */

document.getElementById(
    "patientForm"
).addEventListener(
"submit",
function(event) {

    const form = this;


    /* -----------------------------------------------
       REQUIRED FIELDS
    ----------------------------------------------- */

    const requiredFields =
        form.querySelectorAll("[required]");


    for (let field of requiredFields) {

        if (field.value.trim() === "") {

            event.preventDefault();

            showValidationError(
                field,
                getFieldName(field) +
                " is mandatory."
            );

            return;
        }
    }


    /* -----------------------------------------------
       AADHAAR - EXACTLY 12 DIGITS
    ----------------------------------------------- */

    const aadhaar =
        document.getElementById("aadhaar");


    if (
        !/^[0-9]{12}$/.test(
            aadhaar.value.trim()
        )
    ) {

        event.preventDefault();

        showValidationError(
            aadhaar,
            "Aadhaar number must contain exactly 12 digits."
        );

        return;
    }


    /* -----------------------------------------------
       MOBILE NUMBER 1
       EXACTLY 10 DIGITS
       NO INDIAN PREFIX RESTRICTION
    ----------------------------------------------- */

    const mobile =
        document.querySelector(
            'input[name="mobile"]'
        );


    if (
        !/^[0-9]{10}$/.test(
            mobile.value.trim()
        )
    ) {

        event.preventDefault();

        showValidationError(
            mobile,
            "Mobile No. 1 must contain exactly 10 digits."
        );

        return;
    }


    /* -----------------------------------------------
       NEXT OF KIN MOBILE
       EXACTLY 10 DIGITS
    ----------------------------------------------- */

    const kinMobile =
        document.querySelector(
            'input[name="next_kin_mobile"]'
        );


    if (
        !/^[0-9]{10}$/.test(
            kinMobile.value.trim()
        )
    ) {

        event.preventDefault();

        showValidationError(
            kinMobile,
            "Next of Kin mobile number must contain exactly 10 digits."
        );

        return;
    }


    /* -----------------------------------------------
       MOBILE 2 - ONLY IF ENTERED
    ----------------------------------------------- */

    const mobile2 =
        document.querySelector(
            'input[name="mobile2"]'
        );


    if (
        mobile2.value.trim() !== "" &&
        !/^[0-9]{10}$/.test(
            mobile2.value.trim()
        )
    ) {

        event.preventDefault();

        showValidationError(
            mobile2,
            "Mobile No. 2 must contain exactly 10 digits."
        );

        return;
    }


    /* -----------------------------------------------
       EMAIL VALIDATION
    ----------------------------------------------- */

    const email =
        document.getElementById("email");


    if (email.value.trim() !== "") {

        const emailPattern =
            /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;


        if (
            !emailPattern.test(
                email.value.trim()
            )
        ) {

            event.preventDefault();

            showValidationError(
                email,
                "Please enter a valid email address."
            );

            return;
        }
    }


    /* -----------------------------------------------
       PIN CODES
    ----------------------------------------------- */

    const pinFields = [

        document.querySelector(
            'input[name="pin"]'
        ),

        document.querySelector(
            'input[name="permanent_pin"]'
        )

    ];


    for (let pin of pinFields) {

        if (
            !/^[0-9]{6}$/.test(
                pin.value.trim()
            )
        ) {

            event.preventDefault();

            showValidationError(
                pin,
                "PIN Code must contain exactly 6 digits."
            );

            return;
        }
    }


    /* -----------------------------------------------
       REFERRAL PIN - IF ENTERED
    ----------------------------------------------- */

    const referralPin =
        document.querySelector(
            'input[name="referral_pin"]'
        );


    if (
        referralPin.value.trim() !== "" &&
        !/^[0-9]{6}$/.test(
            referralPin.value.trim()
        )
    ) {

        event.preventDefault();

        showValidationError(
            referralPin,
            "Referral PIN Code must contain exactly 6 digits."
        );

        return;
    }


    /* -----------------------------------------------
       AGE
       AUTOMATICALLY CALCULATED
    ----------------------------------------------- */

    calculateAge();


    if (
        age.value === "" ||
        parseInt(age.value, 10) < 0 ||
        parseInt(age.value, 10) > 120
    ) {

        event.preventDefault();

        showValidationError(
            dob,
            "Please enter a valid Date of Birth."
        );

        return;
    }


    /* -----------------------------------------------
       HEIGHT
    ----------------------------------------------- */

    const height =
        document.querySelector(
            'input[name="height"]'
        );


    if (
        height.value !== "" &&
        (
            parseFloat(height.value) < 30 ||
            parseFloat(height.value) > 250
        )
    ) {

        event.preventDefault();

        showValidationError(
            height,
            "Please enter a valid height between 30 and 250 cm."
        );

        return;
    }


    /* -----------------------------------------------
       WEIGHT
    ----------------------------------------------- */

    const weight =
        document.querySelector(
            'input[name="weight"]'
        );


    if (
        weight.value !== "" &&
        (
            parseFloat(weight.value) < 1 ||
            parseFloat(weight.value) > 500
        )
    ) {

        event.preventDefault();

        showValidationError(
            weight,
            "Please enter a valid weight between 1 and 500 kg."
        );

        return;
    }


    /* -----------------------------------------------
       DOB CANNOT BE FUTURE
    ----------------------------------------------- */

    if (dob.value !== "") {

        const dobDate =
            new Date(
                dob.value + "T00:00:00"
            );


        const today =
            new Date(
                todayString + "T00:00:00"
            );


        if (dobDate > today) {

            event.preventDefault();

            showValidationError(
                dob,
                "Date of Birth cannot be in the future."
            );

            return;
        }
    }


    /* -----------------------------------------------
       DIAGNOSIS DATE CANNOT BE FUTURE
    ----------------------------------------------- */

    if (diagnosisDate.value !== "") {

        const selectedDate =
            new Date(
                diagnosisDate.value +
                "T00:00:00"
            );


        const today =
            new Date(
                todayString +
                "T00:00:00"
            );


        if (selectedDate > today) {

            event.preventDefault();

            showValidationError(
                diagnosisDate,
                "Date of First Diagnosis cannot be in the future."
            );

            return;
        }
    }


    /* -----------------------------------------------
       REPORT DATE CANNOT BE FUTURE
    ----------------------------------------------- */

    if (reportDate.value !== "") {

        const selectedDate =
            new Date(
                reportDate.value +
                "T00:00:00"
            );


        const today =
            new Date(
                todayString +
                "T00:00:00"
            );


        if (selectedDate > today) {

            event.preventDefault();

            showValidationError(
                reportDate,
                "Date of Reporting at RI cannot be in the future."
            );

            return;
        }
    }

});


/* =====================================================
   FIELD NAME
===================================================== */

function getFieldName(field) {

    const formGroup =
        field.closest(".form-group");


    if (formGroup) {

        const label =
            formGroup.querySelector("label");


        if (label) {

            return label.textContent
                .replace("*", "")
                .trim();

        }
    }


    return "This field";
}


/* =====================================================
   VALIDATION ERROR
===================================================== */

function showValidationError(
    field,
    message
) {

    alert(message);

    field.focus();

    field.style.border =
        "2px solid #dc3545";


    setTimeout(function() {

        field.style.border = "";

    }, 3000);

}


/* =====================================================
   ONLY NUMBERS
===================================================== */

document.querySelectorAll(

    'input[name="aadhaar"],' +
    'input[name="mobile"],' +
    'input[name="mobile2"],' +
    'input[name="next_kin_mobile"],' +
    'input[name="pin"],' +
    'input[name="permanent_pin"],' +
    'input[name="referral_pin"]'

).forEach(function(field) {

    field.addEventListener(
        "input",
        function() {

            this.value =
                this.value.replace(
                    /[^0-9]/g,
                    ""
                );

        }
    );

});


/* =====================================================
   LIMIT NUMBER FIELDS
===================================================== */

document.querySelectorAll(
    'input[type="number"]'
).forEach(function(field) {

    field.addEventListener(
        "input",
        function() {

            if (this.value < 0) {

                this.value = "";

            }

        }
    );

});


/* =====================================================
   INITIAL AGE CALCULATION
===================================================== */

calculateAge();

</script>


<style>

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


/* =====================================================
   REQUIRED STAR
===================================================== */

.required {
    color: #dc3545;
    font-weight: bold;
    font-size: 16px;
}
/* =====================================================
   REQUIRED STAR
===================================================== */

.required {
    color: #dc3545;
    font-weight: bold;
    font-size: 16px;
}


/* =====================================================
   FORM HELP
===================================================== */

.form-help {
    color: #7d8b89;
    font-size: 12px;
    margin: -5px 0 20px;
}

.field-help {
    color: #777;
    font-size: 11px;
}


/* =====================================================
   CARD HEADINGS
===================================================== */

.card h3 {
    color: #164e4a;
}


/* =====================================================
   REQUIRED FIELD VISUAL
===================================================== */

.form-control:required {
    background-color: #fff;
}


/* =====================================================
   FOCUS
===================================================== */

.form-control:focus {
    border-color: #164e4a;
    box-shadow: 0 0 0 0.15rem rgba(22,78,74,0.15);
}


/* =====================================================
   INVALID
===================================================== */

.form-control:invalid:not(:placeholder-shown) {
    border-color: #dc3545;
}


/* =====================================================
   NUMBER INPUT
===================================================== */

input[type="number"] {
    appearance: textfield;
}


/* =====================================================
   PHONE +91 PREFIX
===================================================== */

.phone-input {
    display: flex;
    align-items: stretch;
    width: 100%;
}

.phone-prefix {
    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0 12px;

    background: #f1f3f5;

    border: 1px solid #ced4da;

    border-right: none;

    border-radius: 6px 0 0 6px;

    font-weight: 600;

    color: #495057;

    white-space: nowrap;
}

.phone-input .form-control {
    border-radius: 0 6px 6px 0;
}

.phone-input .form-control:focus {
    position: relative;
    z-index: 2;
}

</style>


<?php
include("../includes/footer.php");
?>
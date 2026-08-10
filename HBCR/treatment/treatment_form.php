<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");


/* =====================================================
   GET PATIENTS
===================================================== */

$patients = mysqli_query(
    $conn,
    "SELECT
        id,
        aadhaar,
        abha_id,
        hbcr_no,
        first_name,
        last_name,
        hospital_no,
        age,
        gender,
        mobile
     FROM patients
     ORDER BY first_name, last_name"
);

?>

<div class="main-content">

<div class="page-header">

    <h2>
        <i class="fa fa-capsules"></i>
        Treatment Entry
    </h2>

    <p>
        Hospital Based Cancer Registry System
    </p>

</div>


<form action="save_treatment.php" method="POST" id="treatmentForm" novalidate>


<!-- =====================================================
     PATIENT INFORMATION
===================================================== -->

<div class="card">

<h3>Patient Information</h3>

<div class="row">

<div class="form-group full">

<label class="required">
Search / Select Patient by Aadhaar No.
</label>


<!-- =====================================================
     ONE SEARCH FIELD
===================================================== -->

<input
    type="text"
    id="patient_search"
    class="form-control"
    list="patientList"
    placeholder="Type Aadhaar No. or select patient"
    autocomplete="off"
    inputmode="numeric"
    maxlength="12"
    required
>


<!-- =====================================================
     DROPDOWN SUGGESTIONS
===================================================== -->

<datalist id="patientList">

<?php

while ($p = mysqli_fetch_assoc($patients)) {

    $full_name = trim(
        ($p['first_name'] ?? '') .
        " " .
        ($p['last_name'] ?? '')
    );

?>

<option
    value="<?php echo htmlspecialchars($p['aadhaar'] ?? ''); ?>"
    data-id="<?php echo htmlspecialchars($p['id']); ?>"
    data-aadhaar="<?php echo htmlspecialchars($p['aadhaar'] ?? ''); ?>"
    data-abha="<?php echo htmlspecialchars($p['abha_id'] ?? ''); ?>"
    data-hbcr="<?php echo htmlspecialchars($p['hbcr_no'] ?? ''); ?>"
    data-hospital="<?php echo htmlspecialchars($p['hospital_no'] ?? ''); ?>"
    data-name="<?php echo htmlspecialchars($full_name); ?>"
    data-age="<?php echo htmlspecialchars($p['age'] ?? ''); ?>"
    data-gender="<?php echo htmlspecialchars($p['gender'] ?? ''); ?>"
    data-mobile="<?php echo htmlspecialchars($p['mobile'] ?? ''); ?>"
>
<?php

echo htmlspecialchars(
    ($p['aadhaar'] ?? '') .
    " - " .
    $full_name
);

?>

</option>

<?php
}
?>

</datalist>


<!-- =====================================================
     HIDDEN PATIENT ID
===================================================== -->

<input
    type="hidden"
    name="patient_id"
    id="patient_id"
>


<div
    id="patientError"
    style="
        display:none;
        color:#dc3545;
        font-size:13px;
        margin-top:8px;
    "
>
    Please select a valid registered patient.
</div>

</div>

</div>

</div>


<!-- =====================================================
     FETCHED PATIENT DETAILS
===================================================== -->

<div
    class="card"
    id="patientDetailsCard"
    style="display:none;"
>

<h3>Patient Details</h3>

<div class="row">


<div class="form-group">

<label>Aadhaar No.</label>

<input
    type="text"
    id="aadhaar_display"
    class="form-control"
    readonly
>

</div>


<div class="form-group">

<label>ABHA ID</label>

<input
    type="text"
    id="abha_display"
    class="form-control"
    readonly
>

</div>


<div class="form-group">

<label>HBCR No.</label>

<input
    type="text"
    id="hbcr"
    class="form-control"
    readonly
>

</div>


<div class="form-group">

<label>Hospital Registration No.</label>

<input
    type="text"
    id="hospital"
    class="form-control"
    readonly
>

</div>


<div class="form-group">

<label>Patient Name</label>

<input
    type="text"
    id="patient_name"
    class="form-control"
    readonly
>

</div>


<div class="form-group">

<label>Age</label>

<input
    type="text"
    id="age"
    class="form-control"
    readonly
>

</div>


<div class="form-group">

<label>Gender</label>

<input
    type="text"
    id="gender"
    class="form-control"
    readonly
>

</div>


<div class="form-group">

<label>Mobile</label>

<input
    type="text"
    id="mobile"
    class="form-control"
    readonly
>

</div>

</div>

</div>


<!-- ================================
     TREATMENT CONTEXT
================================ -->

<div class="card">

<h3>Treatment Context</h3>

<div class="row">


<div class="form-group">

<label class="required">Treatment Context</label>

<select
    name="treatment_context"
    class="form-control"
    required>

<option value="">Select</option>

<option>First Course</option>
<option>Subsequent Course</option>
<option>Recurrence</option>
<option>Progression</option>
<option>Palliative</option>
<option>Other</option>

</select>

</div>


<div class="form-group">

<label class="required">
Treatment Given Before Registration
</label>

<select
    name="treatment_given_before_registration"
    class="form-control"
    required>

<option value="">Select</option>

<option>Yes</option>
<option>No</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group">

<label class="required">
Treatment Type Given
</label>

<select
    name="treatment_type_given"
    class="form-control"
    required>

<option value="">Select</option>

<option>Surgery</option>
<option>Chemotherapy</option>
<option>Radiotherapy</option>
<option>Immunotherapy</option>
<option>Hormone Therapy</option>
<option>Targeted Therapy</option>
<option>Other</option>

</select>

</div>


<div class="form-group">

<label class="required">
Treatment Modality
</label>

<select
    name="treatment_modality"
    class="form-control"
    required>

<option value="">Select</option>

<option>Surgery</option>
<option>Chemotherapy</option>
<option>Radiotherapy</option>
<option>Chemotherapy + Radiotherapy</option>
<option>Surgery + Chemotherapy</option>
<option>Surgery + Radiotherapy</option>
<option>Multimodality</option>
<option>Immunotherapy</option>
<option>Hormone Therapy</option>
<option>Targeted Therapy</option>
<option>Other</option>

</select>

</div>


<div class="form-group">

<label class="required">
Intention to Treat
</label>

<select
    name="intention_to_treat"
    class="form-control"
    required>

<option value="">Select</option>

<option>Curative</option>
<option>Palliative</option>
<option>Supportive</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group">

<label class="required">
Treatment Role
</label>

<select
    name="treatment_role"
    class="form-control"
    required>

<option value="">Select</option>

<option>Primary</option>
<option>Adjuvant</option>
<option>Neoadjuvant</option>
<option>Concurrent</option>
<option>Palliative</option>
<option>Supportive</option>
<option>Other</option>

</select>

</div>


<div class="form-group full">

<label>CDT Details</label>

<input
    type="text"
    name="cdt_details"
    class="form-control"
    placeholder="Enter CDT details">

</div>

</div>

</div>


<!-- ================================
     TREATMENT DETAILS
================================ -->

<div class="card">

<h3>Treatment Details</h3>

<div class="row">


<div class="form-group">

<label class="required">
Treatment Type
</label>

<select
    name="treatment_type"
    class="form-control"
    required>

<option value="">Select</option>

<option>Surgery</option>
<option>Chemotherapy</option>
<option>Radiotherapy</option>
<option>Immunotherapy</option>
<option>Hormone Therapy</option>
<option>Targeted Therapy</option>
<option>Other</option>

</select>

</div>


<div class="form-group">

<label class="required">
Treatment Date
</label>

<input
    type="date"
    name="treatment_date"
    class="form-control"
    required>

</div>


<div class="form-group">

<label class="required">
Start Date
</label>

<input
    type="date"
    name="start_date"
    class="form-control"
    required>

</div>


<div class="form-group">

<label>
End Date
</label>

<input
    type="date"
    name="end_date"
    class="form-control">

</div>


<div class="form-group">

<label>
Targeted Therapy Type
</label>

<select
    name="targeted_therapy_type"
    class="form-control">

<option value="">Select</option>

<option>None</option>
<option>Monoclonal Antibody</option>
<option>Tyrosine Kinase Inhibitor</option>
<option>Other Targeted Therapy</option>

</select>

</div>


<div class="form-group">

<label class="required">
Performance Status (ECOG)
</label>

<select
    name="performance_status_ecog"
    class="form-control"
    required>

<option value="">Select</option>

<option>0 - Fully Active</option>
<option>1 - Restricted Activity</option>
<option>2 - Ambulatory</option>
<option>3 - Limited Self Care</option>
<option>4 - Completely Disabled</option>
<option>5 - Dead</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group">

<label class="required">
Doctor
</label>

<input
    type="text"
    name="doctor"
    class="form-control"
    required>

</div>


<div class="form-group">

<label class="required">
Status
</label>

<select
    name="status"
    class="form-control"
    required>

<option value="">Select</option>

<option>Ongoing</option>
<option>Completed</option>
<option>Stopped</option>
<option>Not Started</option>
<option>Unknown</option>

</select>

</div>


<div class="form-group">

<label>
Date of Death
</label>

<input
    type="date"
    name="date_of_death"
    class="form-control">

</div>

</div>

</div>


<!-- ================================
     FORM COMPLETION
================================ -->

<div class="card">

<h3>Form Completion</h3>

<div class="row">


<div class="form-group">

<label class="required">
Person Completing Form
</label>

<input
    type="text"
    name="person_completing_form"
    class="form-control"
    required>

</div>


<div class="form-group">

<label class="required">
Completion Date
</label>

<input
    type="date"
    name="completion_date"
    class="form-control"
    value="<?php echo date('Y-m-d'); ?>"
    required>

</div>


<div class="form-group">

<label class="required">
Signature
</label>

<input
    type="text"
    name="signature"
    class="form-control"
    placeholder="Name / Signature"
    required>

</div>


<div class="form-group full">

<label>
Remarks
</label>

<textarea
    name="remarks"
    class="form-control"
    rows="4"
    placeholder="Enter additional remarks if required"></textarea>

</div>

</div>

</div>


<!-- ================================
     BUTTONS
================================ -->

<div style="margin:30px 0;">

<button
    type="submit"
    class="btn btn-primary btn-lg">

<i class="fa fa-save"></i>

Save Treatment

</button>


<a
    href="treatment.php"
    class="btn btn-secondary btn-lg">

<i class="fa fa-arrow-left"></i>

Back

</a>

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

const patientError =
    document.getElementById("patientError");

const patientDetailsCard =
    document.getElementById("patientDetailsCard");


patientSearch.addEventListener(
    "input",
    function () {

        let enteredValue =
            this.value.trim();

        /*
        Keep Aadhaar as numbers only
        */

        enteredValue =
            enteredValue.replace(/[^0-9]/g, "");

        this.value =
            enteredValue;


        let matchedPatient = null;

        const options =
            patientList.querySelectorAll("option");


        /*
        FIND PATIENT BY AADHAAR
        */

        for (let option of options) {

            if (
                option.value.trim() ===
                enteredValue
            ) {

                matchedPatient = option;

                break;

            }

        }


        /*
        PATIENT FOUND
        */

        if (matchedPatient) {


            /* PATIENT DATABASE ID */

            patientId.value =
                matchedPatient.dataset.id || "";


            /* AADHAAR */

            document.getElementById(
                "aadhaar_display"
            ).value =
                matchedPatient.dataset.aadhaar || "";


            /* ABHA */

            document.getElementById(
                "abha_display"
            ).value =
                matchedPatient.dataset.abha || "";


            /* HBCR */

            document.getElementById(
                "hbcr"
            ).value =
                matchedPatient.dataset.hbcr || "";


            /* HOSPITAL REGISTRATION */

            document.getElementById(
                "hospital"
            ).value =
                matchedPatient.dataset.hospital || "";


            /* NAME */

            document.getElementById(
                "patient_name"
            ).value =
                matchedPatient.dataset.name || "";


            /* AGE */

            document.getElementById(
                "age"
            ).value =
                matchedPatient.dataset.age || "";


            /* GENDER */

            document.getElementById(
                "gender"
            ).value =
                matchedPatient.dataset.gender || "";


            /* MOBILE */

            document.getElementById(
                "mobile"
            ).value =
                matchedPatient.dataset.mobile || "";


            /* SHOW DETAILS */

            patientDetailsCard.style.display =
                "block";


            /* REMOVE ERROR */

            patientError.style.display =
                "none";

        }

        else {


            /*
            If Aadhaar is not complete,
            don't show error yet.
            */

            patientId.value = "";

            patientDetailsCard.style.display =
                "none";


            if (
                enteredValue.length > 0
            ) {

                patientError.style.display =
                    "block";

            }

            else {

                patientError.style.display =
                    "none";

            }

        }

    }
);


/* =====================================================
   FORM SUBMIT VALIDATION
===================================================== */

document.getElementById(
    "treatmentForm"
).addEventListener(
    "submit",
    function(event) {


        /*
        PATIENT MUST BE SELECTED
        */

        if (
            patientId.value.trim() === ""
        ) {

            event.preventDefault();


            alert(
                "Please search and select a valid patient using Aadhaar number."
            );


            patientSearch.focus();


            return false;

        }


        /*
        CHECK ALL REQUIRED FIELDS
        */

        const requiredFields =
            this.querySelectorAll(
                "[required]"
            );


        for (
            let field of requiredFields
        ) {


            /*
            Patient search already
            checked separately.
            */

            if (
                field.id ===
                "patient_search"
            ) {

                continue;

            }


            let value =
                field.value.trim();


            if (
                value === ""
            ) {

                event.preventDefault();


                const formGroup =
                    field.closest(
                        ".form-group"
                    );


                let fieldName =
                    "This field";


                if (formGroup) {

                    const label =
                        formGroup.querySelector(
                            "label"
                        );


                    if (label) {

                        fieldName =
                            label.textContent
                            .replace("*", "")
                            .trim();

                    }

                }


                alert(
                    fieldName +
                    " is mandatory."
                );


                field.focus();


                return false;

            }

        }

    }
);


/* =====================================================
   DATE VALIDATION
   END DATE SHOULD NOT BE BEFORE START DATE
===================================================== */

const startDate =
    document.querySelector(
        '[name="start_date"]'
    );

const endDate =
    document.querySelector(
        '[name="end_date"]'
    );


if (
    startDate &&
    endDate
) {

    endDate.addEventListener(
        "change",
        function() {


            if (
                startDate.value &&
                endDate.value &&
                endDate.value <
                startDate.value
            ) {

                alert(
                    "End Date cannot be earlier than Start Date."
                );


                endDate.value = "";


                endDate.focus();

            }

        }
    );

}


/* =====================================================
   TREATMENT DATE VALIDATION
===================================================== */

const treatmentDate =
    document.querySelector(
        '[name="treatment_date"]'
    );


if (
    treatmentDate
) {

    treatmentDate.addEventListener(
        "change",
        function() {


            if (
                startDate &&
                startDate.value &&
                treatmentDate.value >
                startDate.value
            ) {

                alert(
                    "Treatment Date should not be later than Start Date."
                );


                treatmentDate.value = "";

            }

        }
    );

}

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
   HBCR PROFESSIONAL FORM LAYOUT
   DO NOT CHANGE FORM FIELDS
===================================================== */

/* Main form area */
.main-content {
    padding: 28px 35px 45px;
}

/* Page heading */
.page-header {
    margin-bottom: 28px;
    padding: 24px 28px;
    background: linear-gradient(135deg, #164e4a, #1f6b65);
    border-radius: 12px;
    color: #ffffff;
    box-shadow: 0 5px 18px rgba(0,0,0,0.08);
}

.page-header h2 {
    margin: 0;
    font-size: 25px;
    font-weight: 700;
    letter-spacing: 0.2px;
    color: #ffffff;
}

.page-header h2 i {
    margin-right: 10px;
}

.page-header p {
    margin: 7px 0 0;
    font-size: 13px;
    color: rgba(255,255,255,0.85);
}


/* =====================================================
   FORM SECTIONS / CARDS
===================================================== */

.card {
    background: #ffffff;
    border: 1px solid #e5e9e8;
    border-radius: 12px;
    padding: 25px 28px 28px;
    margin-bottom: 24px;
    box-shadow: 0 3px 14px rgba(22,78,74,0.06);
}


/* Section heading */
.card h3 {
    margin: 0 0 24px;
    padding-bottom: 13px;

    font-size: 17px;
    font-weight: 700;

    color: #164e4a;

    border-bottom: 2px solid #edf2f1;

    position: relative;
}


/* Small accent under heading */
.card h3::after {
    content: "";
    position: absolute;

    left: 0;
    bottom: -2px;

    width: 55px;
    height: 2px;

    background: #164e4a;
    border-radius: 5px;
}


/* =====================================================
   PROPER FIELD GRID
===================================================== */

.card .row {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    column-gap: 28px;
    row-gap: 21px;

    margin: 0;
}


/* Each field */
.card .form-group {
    width: 100%;
    min-width: 0;

    margin: 0;
}


/* Full width field */
.card .form-group.full {
    grid-column: 1 / -1;
}


/* =====================================================
   LABELS
===================================================== */

.card .form-group label {
    display: block;

    margin-bottom: 7px;

    color: #344746;

    font-size: 13px;
    font-weight: 600;

    line-height: 1.4;
}


/* =====================================================
   INPUTS / SELECTS
===================================================== */

.card .form-control {
    width: 100%;
    height: 43px;

    padding: 9px 12px;

    border: 1px solid #cfd8d6;
    border-radius: 7px;

    background: #ffffff;

    color: #263635;

    font-size: 13px;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;

    box-sizing: border-box;
}


/* Textarea if any form has one */
.card textarea.form-control {
    height: auto;
    min-height: 100px;
    resize: vertical;
}


/* Select */
.card select.form-control {
    cursor: pointer;
}


/* Hover */
.card .form-control:hover {
    border-color: #aebdb9;
}


/* Focus */
.card .form-control:focus {
    outline: none;

    border-color: #164e4a;

    box-shadow:
        0 0 0 3px rgba(22,78,74,0.10);

    background: #ffffff;
}


/* Placeholder */
.card .form-control::placeholder {
    color: #9aa6a4;
    font-size: 12px;
}


/* =====================================================
   REQUIRED STAR
===================================================== */

.required {
    color: #dc3545;
    font-weight: 700;
}


/* =====================================================
   HELP TEXT
===================================================== */

.field-help,
.form-help {
    display: block;

    margin-top: 6px;

    color: #7c8987;

    font-size: 11px;
    line-height: 1.5;
}


/* =====================================================
   PHONE INPUT
===================================================== */

.phone-input {
    display: flex;
    width: 100%;
}

.phone-prefix {
    min-width: 52px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #f3f6f5;

    border: 1px solid #cfd8d6;
    border-right: none;

    border-radius: 7px 0 0 7px;

    color: #495856;

    font-size: 13px;
    font-weight: 600;
}

.phone-input .form-control {
    border-radius: 0 7px 7px 0;
}


/* =====================================================
   SAVE / ACTION AREA
===================================================== */

form > div:last-child {
    display: flex;
    justify-content: flex-end;
    align-items: center;

    padding-top: 5px;
}


form .btn {
    min-width: 155px;

    padding: 11px 22px;

    border-radius: 7px;

    font-size: 13px;
    font-weight: 600;

    box-shadow: 0 3px 8px rgba(0,0,0,0.08);

    transition: all 0.2s ease;
}


form .btn-primary {
    background: #164e4a;
    border-color: #164e4a;
}


form .btn-primary:hover {
    background: #103d39;
    border-color: #103d39;

    transform: translateY(-1px);

    box-shadow: 0 5px 12px rgba(22,78,74,0.18);
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    .main-content {
        padding: 22px 20px 35px;
    }

    .card {
        padding: 21px;
    }

    .card .row {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .card .form-group.full {
        grid-column: auto;
    }

}


@media (max-width: 600px) {

    .main-content {
        padding: 16px 12px 30px;
    }

    .page-header {
        padding: 20px;
    }

    .page-header h2 {
        font-size: 21px;
    }

    .card {
        padding: 18px;
        margin-bottom: 18px;
    }

    .card h3 {
        font-size: 15px;
    }

    form > div:last-child {
        justify-content: stretch;
    }

    form .btn {
        width: 100%;
    }

}
/* =====================================================
   REQUIRED FIELD STAR
===================================================== */

label.required::after {

    content: " *";

    color: #dc3545;

    font-weight: 700;

}


/* =====================================================
   PATIENT SEARCH
===================================================== */

#patient_search {

    width: 100%;

}


/* =====================================================
   READONLY PATIENT DETAILS
===================================================== */

#patientDetailsCard input[readonly] {

    background-color: #f7f9f9;

    cursor: default;

}

</style>


<?php

include("../includes/footer.php");

?>
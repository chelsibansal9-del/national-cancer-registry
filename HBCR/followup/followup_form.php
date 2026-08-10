<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");


/* =====================================================
   FIND AADHAAR COLUMN SAFELY
===================================================== */

$aadhaar_column = "";

$columns_result = mysqli_query($conn, "SHOW COLUMNS FROM patients");

if ($columns_result) {

    while ($column = mysqli_fetch_assoc($columns_result)) {

        $column_name = strtolower($column['Field']);

        if (
            $column_name === "aadhaar_no" ||
            $column_name === "aadhar_no" ||
            $column_name === "aadhaar_number" ||
            $column_name === "aadhar_number" ||
            $column_name === "aadhaar"
        ) {

            $aadhaar_column = $column['Field'];
            break;

        }

    }

}


/* =====================================================
   PATIENT LIST
===================================================== */

if ($aadhaar_column !== "") {

    $patients = mysqli_query(
        $conn,
        "SELECT
            id,
            hbcr_no,
            first_name,
            last_name,
            hospital_no,
            `$aadhaar_column` AS aadhaar_value
         FROM patients
         ORDER BY first_name, last_name"
    );

} else {

    $patients = mysqli_query(
        $conn,
        "SELECT
            id,
            hbcr_no,
            first_name,
            last_name,
            hospital_no
         FROM patients
         ORDER BY first_name, last_name"
    );

}

?>

<div class="main-content">

<div class="page-header">

<h2>
<i class="fa fa-calendar-check"></i>
Follow-up Form
</h2>

<p>Hospital Based Cancer Registry System</p>

</div>


<form action="save_followup.php" method="POST" id="followupForm" novalidate>


<!-- =====================================================
     PATIENT
===================================================== -->

<div class="card">

<h3>Patient Information</h3>

<div class="row">


<div class="form-group full">

<label class="required">
Aadhaar Number / Patient
</label>


<input
type="text"
id="patient_search"
class="form-control"
list="patient_list"
placeholder="Type Aadhaar number or patient name"
autocomplete="off"
required>


<datalist id="patient_list">

<?php

if ($patients) {

    while ($p = mysqli_fetch_assoc($patients)) {

        $aadhaar =
            $p['aadhaar_value'] ??
            "";

        $patient_name =
            trim(
                ($p['first_name'] ?? '') .
                " " .
                ($p['last_name'] ?? '')
            );

        $display =
            $aadhaar .
            " - " .
            $patient_name;

?>

<option
value="<?php echo htmlspecialchars($display); ?>"
data-id="<?php echo htmlspecialchars($p['id']); ?>"
data-aadhaar="<?php echo htmlspecialchars($aadhaar); ?>"
data-hospital="<?php echo htmlspecialchars($p['hospital_no'] ?? ''); ?>"
data-name="<?php echo htmlspecialchars($patient_name); ?>"
>

<?php echo htmlspecialchars($display); ?>

</option>

<?php

    }

}

?>

</datalist>


<input
type="hidden"
name="patient_id"
id="patient_id"
required>


</div>



<div class="form-group">

<label>Aadhaar Number</label>

<input
type="text"
id="aadhaar_display"
class="form-control"
readonly>

</div>



<div class="form-group">

<label>Hospital Registration No.</label>

<input
type="text"
id="hospital_no"
class="form-control"
readonly>

</div>



<div class="form-group">

<label>Patient Name</label>

<input
type="text"
id="patient_name"
class="form-control"
readonly>

</div>



<div class="form-group">

<label>Visit No.</label>

<input
type="text"
name="visit_no"
class="form-control"
placeholder="Enter visit number">

</div>

</div>

</div>



<!-- =====================================================
     1 DATE
===================================================== -->

<div class="card">

<h3>1. Date of Follow-up</h3>

<div class="form-group">

<label class="required">
Follow-up Date
</label>

<input
type="date"
name="followup_date"
class="form-control"
value="<?php echo date('Y-m-d'); ?>"
required>

</div>

</div>



<!-- =====================================================
     2 METHOD OF FOLLOW-UP
===================================================== -->

<div class="card">

<h3>2. Method of Follow-up</h3>

<div class="row">

<div class="form-group">

<label class="required">
Method
</label>

<select
name="followup_method"
class="form-control"
required>

<option value="">
-- Select --
</option>

<option>Hospital Visit</option>
<option>Post/email</option>
<option>Telephone</option>
<option>House Visit</option>
<option>Public Database</option>
<option>Special survey/study</option>
<option>Others</option>

</select>

</div>

</div>

</div>



<!-- =====================================================
     3 VITAL STATUS
===================================================== -->

<div class="card">

<h3>3. Vital Status</h3>

<div class="form-group">

<label class="required">
Current Vital Status
</label>

<select
name="vital_status"
id="vital_status"
class="form-control"
required>

<option value="">
-- Select --
</option>

<option>Alive</option>
<option>Dead</option>
<option>Unknown</option>

</select>

</div>

</div>



<!-- =====================================================
     4 DISEASE STATUS
===================================================== -->

<div class="card">

<h3>4. Disease Status</h3>

<div class="form-group">

<label class="required">
Disease Status
</label>

<select
name="disease_status"
id="disease_status"
class="form-control"
required>

<option value="">
-- Select --
</option>

<option>
No Evidence of Disease
</option>

<option>
No Evidence of Disease but Second Primary Present
</option>

<option>
No Evidence of Disease but other illness or conditions present
</option>

<option>
Cancer in Regression / Residual Disease
</option>

<option>
Cancer in Progression / Recurrence (Primary Disease and / or Metastasis)
</option>

<option>
Too Advanced / Cachexia
</option>

<option>
No evidence of disease but on chemotherapy/hormonal therapy
</option>

<option>Others</option>

<option>Unknown</option>

</select>

</div>


<div
id="recurrenceBox"
style="display:none; margin-top:15px;">

<label>
If Cancer in Progression / Recurrence, Date of First Recurrence
</label>

<input
type="date"
name="first_recurrence_date"
id="first_recurrence_date"
class="form-control">

</div>

</div>



<!-- =====================================================
     5 TREATMENT
===================================================== -->

<div class="card">

<h3>5. Treatment</h3>

<div class="form-group">

<label class="required">
Treatment Given
</label>

<select
name="treatment_given"
id="treatment_given"
class="form-control"
required>

<option value="">
-- Select --
</option>

<option>Yes</option>
<option>No</option>

</select>

</div>


<div
id="treatmentSection"
style="display:none;">


<h4>5.1 Type of Treatment Given</h4>

<div class="form-group">

<label>
Type of Treatment Given
</label>

<select
name="treatment_type"
id="treatment_type"
class="form-control">

<option value="">
-- Select --
</option>

<option>Allopathic</option>
<option>Non Allopathic</option>
<option>Both</option>

</select>

</div>


<h4>Treatment Details</h4>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>Treatment</th>
<th>Given</th>
<th>Start Date</th>
<th>End Date</th>

</tr>

</thead>

<tbody>


<!-- SURGERY -->

<tr>

<td>
<strong>Surgery</strong>
</td>

<td>

<select
name="surgery"
id="surgery"
class="form-control treatment-given-field">

<option value="">Select</option>

<option>Yes</option>
<option>No</option>

</select>

</td>

<td>

<input
type="date"
name="surgery_start_date"
class="form-control">

</td>

<td>

<input
type="date"
name="surgery_end_date"
class="form-control">

</td>

</tr>



<!-- RADIOTHERAPY -->

<tr>

<td>
<strong>Radiotherapy</strong>
</td>

<td>

<select
name="radiotherapy"
id="radiotherapy"
class="form-control treatment-given-field">

<option value="">Select</option>

<option>Yes</option>
<option>No</option>

</select>

</td>

<td>

<input
type="date"
name="radiotherapy_start_date"
class="form-control">

</td>

<td>

<input
type="date"
name="radiotherapy_end_date"
class="form-control">

</td>

</tr>



<!-- CHEMOTHERAPY -->

<tr>

<td>
<strong>Chemotherapy</strong>
</td>

<td>

<select
name="chemotherapy"
id="chemotherapy"
class="form-control treatment-given-field">

<option value="">Select</option>

<option>Yes</option>
<option>No</option>

</select>

</td>

<td>

<input
type="date"
name="chemotherapy_start_date"
class="form-control">

</td>

<td>

<input
type="date"
name="chemotherapy_end_date"
class="form-control">

</td>

</tr>



<!-- HORMONE -->

<tr>

<td>
<strong>Hormone Therapy</strong>
</td>

<td>

<select
name="hormone_therapy"
id="hormone_therapy"
class="form-control treatment-given-field">

<option value="">Select</option>

<option>Yes</option>
<option>No</option>

</select>

</td>

<td>

<input
type="date"
name="hormone_therapy_start_date"
class="form-control">

</td>

<td>

<input
type="date"
name="hormone_therapy_end_date"
class="form-control">

</td>

</tr>



<!-- TARGETED -->

<tr>

<td>
<strong>Targeted Therapy</strong>
</td>

<td>

<select
name="targeted_therapy"
id="targeted_therapy"
class="form-control treatment-given-field">

<option value="">Select</option>

<option>Yes</option>
<option>No</option>

</select>

</td>

<td>

<input
type="date"
name="targeted_therapy_start_date"
class="form-control">

</td>

<td>

<input
type="date"
name="targeted_therapy_end_date"
class="form-control">

</td>

</tr>



<!-- OTHER -->

<tr>

<td>

<strong>Others</strong>

<input
type="text"
name="other_treatment"
class="form-control"
placeholder="Specify">

</td>

<td>

<select
name="other_treatment_given"
id="other_treatment_given"
class="form-control treatment-given-field">

<option value="">
Select
</option>

<option>Yes</option>
<option>No</option>

</select>

</td>

<td>

<input
type="date"
name="other_treatment_start_date"
class="form-control">

</td>

<td>

<input
type="date"
name="other_treatment_end_date"
class="form-control">

</td>

</tr>

</tbody>

</table>

</div>

</div>



<!-- =====================================================
     IF DEAD
     SEPARATE SECTION
     NOT CONNECTED TO VITAL STATUS
===================================================== -->

<div
class="card"
id="deathSection">

<h3>If Dead</h3>


<div class="form-group">

<label>
6. Date of Death
</label>

<input
type="date"
name="date_of_death"
id="date_of_death"
class="form-control">

</div>


<div class="form-group">

<label>
7. Place of Death
</label>

<select
name="place_of_death"
id="place_of_death"
class="form-control">

<option value="">
-- Select --
</option>

<option>At Reporting Institution (RI)</option>
<option>Other Hospital</option>
<option>Residence</option>
<option>Others</option>
<option>Not available/Unknown</option>

</select>

</div>


<div class="form-group">

<label>
8. Source of Information on Death
</label>

<select
name="death_information_source"
id="death_information_source"
class="form-control">

<option value="">
-- Select --
</option>

<option>Civil registration system</option>

<option>Burial/cremation record</option>

<option>Voter list</option>

<option>Aadhaar</option>

<option>Census</option>

<option>
Ayushman Bharat Digital Mission database
</option>

<option>Others</option>

<option>Not available/Unknown</option>

</select>

</div>

</div>



<!-- =====================================================
     CAUSE OF DEATH
     SEPARATE SECTION
     NOT CONNECTED TO VITAL STATUS
===================================================== -->

<div
class="card"
id="causeSection">

<h3>9. Cause of Death</h3>

<p>
If information is unavailable, enter
<strong>999</strong>.
</p>


<div class="form-group">

<label>
Immediate Cause
</label>

<input
type="text"
name="immediate_cause"
id="immediate_cause"
class="form-control"
placeholder="Enter 999 if unavailable">

</div>


<div class="form-group">

<label>
Antecedent Cause
</label>

<input
type="text"
name="antecedent_cause"
id="antecedent_cause"
class="form-control"
placeholder="Enter 999 if unavailable">

</div>


<div class="form-group">

<label>
Underlying Cause
</label>

<input
type="text"
name="underlying_cause"
id="underlying_cause"
class="form-control"
placeholder="Enter 999 if unavailable">

</div>


<div class="form-group">

<label>
Contributing / Significant Conditions or Diseases
</label>

<input
type="text"
name="contributing_conditions"
id="contributing_conditions"
class="form-control"
placeholder="Enter 999 if unavailable">

</div>

</div>



<!-- =====================================================
     FINAL INFORMATION
===================================================== -->

<div class="card">

<h3>Final Information</h3>


<div class="form-group">

<label>
10. ICD-10 of Underlying Cause of Death (UCOD)
</label>

<input
type="text"
name="ucod"
class="form-control"
placeholder="Enter ICD-10 code or 999 if unavailable"
>

</div>


<div class="form-group">

<label>
11. Major Cause Group of UCOD
</label>

<input
type="text"
name="major_cause_group"
class="form-control"
placeholder="Enter major cause group"
>

</div>


<div class="form-group">

<label class="required">
12. Name of Person Completing Form
</label>

<input
type="text"
name="person_completing"
class="form-control"
placeholder="Enter name"
required>

</div>


<div class="form-group">

<label class="required">
13. Date of Completion of this Form
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
Digital Signature
</label>

<div style="
    border:1px solid #ccc;
    border-radius:6px;
    background:#fff;
    max-width:700px;
">

<canvas
    id="signatureCanvas"
    width="700"
    height="220"
    style="
        width:100%;
        height:220px;
        display:block;
        cursor:crosshair;
        touch-action:none;
    "
></canvas>

</div>

<br>

<button
    type="button"
    class="btn btn-secondary"
    id="clearSignature">

<i class="fa fa-eraser"></i>
Clear Signature

</button>

<input
type="hidden"
name="digital_signature"
id="digital_signature">

</div>

</div>



<!-- =====================================================
     BUTTON
===================================================== -->

<div style="margin:30px 0;">

<button
type="submit"
class="btn btn-primary btn-lg">

<i class="fa fa-save"></i>
Save Follow-up

</button>


<a
href="followup.php"
class="btn btn-secondary btn-lg">

Back

</a>

</div>


</form>

</div>



<script>

/* =====================================================
   PATIENT SEARCH / AADHAAR SELECTION
===================================================== */

const patientSearch =
document.getElementById("patient_search");

const patientList =
document.getElementById("patient_list");

const patientId =
document.getElementById("patient_id");

const aadhaarDisplay =
document.getElementById("aadhaar_display");

const hospitalNo =
document.getElementById("hospital_no");

const patientName =
document.getElementById("patient_name");


patientSearch.addEventListener(
"input",
function(){

    const typedValue =
        this.value.trim().toLowerCase();


    const options =
        patientList.querySelectorAll("option");


    let found = false;


    options.forEach(
        function(option){

            const aadhaar =
                (
                    option.dataset.aadhaar ||
                    ""
                )
                .trim()
                .toLowerCase();


            const name =
                (
                    option.dataset.name ||
                    ""
                )
                .trim()
                .toLowerCase();


            const display =
                (
                    option.value ||
                    ""
                )
                .trim()
                .toLowerCase();


            if(
                typedValue === aadhaar ||
                typedValue === name ||
                typedValue === display
            ){

                patientId.value =
                    option.dataset.id || "";


                aadhaarDisplay.value =
                    option.dataset.aadhaar || "";


                hospitalNo.value =
                    option.dataset.hospital || "";


                patientName.value =
                    option.dataset.name || "";


                found = true;

            }

        }
    );


    if(
        typedValue !== "" &&
        !found
    ){

        let matches = [];


        options.forEach(
            function(option){

                const aadhaar =
                    (
                        option.dataset.aadhaar ||
                        ""
                    )
                    .toLowerCase();


                const name =
                    (
                        option.dataset.name ||
                        ""
                    )
                    .toLowerCase();


                if(
                    aadhaar.includes(typedValue) ||
                    name.includes(typedValue)
                ){

                    matches.push(option);

                }

            }
        );


        if(matches.length === 1){

            const option =
                matches[0];


            patientId.value =
                option.dataset.id || "";


            aadhaarDisplay.value =
                option.dataset.aadhaar || "";


            hospitalNo.value =
                option.dataset.hospital || "";


            patientName.value =
                option.dataset.name || "";


            found = true;

        }

    }


    if(typedValue === ""){

        patientId.value = "";

        aadhaarDisplay.value = "";

        hospitalNo.value = "";

        patientName.value = "";

    }

});



/* =====================================================
   REQUIRED HELPER
===================================================== */

function setRequired(id, required){

    const field =
        document.getElementById(id);


    if(!field){

        return;

    }


    if(required){

        field.setAttribute(
            "required",
            "required"
        );

    }else{

        field.removeAttribute(
            "required"
        );

    }

}



/* =====================================================
   RECURRENCE SECTION
===================================================== */

document.getElementById(
    "disease_status"
).addEventListener(
"change",
function(){

    const value =
        this.value;


    const recurrenceBox =
        document.getElementById(
            "recurrenceBox"
        );


    const recurrenceDate =
        document.getElementById(
            "first_recurrence_date"
        );


    if(
        value.includes(
            "Progression / Recurrence"
        )
    ){

        recurrenceBox.style.display =
            "block";


        setRequired(
            "first_recurrence_date",
            true
        );

    }else{

        recurrenceBox.style.display =
            "none";


        recurrenceDate.value =
            "";


        setRequired(
            "first_recurrence_date",
            false
        );

    }

});



/* =====================================================
   IMPORTANT
   IF DEAD IS NOT CONNECTED TO VITAL STATUS
===================================================== */

/*
 * There is intentionally NO JavaScript here
 * connecting Vital Status with the If Dead section.
 *
 * The If Dead and Cause of Death sections
 * remain visible independently.
 *
 * Their fields are optional.
 */



/* =====================================================
   TREATMENT SECTION
===================================================== */

function updateTreatmentSection(){

    const treatmentGiven =
        document.getElementById(
            "treatment_given"
        ).value;


    const treatmentSection =
        document.getElementById(
            "treatmentSection"
        );


    const treatmentType =
        document.getElementById(
            "treatment_type"
        );


    if(
        treatmentGiven === "Yes"
    ){

        treatmentSection.style.display =
            "block";


        setRequired(
            "treatment_type",
            true
        );

    }else{

        treatmentSection.style.display =
            "none";


        setRequired(
            "treatment_type",
            false
        );


        treatmentType.value =
            "";


        const fields =
            treatmentSection.querySelectorAll(
                "input, select"
            );


        fields.forEach(
            function(field){

                if(
                    field.id !==
                    "treatment_type"
                ){

                    field.value = "";

                }

            }
        );

    }

}


document.getElementById(
    "treatment_given"
).addEventListener(
    "change",
    updateTreatmentSection
);



/* =====================================================
   FORM VALIDATION
===================================================== */

document.getElementById(
    "followupForm"
).addEventListener(
"submit",
function(event){


    /*
     * Patient must be selected.
     */

    if(
        document.getElementById(
            "patient_id"
        ).value === ""
    ){

        event.preventDefault();


        alert(
            "Please type or select a valid Aadhaar number or patient name."
        );


        document.getElementById(
            "patient_search"
        ).focus();


        return false;

    }


    const requiredFields =
        this.querySelectorAll(
            "[required]"
        );


    for(
        let field of requiredFields
    ){

        /*
         * Hidden fields are ignored.
         */

        if(
            field.offsetParent === null
        ){

            continue;

        }


        if(
            field.value.trim() === ""
        ){

            event.preventDefault();


            const formGroup =
                field.closest(
                    ".form-group"
                );


            const label =
                formGroup
                ?
                formGroup.querySelector(
                    "label"
                )
                :
                null;


            const fieldName =
                label
                ?
                label.textContent
                    .replace("*","")
                    .trim()
                :
                "This field";


            alert(
                fieldName +
                " is mandatory."
            );


            field.focus();


            return false;

        }

    }

});



/* =====================================================
   INITIAL STATE
===================================================== */

updateTreatmentSection();



/* =====================================================
   DIGITAL SIGNATURE
===================================================== */

const canvas =
document.getElementById("signatureCanvas");

const ctx =
canvas.getContext("2d");

const signatureInput =
document.getElementById("digital_signature");

const clearSignature =
document.getElementById("clearSignature");

let drawing = false;

ctx.lineWidth = 2;
ctx.lineCap = "round";
ctx.lineJoin = "round";


function getPosition(event){

    const rect =
    canvas.getBoundingClientRect();

    let clientX;
    let clientY;

    if(event.touches && event.touches.length){

        clientX =
        event.touches[0].clientX;

        clientY =
        event.touches[0].clientY;

    }else{

        clientX =
        event.clientX;

        clientY =
        event.clientY;

    }

    return {

        x:
        (clientX - rect.left) *
        (canvas.width / rect.width),

        y:
        (clientY - rect.top) *
        (canvas.height / rect.height)

    };

}


function startDrawing(event){

    event.preventDefault();

    drawing = true;

    const position =
    getPosition(event);

    ctx.beginPath();

    ctx.moveTo(
        position.x,
        position.y
    );

}


function drawSignature(event){

    if(!drawing){
        return;
    }

    event.preventDefault();

    const position =
    getPosition(event);

    ctx.lineTo(
        position.x,
        position.y
    );

    ctx.stroke();

}


function stopDrawing(event){

    if(!drawing){
        return;
    }

    event.preventDefault();

    drawing = false;

    signatureInput.value =
    canvas.toDataURL("image/png");

}


/* Mouse */

canvas.addEventListener(
    "mousedown",
    startDrawing
);

canvas.addEventListener(
    "mousemove",
    drawSignature
);

canvas.addEventListener(
    "mouseup",
    stopDrawing
);

canvas.addEventListener(
    "mouseleave",
    stopDrawing
);


/* Touch */

canvas.addEventListener(
    "touchstart",
    startDrawing,
    {passive:false}
);

canvas.addEventListener(
    "touchmove",
    drawSignature,
    {passive:false}
);

canvas.addEventListener(
    "touchend",
    stopDrawing,
    {passive:false}
);


/* Clear */

clearSignature.addEventListener(
    "click",
    function(){

        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );

        signatureInput.value = "";

    }
);

</script>



<style>

/* =====================================================
   MAIN CONTENT
===================================================== */

.main-content {
    padding: 30px 45px 50px;
    box-sizing: border-box;
}


/* =====================================================
   PAGE HEADER
===================================================== */

.page-header {
    position: relative;
    background: linear-gradient(135deg, #164e4a, #1f6b65);
    border-radius: 12px;

    padding: 22px 28px;
    margin: 0 0 24px 0;

    color: #ffffff;

    box-shadow: 0 4px 14px rgba(22,78,74,0.10);

    overflow: hidden;
}

.page-header::after {
    content: "";
    position: absolute;

    width: 180px;
    height: 180px;

    right: -60px;
    top: -90px;

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

    font-size: 24px;
    font-weight: 700;
}

.page-header h2 i {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    width: 40px;
    height: 40px;

    margin-right: 12px;

    background: rgba(255,255,255,0.14);

    border: 1px solid rgba(255,255,255,0.18);

    border-radius: 9px;

    color: #ffffff;
}

.page-header p {
    position: relative;
    z-index: 2;

    margin: 6px 0 0 52px;

    color: rgba(255,255,255,0.80);

    font-size: 12px;
}


/* =====================================================
   FORM CARDS
===================================================== */

.card {
    background: #ffffff;
    border: 1px solid #e5e9e8;
    border-radius: 12px;

    padding: 24px 0 30px !important;

    margin-bottom: 24px;

    box-shadow: 0 3px 14px rgba(22,78,74,0.06);

    box-sizing: border-box;
}


/* Keep section heading away from card edges */
.card h3 {
    margin: 0 32px 24px !important;
    padding-bottom: 13px;
}


/* Keep normal fields away from card edges */
.card > .form-group {
    margin-left: 32px !important;
    margin-right: 32px !important;
    width: calc(100% - 64px) !important;
}


/* Keep row-based fields away from card edges */
.card > .row {
    margin-left: 32px !important;
    margin-right: 32px !important;
    width: calc(100% - 64px) !important;
}


/* Tables also get breathing room */
.card > table {
    width: calc(100% - 64px) !important;
    margin-left: 32px !important;
    margin-right: 32px !important;
}


/* =====================================================
   SECTION HEADINGS
===================================================== */

.card h3 {
    margin: 0 0 20px 0;

    padding: 0 0 11px 0;

    color: #164e4a;

    font-size: 16px;
    font-weight: 700;

    line-height: 1.4;

    border-bottom: 1px solid #e6edeb;

    position: relative;
}

.card h3::after {
    content: "";

    position: absolute;

    left: 0;
    bottom: -1px;

    width: 50px;
    height: 2px;

    background: #164e4a;

    border-radius: 3px;
}


/* =====================================================
   SUB HEADINGS
===================================================== */

.card h4 {
    margin: 22px 0 12px 0;

    color: #164e4a;

    font-size: 14px;
    font-weight: 700;
}


/* =====================================================
   GRID
===================================================== */

.card .row {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    column-gap: 24px;
    row-gap: 18px;

    margin: 0;
}


/* =====================================================
   FORM GROUP
===================================================== */

.card .form-group {
    width: 100%;
    min-width: 0;

    margin: 0 0 17px 0;
}

.card .row .form-group {
    margin-bottom: 0;
}

.card .form-group.full {
    grid-column: 1 / -1;
}


/* =====================================================
   LABEL
===================================================== */

.card .form-group label {
    display: block;

    margin: 0 0 6px 0;

    color: #344746;

    font-size: 12px;
    font-weight: 600;

    line-height: 1.35;
}


/* =====================================================
   INPUT / SELECT
===================================================== */

.card .form-control {
    display: block;

    width: 100%;
    height: 40px;

    padding: 8px 11px;

    box-sizing: border-box;

    border: 1px solid #cfd9d6;

    border-radius: 7px;

    background: #ffffff;

    color: #263635;

    font-size: 13px;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.card .form-control:hover {
    border-color: #aebdb9;
}

.card .form-control:focus {
    outline: none;

    border-color: #164e4a;

    box-shadow: 0 0 0 3px rgba(22,78,74,0.09);
}

.card .form-control::placeholder {
    color: #9aa6a4;

    font-size: 12px;
}


/* =====================================================
   DATE / SELECT
===================================================== */

.card select.form-control {
    cursor: pointer;
}


/* =====================================================
   REQUIRED STAR
===================================================== */

label.required::after {
    content: " *";

    color: #dc3545;

    font-weight: 700;
}


/* =====================================================
   HELP TEXT
===================================================== */

.card > p {
    margin: -7px 0 15px 0;

    color: #536360;

    font-size: 12px;

    line-height: 1.5;
}


/* =====================================================
   TREATMENT TABLE
===================================================== */

.table {
    width: 100%;

    margin-top: 12px;

    border-collapse: collapse;
}

.table th,
.table td {
    padding: 10px 12px;

    vertical-align: middle;

    border: 1px solid #dfe7e4;
}

.table th {
    background: #164e4a;

    color: #ffffff;

    font-size: 12px;

    font-weight: 600;
}

.table td {
    background: #ffffff;

    font-size: 12px;
}

.table td .form-control {
    margin: 0;
}


/* =====================================================
   SIGNATURE
===================================================== */

#signatureCanvas {
    width: 100%;
    height: 200px;

    display: block;

    cursor: crosshair;

    touch-action: none;
}


/* =====================================================
   BUTTON AREA
===================================================== */

form > div:last-child {
    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 10px;

    margin-top: 5px;
}

form .btn {
    min-width: 145px;

    padding: 10px 20px;

    border-radius: 7px;

    font-size: 13px;

    font-weight: 600;

    box-shadow: 0 2px 7px rgba(0,0,0,0.07);
}

form .btn-primary {
    background: #164e4a;

    border-color: #164e4a;
}

form .btn-primary:hover {
    background: #103d39;

    border-color: #103d39;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    .main-content {
        padding: 20px 20px 35px;
    }

    .card {
        padding: 20px;
    }

    .card .row {
        grid-template-columns: 1fr;

        row-gap: 17px;
    }

    .card .form-group.full {
        grid-column: auto;
    }

}


@media (max-width: 600px) {

    .main-content {
        padding: 15px 12px 30px;
    }

    .page-header {
        padding: 18px 20px;
    }

    .page-header h2 {
        font-size: 20px;
    }

    .page-header p {
        margin-left: 0;
    }

    .card {
        padding: 17px;

        margin-bottom: 16px;
    }

    .card h3 {
        font-size: 15px;

        margin-bottom: 17px;
    }

    form > div:last-child {
        flex-direction: column;

        align-items: stretch;
    }

    form .btn {
        width: 100%;
    }

}

</style>
<?php

include("../includes/footer.php");

?>
<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");


/* =====================================================
   GET FOLLOW-UP ID
===================================================== */

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {

    echo "<script>
        alert('Invalid follow-up record.');
        window.location='followup.php';
    </script>";

    exit();
}


/* =====================================================
   FETCH FOLLOW-UP RECORD
===================================================== */

$sql = "SELECT * FROM followup WHERE id = ? LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {

    echo "<script>
        alert('Follow-up record not found.');
        window.location='followup.php';
    </script>";

    exit();
}

$followup = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* =====================================================
   PATIENT INFORMATION
===================================================== */

$patient_id = $followup['patient_id'];

$patient_stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM patients WHERE id = ? LIMIT 1"
);

mysqli_stmt_bind_param(
    $patient_stmt,
    "i",
    $patient_id
);

mysqli_stmt_execute($patient_stmt);

$patient_result = mysqli_stmt_get_result($patient_stmt);

$patient = mysqli_fetch_assoc($patient_result);

mysqli_stmt_close($patient_stmt);


/* =====================================================
   SAFE VALUE HELPER
===================================================== */

function old_value($array, $key)
{
    return htmlspecialchars(
        $array[$key] ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}

?>

<div class="main-content">

<div class="page-header">

<h2>
<i class="fa fa-edit"></i>
Edit Follow-up
</h2>

<p>Hospital Based Cancer Registry System</p>

</div>


<form
    action="update_followup.php"
    method="POST"
    id="followupForm"
    novalidate
>


<!-- =====================================================
     HIDDEN ID
===================================================== -->

<input
    type="hidden"
    name="id"
    value="<?php echo $id; ?>"
>

<input
    type="hidden"
    name="patient_id"
    value="<?php echo old_value($followup, 'patient_id'); ?>"
>


<!-- =====================================================
     PATIENT INFORMATION
===================================================== -->

<div class="card">

<h3>Patient Information</h3>

<div class="row">


<div class="form-group">

<label>Aadhaar Number</label>

<input
    type="text"
    class="form-control"
    value="<?php echo old_value($patient, 'aadhaar'); ?>"
    readonly
>

</div>


<div class="form-group">

<label>Hospital Registration No.</label>

<input
    type="text"
    class="form-control"
    value="<?php echo old_value($patient, 'hospital_no'); ?>"
    readonly
>

</div>


<div class="form-group">

<label>Patient Name</label>

<input
    type="text"
    class="form-control"
    value="<?php

        echo htmlspecialchars(
            trim(
                ($patient['first_name'] ?? '') .
                ' ' .
                ($patient['middle_name'] ?? '') .
                ' ' .
                ($patient['last_name'] ?? '')
            ),
            ENT_QUOTES,
            'UTF-8'
        );

    ?>"
    readonly
>

</div>


<div class="form-group">

<label>Visit No.</label>

<input
    type="text"
    name="visit_no"
    class="form-control"
    value="<?php echo old_value($followup, 'visit_no'); ?>"
>

</div>

</div>

</div>



<!-- =====================================================
     1 DATE
===================================================== -->

<div class="card">

<h3>1. Date of Follow-up</h3>

<div class="form-group">

<label>Follow-up Date</label>

<input
    type="date"
    name="followup_date"
    class="form-control"
    value="<?php echo old_value($followup, 'followup_date'); ?>"
    required
>

</div>

</div>



<!-- =====================================================
     2 METHOD
===================================================== -->

<div class="card">

<h3>2. Method of Follow-up</h3>

<div class="form-group">

<label>Method</label>

<select
    name="followup_method"
    class="form-control"
    required
>

<option value="">-- Select --</option>

<?php

$methods = [
    "Hospital Visit",
    "Post/email",
    "Telephone",
    "House Visit",
    "Public Database",
    "Special survey/study",
    "Others"
];

foreach ($methods as $method) {

    $selected =
        ($followup['followup_method'] ?? '') === $method
        ? 'selected'
        : '';

    echo '<option value="' .
        htmlspecialchars($method) .
        '" ' .
        $selected .
        '>' .
        htmlspecialchars($method) .
        '</option>';

}

?>

</select>

</div>

</div>



<!-- =====================================================
     3 VITAL STATUS
===================================================== -->

<div class="card">

<h3>3. Vital Status</h3>

<div class="form-group">

<label>Current Vital Status</label>

<select
    name="vital_status"
    id="vital_status"
    class="form-control"
    required
>

<option value="">-- Select --</option>

<?php

$vital_options = [
    "Alive",
    "Dead",
    "Unknown"
];

foreach ($vital_options as $option) {

    $selected =
        ($followup['vital_status'] ?? '') === $option
        ? 'selected'
        : '';

    echo '<option value="' .
        htmlspecialchars($option) .
        '" ' .
        $selected .
        '>' .
        htmlspecialchars($option) .
        '</option>';

}

?>

</select>

</div>

</div>



<!-- =====================================================
     4 DISEASE STATUS
===================================================== -->

<div class="card">

<h3>4. Disease Status</h3>

<div class="form-group">

<label>Disease Status</label>

<select
    name="disease_status"
    id="disease_status"
    class="form-control"
    required
>

<option value="">-- Select --</option>

<?php

$disease_options = [

    "No Evidence of Disease",

    "No Evidence of Disease but Second Primary Present",

    "No Evidence of Disease but other illness or conditions present",

    "Cancer in Regression / Residual Disease",

    "Cancer in Progression / Recurrence (Primary Disease and / or Metastasis)",

    "Too Advanced / Cachexia",

    "No evidence of disease but on chemotherapy/hormonal therapy",

    "Others",

    "Unknown"

];

foreach ($disease_options as $option) {

    $selected =
        ($followup['disease_status'] ?? '') === $option
        ? 'selected'
        : '';

    echo '<option value="' .
        htmlspecialchars($option) .
        '" ' .
        $selected .
        '>' .
        htmlspecialchars($option) .
        '</option>';

}

?>

</select>

</div>


<div
    id="recurrenceBox"
    style="
        display:none;
        margin-top:15px;
    "
>

<label>
If Cancer in Progression / Recurrence,
Date of First Recurrence
</label>

<input
    type="date"
    name="first_recurrence_date"
    id="first_recurrence_date"
    class="form-control"
    value="<?php echo old_value($followup, 'first_recurrence_date'); ?>"
>

</div>

</div>



<!-- =====================================================
     5 TREATMENT
===================================================== -->

<div class="card">

<h3>5. Treatment</h3>

<div class="form-group">

<label>Treatment Given</label>

<select
    name="treatment_given"
    id="treatment_given"
    class="form-control"
    required
>

<option value="">-- Select --</option>

<option
    value="Yes"
    <?php
    echo ($followup['treatment_given'] ?? '') === 'Yes'
        ? 'selected'
        : '';
    ?>
>
Yes
</option>

<option
    value="No"
    <?php
    echo ($followup['treatment_given'] ?? '') === 'No'
        ? 'selected'
        : '';
    ?>
>
No
</option>

</select>

</div>


<div
    id="treatmentSection"
    style="display:none;"
>


<h4>5.1 Type of Treatment Given</h4>

<div class="form-group">

<label>Type of Treatment Given</label>

<select
    name="treatment_type"
    id="treatment_type"
    class="form-control"
>

<option value="">-- Select --</option>

<?php

$treatment_types = [
    "Allopathic",
    "Non Allopathic",
    "Both"
];

foreach ($treatment_types as $option) {

    $selected =
        ($followup['treatment_type'] ?? '') === $option
        ? 'selected'
        : '';

    echo '<option value="' .
        htmlspecialchars($option) .
        '" ' .
        $selected .
        '>' .
        htmlspecialchars($option) .
        '</option>';

}

?>

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

<td><strong>Surgery</strong></td>

<td>

<select
    name="surgery"
    class="form-control"
>

<option value="">Select</option>

<option
    value="Yes"
    <?php echo ($followup['surgery'] ?? '') === 'Yes' ? 'selected' : ''; ?>
>
Yes
</option>

<option
    value="No"
    <?php echo ($followup['surgery'] ?? '') === 'No' ? 'selected' : ''; ?>
>
No
</option>

</select>

</td>

<td>

<input
    type="date"
    name="surgery_start_date"
    class="form-control"
    value="<?php echo old_value($followup, 'surgery_start_date'); ?>"
>

</td>

<td>

<input
    type="date"
    name="surgery_end_date"
    class="form-control"
    value="<?php echo old_value($followup, 'surgery_end_date'); ?>"
>

</td>

</tr>



<!-- RADIOTHERAPY -->

<tr>

<td><strong>Radiotherapy</strong></td>

<td>

<select
    name="radiotherapy"
    class="form-control"
>

<option value="">Select</option>

<option
    value="Yes"
    <?php echo ($followup['radiotherapy'] ?? '') === 'Yes' ? 'selected' : ''; ?>
>
Yes
</option>

<option
    value="No"
    <?php echo ($followup['radiotherapy'] ?? '') === 'No' ? 'selected' : ''; ?>
>
No
</option>

</select>

</td>

<td>

<input
    type="date"
    name="radiotherapy_start_date"
    class="form-control"
    value="<?php echo old_value($followup, 'radiotherapy_start_date'); ?>"
>

</td>

<td>

<input
    type="date"
    name="radiotherapy_end_date"
    class="form-control"
    value="<?php echo old_value($followup, 'radiotherapy_end_date'); ?>"
>

</td>

</tr>



<!-- CHEMOTHERAPY -->

<tr>

<td><strong>Chemotherapy</strong></td>

<td>

<select
    name="chemotherapy"
    class="form-control"
>

<option value="">Select</option>

<option
    value="Yes"
    <?php echo ($followup['chemotherapy'] ?? '') === 'Yes' ? 'selected' : ''; ?>
>
Yes
</option>

<option
    value="No"
    <?php echo ($followup['chemotherapy'] ?? '') === 'No' ? 'selected' : ''; ?>
>
No
</option>

</select>

</td>

<td>

<input
    type="date"
    name="chemotherapy_start_date"
    class="form-control"
    value="<?php echo old_value($followup, 'chemotherapy_start_date'); ?>"
>

</td>

<td>

<input
    type="date"
    name="chemotherapy_end_date"
    class="form-control"
    value="<?php echo old_value($followup, 'chemotherapy_end_date'); ?>"
>

</td>

</tr>



<!-- HORMONE -->

<tr>

<td><strong>Hormone Therapy</strong></td>

<td>

<select
    name="hormone_therapy"
    class="form-control"
>

<option value="">Select</option>

<option
    value="Yes"
    <?php echo ($followup['hormone_therapy'] ?? '') === 'Yes' ? 'selected' : ''; ?>
>
Yes
</option>

<option
    value="No"
    <?php echo ($followup['hormone_therapy'] ?? '') === 'No' ? 'selected' : ''; ?>
>
No
</option>

</select>

</td>

<td>

<input
    type="date"
    name="hormone_therapy_start_date"
    class="form-control"
    value="<?php echo old_value($followup, 'hormone_therapy_start_date'); ?>"
>

</td>

<td>

<input
    type="date"
    name="hormone_therapy_end_date"
    class="form-control"
    value="<?php echo old_value($followup, 'hormone_therapy_end_date'); ?>"
>

</td>

</tr>



<!-- TARGETED -->

<tr>

<td><strong>Targeted Therapy</strong></td>

<td>

<select
    name="targeted_therapy"
    class="form-control"
>

<option value="">Select</option>

<option
    value="Yes"
    <?php echo ($followup['targeted_therapy'] ?? '') === 'Yes' ? 'selected' : ''; ?>
>
Yes
</option>

<option
    value="No"
    <?php echo ($followup['targeted_therapy'] ?? '') === 'No' ? 'selected' : ''; ?>
>
No
</option>

</select>

</td>

<td>

<input
    type="date"
    name="targeted_therapy_start_date"
    class="form-control"
    value="<?php echo old_value($followup, 'targeted_therapy_start_date'); ?>"
>

</td>

<td>

<input
    type="date"
    name="targeted_therapy_end_date"
    class="form-control"
    value="<?php echo old_value($followup, 'targeted_therapy_end_date'); ?>"
>

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
    value="<?php echo old_value($followup, 'other_treatment'); ?>"
>

</td>

<td>

<select
    name="other_treatment_given"
    class="form-control"
>

<option value="">Select</option>

<option
    value="Yes"
    <?php echo ($followup['other_treatment_given'] ?? '') === 'Yes' ? 'selected' : ''; ?>
>
Yes
</option>

<option
    value="No"
    <?php echo ($followup['other_treatment_given'] ?? '') === 'No' ? 'selected' : ''; ?>
>
No
</option>

</select>

</td>

<td>

<input
    type="date"
    name="other_treatment_start_date"
    class="form-control"
    value="<?php echo old_value($followup, 'other_treatment_start_date'); ?>"
>

</td>

<td>

<input
    type="date"
    name="other_treatment_end_date"
    class="form-control"
    value="<?php echo old_value($followup, 'other_treatment_end_date'); ?>"
>

</td>

</tr>

</tbody>

</table>

</div>

</div>



<!-- =====================================================
     IF DEAD
===================================================== -->

<div class="card">

<h3>If Dead</h3>


<div class="form-group">

<label>6. Date of Death</label>

<input
    type="date"
    name="date_of_death"
    class="form-control"
    value="<?php echo old_value($followup, 'date_of_death'); ?>"
>

</div>


<div class="form-group">

<label>7. Place of Death</label>

<select
    name="place_of_death"
    class="form-control"
>

<option value="">-- Select --</option>

<?php

$place_options = [
    "At Reporting Institution (RI)",
    "Other Hospital",
    "Residence",
    "Others",
    "Not available/Unknown"
];

foreach ($place_options as $option) {

    $selected =
        ($followup['place_of_death'] ?? '') === $option
        ? 'selected'
        : '';

    echo '<option value="' .
        htmlspecialchars($option) .
        '" ' .
        $selected .
        '>' .
        htmlspecialchars($option) .
        '</option>';

}

?>

</select>

</div>


<div class="form-group">

<label>8. Source of Information on Death</label>

<select
    name="death_information_source"
    class="form-control"
>

<option value="">-- Select --</option>

<?php

$source_options = [

    "Civil registration system",

    "Burial/cremation record",

    "Voter list",

    "Aadhaar",

    "Census",

    "Ayushman Bharat Digital Mission database",

    "Others",

    "Not available/Unknown"

];

foreach ($source_options as $option) {

    $selected =
        ($followup['death_information_source'] ?? '') === $option
        ? 'selected'
        : '';

    echo '<option value="' .
        htmlspecialchars($option) .
        '" ' .
        $selected .
        '>' .
        htmlspecialchars($option) .
        '</option>';

}

?>

</select>

</div>

</div>



<!-- =====================================================
     CAUSE OF DEATH
===================================================== -->

<div class="card">

<h3>9. Cause of Death</h3>

<p>
If information is unavailable, enter <strong>999</strong>.
</p>


<div class="form-group">

<label>Immediate Cause</label>

<input
    type="text"
    name="immediate_cause"
    class="form-control"
    value="<?php echo old_value($followup, 'immediate_cause'); ?>"
>

</div>


<div class="form-group">

<label>Antecedent Cause</label>

<input
    type="text"
    name="antecedent_cause"
    class="form-control"
    value="<?php echo old_value($followup, 'antecedent_cause'); ?>"
>

</div>


<div class="form-group">

<label>Underlying Cause</label>

<input
    type="text"
    name="underlying_cause"
    class="form-control"
    value="<?php echo old_value($followup, 'underlying_cause'); ?>"
>

</div>


<div class="form-group">

<label>Contributing / Significant Conditions or Diseases</label>

<input
    type="text"
    name="contributing_conditions"
    class="form-control"
    value="<?php echo old_value($followup, 'contributing_conditions'); ?>"
>

</div>

</div>



<!-- =====================================================
     FINAL INFORMATION
===================================================== -->

<div class="card">

<h3>Final Information</h3>


<div class="form-group">

<label>10. ICD-10 of Underlying Cause of Death (UCOD)</label>

<input
    type="text"
    name="ucod"
    class="form-control"
    value="<?php echo old_value($followup, 'ucod'); ?>"
>

</div>


<div class="form-group">

<label>11. Major Cause Group of UCOD</label>

<input
    type="text"
    name="major_cause_group"
    class="form-control"
    value="<?php echo old_value($followup, 'major_cause_group'); ?>"
>

</div>


<div class="form-group">

<label>12. Name of Person Completing Form</label>

<input
    type="text"
    name="person_completing"
    class="form-control"
    value="<?php echo old_value($followup, 'person_completing'); ?>"
>

</div>


<div class="form-group">

<label>13. Date of Completion of this Form</label>

<input
    type="date"
    name="completion_date"
    class="form-control"
    value="<?php echo old_value($followup, 'completion_date'); ?>"
>

</div>



<!-- =====================================================
     DIGITAL SIGNATURE
===================================================== -->

<div class="form-group">

<label>Digital Signature</label>

<div
    style="
        border:1px solid #ccc;
        border-radius:6px;
        background:#fff;
        max-width:700px;
    "
>

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
    id="clearSignature"
>

<i class="fa fa-eraser"></i>
Clear Signature

</button>


<input
    type="hidden"
    name="digital_signature"
    id="digital_signature"
    value="<?php echo old_value($followup, 'digital_signature'); ?>"
>

</div>

</div>



<!-- =====================================================
     BUTTONS
===================================================== -->

<div style="margin:30px 0;">

<button
    type="submit"
    class="btn btn-primary btn-lg"
>

<i class="fa fa-save"></i>
Update Follow-up

</button>


<a
    href="followup.php"
    class="btn btn-secondary btn-lg"
>

Back

</a>

</div>


</form>

</div>



<script>

/* =====================================================
   RECURRENCE
===================================================== */

function updateRecurrence(){

    const disease =
        document.getElementById("disease_status").value;

    const box =
        document.getElementById("recurrenceBox");

    if(
        disease.includes("Progression / Recurrence")
    ){

        box.style.display = "block";

    }else{

        box.style.display = "none";

    }

}

document
    .getElementById("disease_status")
    .addEventListener(
        "change",
        updateRecurrence
    );


/* =====================================================
   TREATMENT
===================================================== */

function updateTreatment(){

    const value =
        document.getElementById("treatment_given").value;

    const section =
        document.getElementById("treatmentSection");

    if(value === "Yes"){

        section.style.display = "block";

    }else{

        section.style.display = "none";

    }

}

document
    .getElementById("treatment_given")
    .addEventListener(
        "change",
        updateTreatment
    );


/* =====================================================
   DIGITAL SIGNATURE
===================================================== */

const canvas =
    document.getElementById("signatureCanvas");

const ctx =
    canvas.getContext("2d");

const signatureInput =
    document.getElementById("digital_signature");

let drawing = false;


/* Drawing settings */

ctx.lineWidth = 2;
ctx.lineCap = "round";
ctx.lineJoin = "round";


/* =====================================================
   LOAD EXISTING SIGNATURE
===================================================== */

const existingSignature =
    signatureInput.value.trim();


if (existingSignature !== "") {

    const image = new Image();

    image.onload = function () {

        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );

        ctx.drawImage(
            image,
            0,
            0,
            canvas.width,
            canvas.height
        );

    };

    image.src = existingSignature;

}


/* =====================================================
   GET POSITION
===================================================== */

function getPosition(event) {

    const rect =
        canvas.getBoundingClientRect();

    let clientX;
    let clientY;


    if (
        event.touches &&
        event.touches.length > 0
    ) {

        clientX =
            event.touches[0].clientX;

        clientY =
            event.touches[0].clientY;

    } else {

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


/* =====================================================
   START DRAWING
===================================================== */

function startDrawing(event) {

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


/* =====================================================
   DRAW
===================================================== */

function drawSignature(event) {

    if (!drawing) {
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


/* =====================================================
   STOP DRAWING
===================================================== */

function stopDrawing(event) {

    if (!drawing) {
        return;
    }

    event.preventDefault();

    drawing = false;

    saveSignature();

}


/* =====================================================
   SAVE SIGNATURE
===================================================== */

function saveSignature() {

    signatureInput.value =
        canvas.toDataURL("image/png");

}


/* =====================================================
   MOUSE
===================================================== */

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


/* =====================================================
   TOUCH
===================================================== */

canvas.addEventListener(
    "touchstart",
    startDrawing,
    { passive: false }
);

canvas.addEventListener(
    "touchmove",
    drawSignature,
    { passive: false }
);

canvas.addEventListener(
    "touchend",
    stopDrawing,
    { passive: false }
);


/* =====================================================
   CLEAR SIGNATURE
===================================================== */

document
    .getElementById("clearSignature")
    .addEventListener(
        "click",
        function () {

            ctx.clearRect(
                0,
                0,
                canvas.width,
                canvas.height
            );

            signatureInput.value = "";

        }
    );


/* =====================================================
   BEFORE SUBMIT
===================================================== */

document
    .getElementById("followupForm")
    .addEventListener(
        "submit",
        function () {

            saveSignature();

        }
    );


/* =====================================================
   INITIAL STATE
===================================================== */

updateRecurrence();

updateTreatment();

</script>


<style>

.card h3{

    color:#164e4a;

}

.table th{

    vertical-align:middle;

}

.table td{

    vertical-align:middle;

}

</style>


<?php

include("../includes/footer.php");

?>
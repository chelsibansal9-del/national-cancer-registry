<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");
?>

<style>

/* =========================================================
   HBCR DIAGNOSIS LIST
   SAME DESIGN AS PATIENT LIST
========================================================= */

.diagnosis-list-page {
    padding: 22px 24px 35px;
}

/* PAGE HEADER */

.diagnosis-page-header {
    background: #ffffff;
    border: 1px solid #dfe8e5;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 18px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    box-shadow: 0 4px 18px rgba(30,70,60,.06);
}

.diagnosis-page-title {
    display: flex;
    align-items: center;
    gap: 13px;
}

.diagnosis-page-icon {
    width: 44px;
    height: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 11px;

    background: #e7f4ef;
    color: #08745f;

    font-size: 18px;
}

.diagnosis-page-title h2 {
    margin: 0;
    color: #183b37;
    font-size: 19px;
    font-weight: 700;
}

.diagnosis-page-title p {
    margin: 4px 0 0;
    color: #82918e;
    font-size: 10px;
}

.diagnosis-count {
    display: flex;
    align-items: center;
    gap: 7px;

    padding: 8px 12px;

    background: #f3f8f6;
    border: 1px solid #dce9e5;
    border-radius: 8px;

    color: #08745f;
    font-size: 11px;
    font-weight: 600;
}

/* TABLE CARD */

.diagnosis-table-card {
    background: #ffffff;
    border: 1px solid #dfe8e5;
    border-radius: 14px;
    overflow: hidden;

    box-shadow: 0 5px 20px rgba(30,70,60,.06);
}

/* TABLE HEADER */

.diagnosis-table-header {
    padding: 16px 20px;

    border-bottom: 1px solid #e8efed;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.diagnosis-table-heading h3 {
    margin: 0;
    color: #243e39;
    font-size: 14px;
    font-weight: 700;
}

.diagnosis-table-heading span {
    display: block;
    margin-top: 3px;
    color: #8a9996;
    font-size: 10px;
}

/* ADD BUTTON */

.diagnosis-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    min-height: 34px;
    padding: 7px 12px;

    border-radius: 7px;

    background: #e7f4ef;
    border: 1px solid #d3e9e1;

    color: #08745f;

    text-decoration: none;

    font-size: 10px;
    font-weight: 700;

    transition: .15s ease;
}

.diagnosis-add-btn:hover {
    background: #dcefe9;
    color: #075c50;
    transform: translateY(-1px);
}

/* SEARCH */

.diagnosis-search {
    position: relative;
    width: 260px;
}

.diagnosis-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);

    color: #82938f;
    font-size: 12px;
}

.diagnosis-search input {
    width: 100%;
    height: 37px;

    padding: 8px 12px 8px 34px;

    border: 1px solid #d6e2df;
    border-radius: 8px;

    background: #fbfcfc;

    color: #344b47;
    font-size: 11px;

    outline: none;
}

.diagnosis-search input:focus {
    background: #fff;
    border-color: #78b9ad;
    box-shadow: 0 0 0 3px rgba(8,112,95,.08);
}

/* TABLE */

.diagnosis-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.diagnosis-list-table {
    width: 100%;
    min-width: 1000px;

    border-collapse: separate;
    border-spacing: 0;
}

.diagnosis-list-table thead th {
    background: #edf6f3;

    color: #45645e;

    font-size: 10px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .35px;

    padding: 12px 13px;

    border-bottom: 1px solid #dce8e5;

    white-space: nowrap;
}

.diagnosis-list-table tbody td {
    padding: 12px 13px;

    color: #526560;

    font-size: 11px;

    border-bottom: 1px solid #edf1ef;

    vertical-align: middle;

    background: #ffffff;
}

.diagnosis-list-table tbody tr:hover td {
    background: #f6faf8;
}

.diagnosis-list-table tbody tr:last-child td {
    border-bottom: none;
}

/* PATIENT */

.diagnosis-patient {
    display: flex;
    align-items: center;
    gap: 9px;

    min-width: 160px;
}

.diagnosis-avatar {
    width: 30px;
    height: 30px;
    min-width: 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #e8f3f0;
    color: #08745f;

    font-size: 12px;
}

.diagnosis-patient-name {
    color: #344b47;
    font-size: 11px;
    font-weight: 600;
}

.diagnosis-hbcr {
    display: inline-flex;

    padding: 5px 8px;

    background: #e7f4ef;
    border: 1px solid #d3e9e1;

    border-radius: 6px;

    color: #08745f;

    font-size: 10px;
    font-weight: 700;
}

/* STAGE */

.diagnosis-stage {
    display: inline-flex;

    min-width: 55px;

    justify-content: center;

    padding: 5px 8px;

    border-radius: 6px;

    background: #f4eeee;
    border: 1px solid #eadbdd;

    color: #93666c;

    font-size: 9px;
    font-weight: 700;
}

/* ACTIONS */

.diagnosis-actions {
    display: inline-flex;
    gap: 5px;
    white-space: nowrap;
}

.diagnosis-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;

    min-height: 30px;

    padding: 6px 9px;

    border-radius: 7px;

    text-decoration: none;

    font-size: 9px;
    font-weight: 700;

    transition: .15s ease;
}

.diagnosis-action-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(30,60,50,.08);
}

.diagnosis-edit {
    color: #98702d;
    background: #fff7e9;
    border: 1px solid #efdfc3;
}

.diagnosis-delete {
    color: #b65358;
    background: #fff1f1;
    border: 1px solid #f0d6d6;
}

.diagnosis-empty {
    text-align: center;
    padding: 45px 20px !important;
    color: #8c9a97 !important;
}

.diagnosis-empty i {
    display: block;
    margin-bottom: 8px;
    font-size: 25px;
    color: #b2c0bc;
}

@media(max-width:850px) {

    .diagnosis-list-page {
        padding: 15px;
    }

    .diagnosis-page-header,
    .diagnosis-table-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .diagnosis-search {
        width: 100%;
    }
}

</style>


<div class="main-content">

<div class="diagnosis-list-page">


<!-- PAGE HEADER -->

<div class="diagnosis-page-header">

    <div class="diagnosis-page-title">

        <div class="diagnosis-page-icon">
            <i class="fa fa-stethoscope"></i>
        </div>

        <div>

            <h2>Diagnosis Records</h2>

            <p>
                View and manage all registered cancer diagnosis records.
            </p>

        </div>

    </div>

    <div class="diagnosis-count">

        <i class="fa fa-file-medical"></i>

        <span id="diagnosisCount">
            Diagnosis Records
        </span>

    </div>

</div>


<!-- TABLE CARD -->

<div class="diagnosis-table-card">


<div class="diagnosis-table-header">

    <div class="diagnosis-table-heading">

        <h3>
            <i class="fa fa-clipboard-list"></i>
            Diagnosis Records
        </h3>

        <span>
            Search, edit or delete diagnosis records.
        </span>

    </div>


    <div style="display:flex;align-items:center;gap:10px;">

        <div class="diagnosis-search">

            <i class="fa fa-search"></i>

            <input
                type="text"
                id="diagnosisSearch"
                placeholder="Search patient, HBCR, cancer site..."
            >

        </div>

        <a
            href="diagnosis_form.php"
            class="diagnosis-add-btn">

            <i class="fa fa-plus"></i>
            Add Diagnosis

        </a>

    </div>

</div>


<div class="diagnosis-table-wrapper">

<table class="diagnosis-list-table">

<thead>

<tr>

<th>No.</th>
<th>HBCR No.</th>
<th>Patient Name</th>
<th>Cancer Site</th>
<th>Histology</th>
<th>Stage</th>
<th>Diagnosis Date</th>
<th>Actions</th>

</tr>

</thead>


<tbody id="diagnosisTable">

<?php

$sql = "
SELECT
    diagnosis.*,
    patients.hbcr_no,
    patients.first_name,
    patients.last_name
FROM diagnosis
LEFT JOIN patients
    ON diagnosis.patient_id = patients.id
ORDER BY diagnosis.id DESC
";

$result = mysqli_query($conn, $sql);

$count = 1;

if ($result && mysqli_num_rows($result) > 0) {

while ($row = mysqli_fetch_assoc($result)) {

$firstName = $row['first_name'] ?? '';
$lastName = $row['last_name'] ?? '';

$patientName =
    trim($firstName . " " . $lastName);

$initial =
    !empty($firstName)
    ? strtoupper(substr($firstName,0,1))
    : "P";

?>

<tr>

<td>
<span style="color:#8a9996;font-weight:600;">
<?php echo $count++; ?>
</span>
</td>

<td>

<span class="diagnosis-hbcr">

<?php
echo htmlspecialchars(
    $row['hbcr_no'] ?? '-'
);
?>

</span>

</td>

<td>

<div class="diagnosis-patient">

<div class="diagnosis-avatar">

<?php echo htmlspecialchars($initial); ?>

</div>

<span class="diagnosis-patient-name">

<?php
echo htmlspecialchars(
    $patientName ?: 'Unknown Patient'
);
?>

</span>

</div>

</td>

<td>
<?php
echo htmlspecialchars(
    $row['primary_site'] ?? 'Not Added'
);
?>
</td>

<td>
<?php
echo htmlspecialchars(
    $row['histology'] ?? 'Not Added'
);
?>
</td>

<td>

<span class="diagnosis-stage">

<?php
echo htmlspecialchars(
    $row['stage'] ?? 'Not Added'
);
?>

</span>

</td>

<td>
<?php
echo htmlspecialchars(
    $row['diagnosis_date'] ?? '-'
);
?>
</td>

<td>

<div class="diagnosis-actions">

<a
    href="edit_diagnosis.php?id=<?php echo (int)$row['id']; ?>"
    class="diagnosis-action-btn diagnosis-edit">

    <i class="fa fa-edit"></i>
    Edit

</a>

<a
    href="delete_diagnosis.php?id=<?php echo (int)$row['id']; ?>"
    class="diagnosis-action-btn diagnosis-delete"
    onclick="return confirm('Are you sure you want to delete this diagnosis?');">

    <i class="fa fa-trash"></i>
    Delete

</a>

</div>

</td>

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="8" class="diagnosis-empty">

<i class="fa fa-folder-open"></i>

No Diagnosis Records Found

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</div>


<script>

document.addEventListener("DOMContentLoaded", function(){

const search =
document.getElementById("diagnosisSearch");

const table =
document.getElementById("diagnosisTable");

const count =
document.getElementById("diagnosisCount");


function updateCount(){

let visible = 0;

table.querySelectorAll("tr").forEach(function(row){

if(
row.style.display !== "none" &&
row.querySelector(".diagnosis-patient")
){
visible++;
}

});

count.innerHTML =
'<i class="fa fa-file-medical"></i> ' +
visible +
' Diagnosis' +
(visible === 1 ? '' : ' Records');

}


search.addEventListener("keyup", function(){

const value =
this.value.toLowerCase().trim();

table.querySelectorAll("tr").forEach(function(row){

const text =
row.innerText.toLowerCase();

row.style.display =
text.includes(value) ? "" : "none";

});

updateCount();

});

updateCount();

});

</script>


<?php
include("../includes/footer.php");
?>
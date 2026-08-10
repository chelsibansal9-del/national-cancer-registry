<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");
?>

<style>

/* =========================================================
   HBCR FOLLOW-UP LIST
   SAME DESIGN AS PATIENT LIST
========================================================= */

.followup-list-page {
    padding: 22px 24px 35px;
}

.followup-page-header {
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

.followup-page-title {
    display: flex;

    align-items: center;

    gap: 13px;
}

.followup-page-icon {
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

.followup-page-title h2 {
    margin: 0;

    color: #183b37;

    font-size: 19px;

    font-weight: 700;
}

.followup-page-title p {
    margin: 4px 0 0;

    color: #82918e;

    font-size: 10px;
}

.followup-count {
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

.followup-table-card {
    background: #ffffff;

    border: 1px solid #dfe8e5;

    border-radius: 14px;

    overflow: hidden;

    box-shadow: 0 5px 20px rgba(30,70,60,.06);
}

.followup-table-header {
    padding: 16px 20px;

    border-bottom: 1px solid #e8efed;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;
}

.followup-heading h3 {
    margin: 0;

    color: #243e39;

    font-size: 14px;

    font-weight: 700;
}

.followup-heading span {
    display: block;

    margin-top: 3px;

    color: #8a9996;

    font-size: 10px;
}

.followup-header-right {
    display: flex;

    align-items: center;

    gap: 10px;
}

.followup-search {
    position: relative;

    width: 260px;
}

.followup-search i {
    position: absolute;

    left: 12px;

    top: 50%;

    transform: translateY(-50%);

    color: #82938f;

    font-size: 12px;
}

.followup-search input {
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

.followup-search input:focus {
    background: #ffffff;

    border-color: #78b9ad;

    box-shadow: 0 0 0 3px rgba(8,112,95,.08);
}

.followup-add-btn {
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
}

.followup-add-btn:hover {
    background: #dcefe9;

    color: #075c50;
}

.followup-table-wrapper {
    width: 100%;

    overflow-x: auto;
}

.followup-list-table {
    width: 100%;

    min-width: 1100px;

    border-collapse: separate;

    border-spacing: 0;
}

.followup-list-table thead th {
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

.followup-list-table tbody td {
    padding: 12px 13px;

    color: #526560;

    font-size: 11px;

    border-bottom: 1px solid #edf1ef;

    vertical-align: middle;

    background: #ffffff;
}

.followup-list-table tbody tr:hover td {
    background: #f6faf8;
}

.followup-hbcr {
    display: inline-flex;

    padding: 5px 8px;

    background: #e7f4ef;

    border: 1px solid #d3e9e1;

    border-radius: 6px;

    color: #08745f;

    font-size: 10px;

    font-weight: 700;
}

.followup-patient {
    display: flex;

    align-items: center;

    gap: 9px;

    min-width: 160px;
}

.followup-avatar {
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

.followup-name {
    color: #344b47;

    font-size: 11px;

    font-weight: 600;
}

.followup-alive {
    display: inline-flex;

    padding: 5px 8px;

    border-radius: 6px;

    background: #e7f4ef;

    border: 1px solid #d3e9e1;

    color: #08745f;

    font-size: 9px;

    font-weight: 700;
}

.followup-dead {
    display: inline-flex;

    padding: 5px 8px;

    border-radius: 6px;

    background: #fff1f1;

    border: 1px solid #f0d6d6;

    color: #b65358;

    font-size: 9px;

    font-weight: 700;
}

.followup-neutral {
    display: inline-flex;

    padding: 5px 8px;

    border-radius: 6px;

    background: #f4f6f5;

    border: 1px solid #e3e8e6;

    color: #8a9693;

    font-size: 9px;

    font-weight: 700;
}

.followup-actions {
    display: inline-flex;

    gap: 5px;

    white-space: nowrap;
}

.followup-action-btn {
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

.followup-action-btn:hover {
    transform: translateY(-1px);

    box-shadow: 0 3px 8px rgba(30,60,50,.08);
}

.followup-edit {
    color: #98702d;

    background: #fff7e9;

    border: 1px solid #efdfc3;
}

.followup-delete {
    color: #b65358;

    background: #fff1f1;

    border: 1px solid #f0d6d6;
}

.followup-empty {
    text-align: center;

    padding: 45px 20px !important;

    color: #8c9a97 !important;
}

.followup-empty i {
    display: block;

    margin-bottom: 8px;

    color: #b2c0bc;

    font-size: 25px;
}

@media(max-width:850px) {

    .followup-list-page {
        padding: 15px;
    }

    .followup-page-header,
    .followup-table-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .followup-header-right {
        width: 100%;
    }

    .followup-search {
        width: 100%;
    }
}

</style>


<div class="main-content">

<div class="followup-list-page">


<!-- PAGE HEADER -->

<div class="followup-page-header">

<div class="followup-page-title">

<div class="followup-page-icon">

<i class="fa fa-calendar-check"></i>

</div>

<div>

<h2>Follow-up Records</h2>

<p>
View and manage all registered patient follow-up records.
</p>

</div>

</div>


<div class="followup-count">

<i class="fa fa-calendar-check"></i>

<span id="followupCount">
Follow-up Records
</span>

</div>

</div>


<!-- TABLE CARD -->

<div class="followup-table-card">


<div class="followup-table-header">

<div class="followup-heading">

<h3>

<i class="fa fa-clipboard-list"></i>

Follow-up Records

</h3>

<span>
Search, edit or delete registered follow-up records.
</span>

</div>


<div class="followup-header-right">


<div class="followup-search">

<i class="fa fa-search"></i>

<input
type="text"
id="followupSearch"
placeholder="Search patient, HBCR, status..."
>

</div>


<a
href="followup_form.php"
class="followup-add-btn">

<i class="fa fa-plus"></i>

Add Follow-up

</a>

</div>

</div>


<div class="followup-table-wrapper">

<table class="followup-list-table">

<thead>

<tr>

<th>ID</th>
<th>HBCR No.</th>
<th>Patient Name</th>
<th>Visit No.</th>
<th>Follow-up Date</th>
<th>Method</th>
<th>Vital Status</th>
<th>Disease Status</th>
<th>Treatment</th>
<th>Actions</th>

</tr>

</thead>


<tbody id="followupTable">

<?php

$sql = "
SELECT
    followup.*,
    patients.hbcr_no,
    patients.first_name,
    patients.last_name
FROM followup
INNER JOIN patients
    ON followup.patient_id = patients.id
ORDER BY followup.id DESC
";

$result = mysqli_query($conn,$sql);


if($result && mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

$firstName =
$row['first_name'] ?? '';

$patientName =
trim(
$firstName . ' ' .
($row['last_name'] ?? '')
);

$initial =
$firstName !== ''
? strtoupper(substr($firstName,0,1))
: 'P';

$vital =
$row['vital_status'] ?? '';

?>

<tr>

<td>

<span style="color:#8a9996;font-weight:600;">

<?php
echo (int)$row['id'];
?>

</span>

</td>


<td>

<span class="followup-hbcr">

<?php
echo htmlspecialchars(
$row['hbcr_no'] ?? '-'
);
?>

</span>

</td>


<td>

<div class="followup-patient">

<div class="followup-avatar">

<?php
echo htmlspecialchars($initial);
?>

</div>

<span class="followup-name">

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
$row['visit_no'] ?? '-'
);
?>

</td>


<td>

<?php
echo htmlspecialchars(
$row['followup_date'] ?? '-'
);
?>

</td>


<td>

<?php
echo htmlspecialchars(
$row['followup_method'] ?? '-'
);
?>

</td>


<td>

<?php

if($vital === 'Alive'){

echo '<span class="followup-alive">
Alive
</span>';

}elseif($vital === 'Dead'){

echo '<span class="followup-dead">
Dead
</span>';

}else{

echo '<span class="followup-neutral">'
.
htmlspecialchars(
$vital ?: 'Not Added'
)
.
'</span>';

}

?>

</td>


<td>

<?php
echo htmlspecialchars(
$row['disease_status'] ?? '-'
);
?>

</td>


<td>

<?php
echo htmlspecialchars(
$row['treatment_given'] ?? '-'
);
?>

</td>


<td>

<div class="followup-actions">


<a
href="edit_followup.php?id=<?php echo (int)$row['id']; ?>"
class="followup-action-btn followup-edit">

<i class="fa fa-edit"></i>

Edit

</a>


<a
href="delete_followup.php?id=<?php echo (int)$row['id']; ?>"
class="followup-action-btn followup-delete"

onclick="return confirm('Are you sure you want to delete this follow-up record?');">

<i class="fa fa-trash"></i>

Delete

</a>


</div>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td
colspan="10"
class="followup-empty">

<i class="fa fa-folder-open"></i>

No Follow-up Records Found

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

document.addEventListener("DOMContentLoaded",function(){

const search =
document.getElementById("followupSearch");

const table =
document.getElementById("followupTable");

const count =
document.getElementById("followupCount");


function updateCount(){

let visible = 0;

table.querySelectorAll("tr").forEach(function(row){

if(
row.style.display !== "none" &&
row.querySelector(".followup-patient")
){

visible++;

}

});

count.innerHTML =
'<i class="fa fa-calendar-check"></i> ' +
visible +
' Follow-up' +
(visible === 1 ? '' : ' Records');

}


search.addEventListener("keyup",function(){

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
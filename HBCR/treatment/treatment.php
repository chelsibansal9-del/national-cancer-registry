<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");
?>

<style>

/* =========================================================
   TREATMENT LIST PAGE
   SAME DESIGN AS PATIENT LIST
========================================================= */

.treatment-list-page {
    padding: 22px 24px 35px;
}


/* =========================================================
   PAGE HEADER
========================================================= */

.treatment-page-header {
    background: #ffffff;
    border: 1px solid #dfe8e5;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 18px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    box-shadow: 0 4px 18px rgba(30, 70, 60, 0.06);
}


.treatment-page-title {
    display: flex;
    align-items: center;
    gap: 13px;
}


.treatment-page-icon {
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


.treatment-page-title h2 {
    margin: 0;
    color: #183b37;
    font-size: 19px;
    font-weight: 700;
}


.treatment-page-title p {
    margin: 4px 0 0;
    color: #82918e;
    font-size: 10px;
}


/* =========================================================
   COUNT
========================================================= */

.treatment-count {
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


/* =========================================================
   TABLE CARD
========================================================= */

.treatment-table-card {
    background: #ffffff;

    border: 1px solid #dfe8e5;

    border-radius: 14px;

    overflow: hidden;

    box-shadow:
        0 5px 20px rgba(30, 70, 60, 0.06);
}


/* =========================================================
   TABLE HEADER
========================================================= */

.treatment-table-header {
    padding: 16px 20px;

    border-bottom: 1px solid #e8efed;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;
}


.treatment-table-heading {
    display: flex;
    flex-direction: column;
    gap: 3px;
}


.treatment-table-heading h3 {
    margin: 0;

    color: #243e39;

    font-size: 14px;
    font-weight: 700;
}


.treatment-table-heading span {
    color: #8a9996;
    font-size: 10px;
}


/* =========================================================
   SEARCH
========================================================= */

.treatment-search {
    position: relative;
    width: 280px;
}


.treatment-search i {
    position: absolute;

    left: 12px;
    top: 50%;

    transform: translateY(-50%);

    color: #82938f;

    font-size: 12px;

    pointer-events: none;
}


.treatment-search input {
    width: 100%;

    height: 37px;

    padding: 8px 12px 8px 34px;

    border: 1px solid #d6e2df;

    border-radius: 8px;

    background: #fbfcfc;

    color: #344b47;

    font-size: 11px;

    outline: none;

    transition: .2s ease;
}


.treatment-search input:hover {
    border-color: #b9d0c9;
}


.treatment-search input:focus {
    background: #ffffff;

    border-color: #78b9ad;

    box-shadow:
        0 0 0 3px rgba(8,112,95,.08);
}


/* =========================================================
   ADD BUTTON
========================================================= */

.treatment-add-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 6px;

    padding: 8px 12px;

    border-radius: 7px;

    background: #e7f4ef;

    border: 1px solid #d3e9e1;

    color: #08745f;

    font-size: 10px;

    font-weight: 700;

    text-decoration: none;

    transition: .15s ease;
}


.treatment-add-btn:hover {
    background: #dcefe9;

    color: #075c50;

    transform: translateY(-1px);

    box-shadow:
        0 3px 8px rgba(30,60,50,.08);
}


/* =========================================================
   TABLE WRAPPER
========================================================= */

.treatment-table-wrapper {
    width: 100%;
    overflow-x: auto;
}


/* =========================================================
   TABLE
========================================================= */

.treatment-list-table {
    width: 100%;

    border-collapse: separate;

    border-spacing: 0;

    min-width: 1250px;
}


/* =========================================================
   TABLE HEADER
========================================================= */

.treatment-list-table thead th {
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


/* =========================================================
   TABLE BODY
========================================================= */

.treatment-list-table tbody td {
    padding: 12px 13px;

    color: #526560;

    font-size: 11px;

    border-bottom: 1px solid #edf1ef;

    vertical-align: middle;

    background: #ffffff;
}


.treatment-list-table tbody tr {
    transition: .15s ease;
}


.treatment-list-table tbody tr:hover td {
    background: #f6faf8;
}


.treatment-list-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   SERIAL NUMBER
========================================================= */

.treatment-id {
    color: #8a9996;

    font-size: 10px;

    font-weight: 600;
}


/* =========================================================
   HBCR NUMBER
========================================================= */

.treatment-hbcr {
    display: inline-flex;

    align-items: center;

    padding: 5px 8px;

    background: #e7f4ef;

    border: 1px solid #d3e9e1;

    border-radius: 6px;

    color: #08745f;

    font-size: 10px;

    font-weight: 700;

    white-space: nowrap;
}


/* =========================================================
   PATIENT NAME
========================================================= */

.treatment-patient {
    display: flex;

    align-items: center;

    gap: 9px;

    min-width: 150px;
}


.treatment-avatar {
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


.treatment-patient-name {
    color: #344b47;

    font-size: 11px;

    font-weight: 600;
}


/* =========================================================
   NORMAL TEXT
========================================================= */

.treatment-text {
    color: #596c67;

    font-size: 11px;
}


/* =========================================================
   STATUS BADGES
========================================================= */

.treatment-badge {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 5px 8px;

    border-radius: 6px;

    font-size: 9px;

    font-weight: 700;

    white-space: nowrap;
}


/* ACTIVE */

.treatment-status-active {
    background: #eaf6f2;

    color: #08705f;

    border: 1px solid #d3ebe4;
}


/* COMPLETED */

.treatment-status-completed {
    background: #edf3f8;

    color: #52718a;

    border: 1px solid #d9e5ed;
}


/* STOPPED */

.treatment-status-stopped {
    background: #fff1f1;

    color: #b65358;

    border: 1px solid #f0d6d6;
}


/* OTHER */

.treatment-status-other {
    background: #f4f6f5;

    color: #8a9693;

    border: 1px solid #e3e8e6;
}


/* =========================================================
   ACTIONS
========================================================= */

.treatment-actions {
    display: inline-flex;

    align-items: center;

    gap: 5px;

    white-space: nowrap;
}


.treatment-action-btn {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 5px;

    min-height: 30px;

    padding: 6px 9px;

    border-radius: 7px;

    border: 1px solid transparent;

    text-decoration: none;

    font-size: 9px;

    font-weight: 700;

    line-height: 1;

    cursor: pointer;

    transition:
        transform .15s ease,
        box-shadow .15s ease,
        background .15s ease;
}


.treatment-action-btn i {
    font-size: 10px;
}


.treatment-action-btn:hover {
    transform: translateY(-1px);

    box-shadow:
        0 3px 8px rgba(30,60,50,.08);
}


/* VIEW */

.treatment-action-view {
    color: #08705f;

    background: #eaf6f2;

    border-color: #d3ebe4;
}


.treatment-action-view:hover {
    color: #075c50;

    background: #dcefe9;
}


/* EDIT */

.treatment-action-edit {
    color: #98702d;

    background: #fff7e9;

    border-color: #efdfc3;
}


.treatment-action-edit:hover {
    color: #7d591e;

    background: #ffefd4;
}


/* DELETE */

.treatment-action-delete {
    color: #b65358;

    background: #fff1f1;

    border-color: #f0d6d6;
}


.treatment-action-delete:hover {
    color: #963e43;

    background: #ffe4e4;
}


/* =========================================================
   EMPTY
========================================================= */

.treatment-empty {
    text-align: center;

    padding: 45px 20px !important;

    color: #8c9a97 !important;

    font-size: 12px !important;
}


.treatment-empty i {
    display: block;

    margin-bottom: 8px;

    color: #b2c0bc;

    font-size: 25px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 850px) {

    .treatment-list-page {
        padding: 15px;
    }

    .treatment-page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .treatment-table-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .treatment-search {
        width: 100%;
    }

}

</style>


<div class="main-content">

<div class="treatment-list-page">


<!-- =========================================================
     PAGE HEADER
========================================================= -->

<div class="treatment-page-header">

    <div class="treatment-page-title">

        <div class="treatment-page-icon">
            <i class="fa fa-capsules"></i>
        </div>

        <div>

            <h2>Treatment Records</h2>

            <p>
                View and manage all treatment records registered in the HBCR system.
            </p>

        </div>

    </div>


    <div class="treatment-count">

        <i class="fa fa-capsules"></i>

        <span id="treatmentCount">
            Treatments
        </span>

    </div>

</div>



<!-- =========================================================
     TABLE CARD
========================================================= -->

<div class="treatment-table-card">


<!-- =========================================================
     TABLE HEADER
========================================================= -->

<div class="treatment-table-header">

    <div class="treatment-table-heading">

        <h3>

            <i class="fa fa-clipboard-list"></i>

            Treatment Records

        </h3>

        <span>
            Search, view, edit or delete treatment records.
        </span>

    </div>


    <div style="display:flex; align-items:center; gap:10px;">

        <div class="treatment-search">

            <i class="fa fa-search"></i>

            <input
                type="text"
                id="treatmentSearch"
                placeholder="Search patient, HBCR number..."
                autocomplete="off"
            >

        </div>


        <a
            href="treatment_form.php"
            class="treatment-add-btn">

            <i class="fa fa-plus"></i>

            Add Treatment

        </a>

    </div>

</div>



<!-- =========================================================
     TABLE
========================================================= -->

<div class="treatment-table-wrapper">

<table class="treatment-list-table">

<thead>

<tr>

    <th>No.</th>

    <th>HBCR No.</th>

    <th>Patient Name</th>

    <th>Treatment Context</th>

    <th>Before Registration</th>

    <th>Modality</th>

    <th>Intention</th>

    <th>Role</th>

    <th>Start Date</th>

    <th>End Date</th>

    <th>ECOG</th>

    <th>Status</th>

    <th>Actions</th>

</tr>

</thead>


<tbody id="treatmentTable">


<?php

$sql = "
SELECT
    treatment.*,
    patients.hbcr_no,
    patients.first_name,
    patients.last_name

FROM treatment

INNER JOIN patients
    ON treatment.patient_id = patients.id

ORDER BY treatment.created_at DESC
";

$result = mysqli_query($conn, $sql);


if ($result && mysqli_num_rows($result) > 0) {

    $serial = 1;

    while ($row = mysqli_fetch_assoc($result)) {


        /* =============================================
           PATIENT NAME
        ============================================= */

        $firstName =
            $row['first_name'] ?? '';

        $lastName =
            $row['last_name'] ?? '';

        $patientName =
            trim(
                $firstName . ' ' . $lastName
            );


        /* =============================================
           INITIAL
        ============================================= */

        $initial =
            !empty($firstName)
                ? strtoupper(
                    substr($firstName, 0, 1)
                )
                : 'P';


        /* =============================================
           STATUS
        ============================================= */

        $status =
            trim(
                $row['status'] ?? ''
            );


        if (
            strtolower($status)
            === 'active'
        ) {

            $statusClass =
                'treatment-status-active';

        } elseif (
            strtolower($status)
            === 'completed'
        ) {

            $statusClass =
                'treatment-status-completed';

        } elseif (
            strtolower($status)
            === 'stopped'
        ) {

            $statusClass =
                'treatment-status-stopped';

        } else {

            $statusClass =
                'treatment-status-other';

        }

?>

<tr>


<!-- NO -->

<td>

<span class="treatment-id">

<?php
echo $serial++;
?>

</span>

</td>



<!-- HBCR -->

<td>

<span class="treatment-hbcr">

<?php
echo htmlspecialchars(
    $row['hbcr_no'] ?? '-'
);
?>

</span>

</td>



<!-- PATIENT -->

<td>

<div class="treatment-patient">

<div class="treatment-avatar">

<?php
echo htmlspecialchars($initial);
?>

</div>

<span class="treatment-patient-name">

<?php
echo htmlspecialchars(
    $patientName ?: 'Unknown Patient'
);
?>

</span>

</div>

</td>



<!-- CONTEXT -->

<td>

<span class="treatment-text">

<?php
echo htmlspecialchars(
    $row['treatment_context'] ?? '-'
);
?>

</span>

</td>



<!-- BEFORE REGISTRATION -->

<td>

<span class="treatment-text">

<?php
echo htmlspecialchars(
    $row['treatment_given_before_registration'] ?? '-'
);
?>

</span>

</td>



<!-- MODALITY -->

<td>

<span class="treatment-text">

<?php
echo htmlspecialchars(
    $row['treatment_modality'] ?? '-'
);
?>

</span>

</td>



<!-- INTENTION -->

<td>

<span class="treatment-text">

<?php
echo htmlspecialchars(
    $row['intention_to_treat'] ?? '-'
);
?>

</span>

</td>



<!-- ROLE -->

<td>

<span class="treatment-text">

<?php
echo htmlspecialchars(
    $row['treatment_role'] ?? '-'
);
?>

</span>

</td>



<!-- START -->

<td>

<span class="treatment-text">

<?php
echo htmlspecialchars(
    $row['start_date'] ?? '-'
);
?>

</span>

</td>



<!-- END -->

<td>

<span class="treatment-text">

<?php
echo htmlspecialchars(
    $row['end_date'] ?? '-'
);
?>

</span>

</td>



<!-- ECOG -->

<td>

<span class="treatment-text">

<?php
echo htmlspecialchars(
    $row['performance_status_ecog'] ?? '-'
);
?>

</span>

</td>



<!-- STATUS -->

<td>

<span class="treatment-badge <?php echo $statusClass; ?>">

<?php
echo htmlspecialchars(
    $status ?: 'Not Added'
);
?>

</span>

</td>



<!-- ACTIONS -->

<td>

<div class="treatment-actions">


<!-- EDIT -->

<a
    href="edit_treatment.php?id=<?php echo (int)$row['id']; ?>"
    class="treatment-action-btn treatment-action-edit"
    title="Edit Treatment"
>

    <i class="fa fa-edit"></i>

    <span>Edit</span>

</a>



<!-- DELETE -->

<a
    href="delete_treatment.php?id=<?php echo (int)$row['id']; ?>"
    class="treatment-action-btn treatment-action-delete"
    title="Delete Treatment"
    onclick="return confirm('Are you sure you want to delete this treatment record?');"
>

    <i class="fa fa-trash"></i>

    <span>Delete</span>

</a>


</div>

</td>


</tr>


<?php

    }

} else {

?>

<tr>

<td
    colspan="13"
    class="treatment-empty"
>

<i class="fa fa-folder-open"></i>

No Treatment Records Found

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

/* =========================================================
   TREATMENT SEARCH
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const search =
            document.getElementById(
                "treatmentSearch"
            );

        const table =
            document.getElementById(
                "treatmentTable"
            );

        const count =
            document.getElementById(
                "treatmentCount"
            );


        function updateTreatmentCount() {

            const rows =
                table.querySelectorAll("tr");

            let visibleCount = 0;


            rows.forEach(
                function (row) {

                    if (
                        row.style.display !==
                        "none"
                    ) {

                        if (
                            row.querySelector(
                                ".treatment-patient-name"
                            )
                        ) {

                            visibleCount++;

                        }

                    }

                }
            );


            count.innerHTML =
                '<i class="fa fa-capsules"></i> ' +
                visibleCount +
                ' Treatment' +
                (
                    visibleCount === 1
                        ? ''
                        : 's'
                );

        }


        search.addEventListener(
            "keyup",
            function () {

                const value =
                    this.value
                        .toLowerCase()
                        .trim();


                const rows =
                    table.querySelectorAll("tr");


                rows.forEach(
                    function (row) {

                        const text =
                            row.innerText
                                .toLowerCase();


                        if (
                            text.includes(value)
                        ) {

                            row.style.display =
                                "";

                        } else {

                            row.style.display =
                                "none";

                        }

                    }
                );


                updateTreatmentCount();

            }
        );


        updateTreatmentCount();

    }
);

</script>


<?php
include("../includes/footer.php");
?>
<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");
?>

<style>

/* =========================================================
   PATIENT LIST PAGE
   HBCR PROFESSIONAL LIGHT MEDICAL UI
========================================================= */

.patient-list-page {
    padding: 22px 24px 35px;
}


/* =========================================================
   PAGE TOP HEADER
========================================================= */

.patient-page-header {
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


.patient-page-title {
    display: flex;
    align-items: center;
    gap: 13px;
}


.patient-page-icon {
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


.patient-page-title h2 {
    margin: 0;

    color: #183b37;

    font-size: 19px;
    font-weight: 700;
}


.patient-page-title p {
    margin: 4px 0 0;

    color: #82918e;

    font-size: 10px;
}


.patient-count {
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
   MAIN TABLE CARD
========================================================= */

.patient-table-card {
    background: #ffffff;

    border: 1px solid #dfe8e5;

    border-radius: 14px;

    overflow: hidden;

    box-shadow:
        0 5px 20px rgba(30, 70, 60, 0.06);
}


/* =========================================================
   TABLE CARD HEADER
========================================================= */

.patient-table-header {
    padding: 16px 20px;

    border-bottom: 1px solid #e8efed;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;
}


.patient-table-heading {
    display: flex;

    flex-direction: column;

    gap: 3px;
}


.patient-table-heading h3 {
    margin: 0;

    color: #243e39;

    font-size: 14px;

    font-weight: 700;
}


.patient-table-heading span {
    color: #8a9996;

    font-size: 10px;
}


/* =========================================================
   SEARCH
========================================================= */

.patient-search {
    position: relative;

    width: 280px;
}


.patient-search i {
    position: absolute;

    left: 12px;
    top: 50%;

    transform: translateY(-50%);

    color: #82938f;

    font-size: 12px;

    pointer-events: none;
}


.patient-search input {
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


.patient-search input:hover {
    border-color: #b9d0c9;
}


.patient-search input:focus {
    background: #ffffff;

    border-color: #78b9ad;

    box-shadow:
        0 0 0 3px rgba(8,112,95,.08);
}


/* =========================================================
   TABLE WRAPPER
========================================================= */

.patient-table-wrapper {
    width: 100%;

    overflow-x: auto;
}


/* =========================================================
   PROFESSIONAL TABLE
========================================================= */

.patient-list-table {
    width: 100%;

    border-collapse: separate;

    border-spacing: 0;

    min-width: 900px;
}


/* TABLE HEAD */

.patient-list-table thead th {
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


/* TABLE BODY */

.patient-list-table tbody td {
    padding: 12px 13px;

    color: #526560;

    font-size: 11px;

    border-bottom: 1px solid #edf1ef;

    vertical-align: middle;

    background: #ffffff;
}


.patient-list-table tbody tr {
    transition: .15s ease;
}


.patient-list-table tbody tr:hover td {
    background: #f6faf8;
}


/* REMOVE LAST BORDER */

.patient-list-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   ID
========================================================= */

.patient-id {
    color: #8a9996;

    font-size: 10px;

    font-weight: 600;
}


/* =========================================================
   HBCR NUMBER
========================================================= */

.hbcr-number {
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

.patient-name-cell {
    display: flex;

    align-items: center;

    gap: 9px;

    min-width: 150px;
}


.patient-avatar {
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


.patient-name-text {
    color: #344b47;

    font-size: 11px;

    font-weight: 600;
}


/* =========================================================
   AGE / GENDER
========================================================= */

.patient-basic-text {
    color: #596c67;

    font-size: 11px;
}


/* =========================================================
   STAGE BADGES
========================================================= */

.stage-badge {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 62px;

    padding: 5px 8px;

    border-radius: 6px;

    font-size: 9px;

    font-weight: 700;

    background: #f4eeee;

    color: #93666c;

    border: 1px solid #eadbdd;
}


.stage-not-added {
    background: #f4f6f5;

    color: #8a9693;

    border-color: #e3e8e6;
}


/* =========================================================
   ACTION BUTTON GROUP
========================================================= */

.patient-actions {
    display: inline-flex;

    align-items: center;

    gap: 5px;

    white-space: nowrap;
}


/* COMMON BUTTON */

.patient-action-btn {
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


.patient-action-btn i {
    font-size: 10px;
}


.patient-action-btn:hover {
    transform: translateY(-1px);

    box-shadow:
        0 3px 8px rgba(30,60,50,.08);
}


/* VIEW */

.patient-action-view {
    color: #08705f;

    background: #eaf6f2;

    border-color: #d3ebe4;
}


.patient-action-view:hover {
    color: #075c50;

    background: #dcefe9;
}


/* EDIT */

.patient-action-edit {
    color: #98702d;

    background: #fff7e9;

    border-color: #efdfc3;
}


.patient-action-edit:hover {
    color: #7d591e;

    background: #ffefd4;
}


/* DELETE */

.patient-action-delete {
    color: #b65358;

    background: #fff1f1;

    border-color: #f0d6d6;
}


.patient-action-delete:hover {
    color: #963e43;

    background: #ffe4e4;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.patient-empty {
    text-align: center;

    padding: 45px 20px !important;

    color: #8c9a97 !important;

    font-size: 12px !important;
}


.patient-empty i {
    display: block;

    margin-bottom: 8px;

    color: #b2c0bc;

    font-size: 25px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 850px) {

    .patient-list-page {
        padding: 15px;
    }

    .patient-page-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .patient-table-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .patient-search {
        width: 100%;
    }

}

</style>


<div class="main-content">

    <div class="patient-list-page">


        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="patient-page-header">

            <div class="patient-page-title">

                <div class="patient-page-icon">
                    <i class="fa fa-users"></i>
                </div>

                <div>

                    <h2>Registered Patients</h2>

                    <p>
                        View and manage all patients registered in the HBCR system.
                    </p>

                </div>

            </div>


            <div class="patient-count">

                <i class="fa fa-user-injured"></i>

                <span id="patientCount">
                    Patients
                </span>

            </div>

        </div>



        <!-- =====================================================
             TABLE CARD
        ====================================================== -->

        <div class="patient-table-card">


            <!-- TABLE HEADER -->

            <div class="patient-table-header">

                <div class="patient-table-heading">

                    <h3>
                        <i class="fa fa-clipboard-list"></i>
                        Patient Records
                    </h3>

                    <span>
                        Search, view, edit or delete registered patient records.
                    </span>

                </div>


                <!-- SEARCH -->

                <div class="patient-search">

                    <i class="fa fa-search"></i>

                    <input
                        type="text"
                        id="search"
                        placeholder="Search patient name, HBCR number..."
                        autocomplete="off"
                    >

                </div>

            </div>



            <!-- =================================================
                 TABLE
            ================================================== -->

            <div class="patient-table-wrapper">

                <table class="patient-list-table">


                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>HBCR No.</th>

                            <th>Patient Name</th>

                            <th>Age</th>

                            <th>Gender</th>

                            <th>Cancer Site</th>

                            <th>Stage</th>

                            <th>Actions</th>

                        </tr>

                    </thead>



                    <tbody id="patientTable">


                    <?php

                    $sql = "
                    SELECT 
                        patients.*,
                        diagnosis.primary_site,
                        diagnosis.stage
                    FROM patients
                    LEFT JOIN diagnosis
                        ON patients.id = diagnosis.patient_id
                    ORDER BY patients.id DESC
                    ";

                    $result = mysqli_query($conn, $sql);


                    if ($result && mysqli_num_rows($result) > 0) {

                        $serial = 1;


                        while ($row = mysqli_fetch_assoc($result)) {

                            /* Patient name */

                            $firstName = $row['first_name'] ?? '';
                            $lastName  = $row['last_name'] ?? '';

                            $fullName = trim(
                                $firstName . " " . $lastName
                            );


                            /* Initial */

                            $initial = !empty($firstName)
                                ? strtoupper(substr($firstName, 0, 1))
                                : "P";


                            /* Stage */

                            $stage = !empty($row['stage'])
                                ? $row['stage']
                                : "Not Added";

                            ?>



                            <tr>


                                <!-- ID -->

                                <td>

                                    <span class="patient-id">

                                        <?php echo $serial++; ?>

                                    </span>

                                </td>



                                <!-- HBCR -->

                                <td>

                                    <span class="hbcr-number">

                                        <?php
                                        echo htmlspecialchars(
                                            $row['hbcr_no'] ?? '-'
                                        );
                                        ?>

                                    </span>

                                </td>



                                <!-- NAME -->

                                <td>

                                    <div class="patient-name-cell">

                                        <div class="patient-avatar">

                                            <?php echo htmlspecialchars($initial); ?>

                                        </div>


                                        <span class="patient-name-text">

                                            <?php
                                            echo htmlspecialchars(
                                                $fullName ?: 'Unknown Patient'
                                            );
                                            ?>

                                        </span>

                                    </div>

                                </td>



                                <!-- AGE -->

                                <td>

                                    <span class="patient-basic-text">

                                        <?php
                                        echo htmlspecialchars(
                                            $row['age'] ?? '-'
                                        );
                                        ?>

                                    </span>

                                </td>



                                <!-- GENDER -->

                                <td>

                                    <span class="patient-basic-text">

                                        <?php
                                        echo htmlspecialchars(
                                            $row['gender'] ?? '-'
                                        );
                                        ?>

                                    </span>

                                </td>



                                <!-- CANCER SITE -->

                                <td>

                                    <span class="patient-basic-text">

                                        <?php
                                        echo htmlspecialchars(
                                            $row['primary_site'] ?? 'Not Added'
                                        );
                                        ?>

                                    </span>

                                </td>



                                <!-- STAGE -->

                                <td>

                                    <?php if ($stage === 'Not Added') { ?>

                                        <span class="stage-badge stage-not-added">

                                            Not Added

                                        </span>

                                    <?php } else { ?>

                                        <span class="stage-badge">

                                            <?php
                                            echo htmlspecialchars($stage);
                                            ?>

                                        </span>

                                    <?php } ?>

                                </td>



                                <!-- ACTIONS -->

                                <td>

                                    <div class="patient-actions">


                                        <!-- VIEW -->

                                        <a
                                            href="view_patient.php?id=<?php echo (int)$row['id']; ?>"
                                            class="patient-action-btn patient-action-view"
                                            title="View Patient"
                                        >

                                            <i class="fa fa-eye"></i>

                                            <span>View</span>

                                        </a>



                                        <!-- EDIT -->

                                        <a
                                            href="edit_patient.php?id=<?php echo (int)$row['id']; ?>"
                                            class="patient-action-btn patient-action-edit"
                                            title="Edit Patient"
                                        >

                                            <i class="fa fa-edit"></i>

                                            <span>Edit</span>

                                        </a>



                                        <!-- DELETE -->

                                        <a
                                            href="delete_patient.php?id=<?php echo (int)$row['id']; ?>"
                                            class="patient-action-btn patient-action-delete"
                                            title="Delete Patient"
                                            onclick="return confirm('Are you sure you want to delete this patient?');"
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
                                colspan="8"
                                class="patient-empty"
                            >

                                <i class="fa fa-folder-open"></i>

                                No Patients Found

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
   PATIENT SEARCH
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const search = document.getElementById("search");

    const table = document.getElementById("patientTable");

    const count = document.getElementById("patientCount");


    function updatePatientCount() {

        const rows = table.querySelectorAll("tr");

        let visibleCount = 0;


        rows.forEach(function (row) {

            if (row.style.display !== "none") {

                if (row.querySelector(".patient-name-text")) {

                    visibleCount++;

                }

            }

        });


        count.innerHTML =
            '<i class="fa fa-users"></i> ' +
            visibleCount +
            ' Patient' +
            (visibleCount === 1 ? '' : 's');

    }


    search.addEventListener("keyup", function () {

        const value = this.value
            .toLowerCase()
            .trim();


        const rows = table.querySelectorAll("tr");


        rows.forEach(function (row) {

            const text = row.innerText.toLowerCase();


            if (text.includes(value)) {

                row.style.display = "";

            } else {

                row.style.display = "none";

            }

        });


        updatePatientCount();

    });


    updatePatientCount();

});

</script>


<?php
include("../includes/footer.php");
?>
<?php

include("../config/database.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("Invalid patient ID.");
}


/* =========================================
   PATIENT DETAILS
========================================= */

$sql = "SELECT * FROM patients WHERE id = $id";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Patient not found.");
}

$patient = mysqli_fetch_assoc($result);


/* =========================================
   DIAGNOSIS DETAILS
========================================= */

$diagnosis_sql = "
    SELECT *
    FROM diagnosis
    WHERE patient_id = $id
    ORDER BY id DESC
";

$diagnosis_result = mysqli_query($conn, $diagnosis_sql);

$diagnosis_records = [];

if ($diagnosis_result) {

    while ($row = mysqli_fetch_assoc($diagnosis_result)) {
        $diagnosis_records[] = $row;
    }

}


/* =========================================
   HELPER
========================================= */

function displayValue($value)
{
    if ($value === null || trim((string)$value) === '') {
        return '<span class="not-added">Not Added</span>';
    }

    return htmlspecialchars($value);
}


/* =========================================
   FULL NAME
========================================= */

$full_name = trim(
    ($patient['first_name'] ?? '') . ' ' .
    ($patient['middle_name'] ?? '') . ' ' .
    ($patient['last_name'] ?? '')
);


/* =========================================
   HEADER + SIDEBAR
========================================= */

include("../includes/header.php");
include("../includes/sidebar.php");

?>

<div class="main-content patient-view-page">


<!-- =========================================
     PAGE HEADER
========================================= -->

<div class="patient-topbar">

    <div>

        <div class="breadcrumb-text">
            Patient Management / Patient Details
        </div>

        <h2>
            <i class="fa fa-user-circle"></i>
            Patient Dashboard
        </h2>

        <p>
            Complete Hospital Based Cancer Registry Patient Record
        </p>

    </div>

    <div class="top-actions">

    <button onclick="window.print()" class="btn btn-outline-secondary">
        <i class="fa fa-print"></i>
        Print
    </button>

    <a href="download_patient_pdf.php?id=<?php echo $id; ?>"
       class="btn btn-success"
       target="_blank">
        <i class="fa fa-download"></i>
        Download PDF
    </a>

    <a href="patient_list.php" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i>
        Back
    </a>

</div>
</div>


<!-- =========================================
     PATIENT PROFILE
========================================= -->

<div class="patient-profile-card">

    <div class="patient-avatar-large">
        <i class="fa fa-user"></i>
    </div>


    <div class="patient-profile-info">

        <div class="patient-name-line">

            <h2>
                <?php echo displayValue($full_name); ?>
            </h2>

            <span class="status-badge">
                <i class="fa fa-circle"></i>
                Registered
            </span>

        </div>


        <div class="patient-identifiers">

            <div>
                <span>HBCR Number</span>
                <strong>
                    <?php echo displayValue($patient['hbcr_no'] ?? ''); ?>
                </strong>
            </div>

            <div>
                <span>Hospital Registration No.</span>
                <strong>
                    <?php echo displayValue($patient['hospital_no'] ?? ''); ?>
                </strong>
            </div>

            <div>
                <span>Gender</span>
                <strong>
                    <?php echo displayValue($patient['gender'] ?? ''); ?>
                </strong>
            </div>

            <div>
                <span>Age</span>
                <strong>
                    <?php echo displayValue($patient['age'] ?? ''); ?>
                </strong>
            </div>

        </div>

    </div>


    <div class="profile-actions">

        <a href="patient_registration.php?id=<?php echo $id; ?>"
           class="btn btn-primary">

            <i class="fa fa-edit"></i>
            Edit Patient

        </a>

    </div>

</div>


<!-- =========================================
     QUICK SUMMARY
========================================= -->

<div class="summary-grid">


    <div class="summary-card">

        <div class="summary-icon">
            <i class="fa fa-calendar"></i>
        </div>

        <div>
            <span>Date of Birth</span>

            <strong>
                <?php echo displayValue($patient['dob'] ?? ''); ?>
            </strong>
        </div>

    </div>


    <div class="summary-card">

        <div class="summary-icon">
            <i class="fa fa-phone"></i>
        </div>

        <div>
            <span>Mobile</span>

            <strong>
                <?php echo displayValue($patient['mobile'] ?? ''); ?>
            </strong>
        </div>

    </div>


    <div class="summary-card">

        <div class="summary-icon">
            <i class="fa fa-map-marker-alt"></i>
        </div>

        <div>
            <span>Location</span>

            <strong>
                <?php echo displayValue($patient['city'] ?? ''); ?>
            </strong>
        </div>

    </div>


    <div class="summary-card">

        <div class="summary-icon">
            <i class="fa fa-stethoscope"></i>
        </div>

        <div>
            <span>Diagnosis Records</span>

            <strong>
                <?php echo count($diagnosis_records); ?>
            </strong>
        </div>

    </div>


</div>


<!-- =========================================
     PERSONAL INFORMATION
========================================= -->

<div class="professional-card">

    <div class="section-heading">

        <div>
            <i class="fa fa-user"></i>

            <div>
                <h3>Personal Information</h3>
                <p>Patient identification and demographic details</p>
            </div>
        </div>

    </div>


    <div class="details-grid">


        <div class="detail-box">
            <label>First Name</label>
            <strong>
                <?php echo displayValue($patient['first_name'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Middle Name</label>
            <strong>
                <?php echo displayValue($patient['middle_name'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Last Name</label>
            <strong>
                <?php echo displayValue($patient['last_name'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Age</label>
            <strong>
                <?php echo displayValue($patient['age'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Date of Birth</label>
            <strong>
                <?php echo displayValue($patient['dob'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Gender</label>
            <strong>
                <?php echo displayValue($patient['gender'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Marital Status</label>
            <strong>
                <?php echo displayValue($patient['marital_status'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Hospital Registration No.</label>
            <strong>
                <?php echo displayValue($patient['hospital_no'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Centre Code</label>
            <strong>
                <?php echo displayValue($patient['centre_code'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Reporting Institution</label>
            <strong>
                <?php echo displayValue($patient['institution'] ?? ''); ?>
            </strong>
        </div>


        <div class="detail-box">
            <label>Reporting Date</label>
            <strong>
                <?php echo displayValue($patient['report_date'] ?? ''); ?>
            </strong>
        </div>


    </div>

</div>


<!-- =========================================
     ADDRESS & CONTACT
========================================= -->

<div class="professional-card">

    <div class="section-heading">

        <div>

            <i class="fa fa-location-dot"></i>

            <div>
                <h3>Address & Contact Information</h3>
                <p>Patient residential and communication details</p>
            </div>

        </div>

    </div>


    <div class="details-grid">


        <div class="detail-box detail-wide">

            <label>Address</label>

            <strong>
                <?php echo displayValue($patient['address'] ?? ''); ?>
            </strong>

        </div>


        <div class="detail-box">

            <label>City</label>

            <strong>
                <?php echo displayValue($patient['city'] ?? ''); ?>
            </strong>

        </div>


        <div class="detail-box">

            <label>District</label>

            <strong>
                <?php echo displayValue($patient['district'] ?? ''); ?>
            </strong>

        </div>


        <div class="detail-box">

            <label>State</label>

            <strong>
                <?php echo displayValue($patient['state'] ?? ''); ?>
            </strong>

        </div>


        <div class="detail-box">

            <label>PIN</label>

            <strong>
                <?php echo displayValue($patient['pin'] ?? ''); ?>
            </strong>

        </div>


        <div class="detail-box">

            <label>Mobile</label>

            <strong>
                <?php echo displayValue($patient['mobile'] ?? ''); ?>
            </strong>

        </div>


        <div class="detail-box">

            <label>Email</label>

            <strong>
                <?php echo displayValue($patient['email'] ?? ''); ?>
            </strong>

        </div>


    </div>

</div>


<!-- =========================================
     HABITS & COMORBIDITIES
========================================= -->

<div class="professional-card">

    <div class="section-heading">

        <div>

            <i class="fa fa-heart-pulse"></i>

            <div>
                <h3>Habits & Co-morbidities</h3>
                <p>Lifestyle risk factors and medical conditions</p>
            </div>

        </div>

    </div>


    <div class="details-grid">


        <div class="detail-box">
            <label>Smoking</label>
            <strong><?php echo displayValue($patient['smoking'] ?? ''); ?></strong>
        </div>


        <div class="detail-box">
            <label>Smokeless Tobacco</label>
            <strong><?php echo displayValue($patient['smokeless'] ?? ''); ?></strong>
        </div>


        <div class="detail-box">
            <label>Alcohol</label>
            <strong><?php echo displayValue($patient['alcohol'] ?? ''); ?></strong>
        </div>


        <div class="detail-box">
            <label>Betel Nut</label>
            <strong><?php echo displayValue($patient['betelnut'] ?? ''); ?></strong>
        </div>


        <div class="detail-box">
            <label>Height</label>
            <strong><?php echo displayValue($patient['height'] ?? ''); ?> cm</strong>
        </div>


        <div class="detail-box">
            <label>Weight</label>
            <strong><?php echo displayValue($patient['weight'] ?? ''); ?> kg</strong>
        </div>


        <div class="detail-box">
            <label>Diabetes</label>
            <strong><?php echo displayValue($patient['diabetes'] ?? ''); ?></strong>
        </div>


        <div class="detail-box">
            <label>Hypertension</label>
            <strong><?php echo displayValue($patient['hypertension'] ?? ''); ?></strong>
        </div>


        <div class="detail-box">
            <label>Tuberculosis</label>
            <strong><?php echo displayValue($patient['tb'] ?? ''); ?></strong>
        </div>


        <div class="detail-box">
            <label>COPD</label>
            <strong><?php echo displayValue($patient['copd'] ?? ''); ?></strong>
        </div>


        <div class="detail-box">
            <label>HIV</label>
            <strong><?php echo displayValue($patient['hiv'] ?? ''); ?></strong>
        </div>


        <div class="detail-box detail-wide">

            <label>Family History</label>

            <strong>
                <?php echo displayValue($patient['family_history'] ?? ''); ?>
            </strong>

        </div>


    </div>

</div>


<!-- =========================================
     DIAGNOSIS
========================================= -->

<div class="professional-card">

    <div class="section-heading">

        <div>

            <i class="fa fa-stethoscope"></i>

            <div>
                <h3>Diagnosis History</h3>
                <p>Cancer diagnosis and staging information</p>
            </div>

        </div>


        <span class="record-count">
            <?php echo count($diagnosis_records); ?> Record(s)
        </span>

    </div>


    <?php if (count($diagnosis_records) > 0): ?>


        <?php foreach ($diagnosis_records as $diagnosis): ?>

        <div class="diagnosis-record">


            <div class="diagnosis-header">

                <strong>
                    <i class="fa fa-calendar"></i>

                    Diagnosis Date:

                    <?php echo displayValue($diagnosis['diagnosis_date'] ?? ''); ?>

                </strong>

            </div>


            <div class="details-grid">


                <div class="detail-box">

                    <label>Primary Site</label>

                    <strong>
                        <?php echo displayValue($diagnosis['primary_site'] ?? ''); ?>
                    </strong>

                </div>


                <div class="detail-box">

                    <label>Histology</label>

                    <strong>
                        <?php echo displayValue($diagnosis['histology'] ?? ''); ?>
                    </strong>

                </div>


                <div class="detail-box">

                    <label>Stage</label>

                    <strong>
                        <?php echo displayValue($diagnosis['stage'] ?? ''); ?>
                    </strong>

                </div>


                <div class="detail-box">

                    <label>TNM Stage</label>

                    <strong>
                        <?php echo displayValue($diagnosis['tnm_stage'] ?? ''); ?>
                    </strong>

                </div>


            </div>


        </div>

        <?php endforeach; ?>


    <?php else: ?>


        <div class="empty-record">

            <i class="fa fa-file-medical"></i>

            <p>No diagnosis has been added for this patient.</p>

        </div>


    <?php endif; ?>

</div>


<!-- =========================================
     FOOTER ACTIONS
========================================= -->

<div class="patient-footer-actions">

    <a href="patient_list.php" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i>
        Back to Patient List
    </a>


    <a href="patient_registration.php?id=<?php echo $id; ?>"
       class="btn btn-primary">

        <i class="fa fa-edit"></i>
        Edit Patient

    </a>


    <button onclick="window.print()" class="btn btn-success">

        <i class="fa fa-print"></i>
        Print Patient Summary

    </button>

</div>


</div>


<!-- =========================================
     PROFESSIONAL PAGE CSS
========================================= -->

<style>

.patient-view-page {
    background: #f4f8f7;
}


/* TOP BAR */

.patient-topbar {

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

}

.breadcrumb-text {

    font-size:12px;

    color:#7b8c8a;

    margin-bottom:5px;

}

.patient-topbar h2 {

    margin:0;

    color:#174542;

    font-size:28px;

    font-weight:700;

}

.patient-topbar h2 i {

    color:#0f766e;

}

.patient-topbar p {

    margin:5px 0 0;

    color:#7b8c8a;

    font-size:13px;

}

.top-actions {

    display:flex;

    gap:8px;

}


/* PROFILE */

.patient-profile-card {

    background:white;

    border:1px solid #dce9e7;

    border-radius:16px;

    padding:25px;

    display:flex;

    align-items:center;

    gap:20px;

    margin-bottom:20px;

    box-shadow:0 5px 18px rgba(15,95,90,.07);

}

.patient-avatar-large {

    width:80px;

    height:80px;

    border-radius:50%;

    background:linear-gradient(135deg,#0f766e,#16a39a);

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:32px;

    flex-shrink:0;

}

.patient-profile-info {

    flex:1;

}

.patient-name-line {

    display:flex;

    align-items:center;

    gap:12px;

    flex-wrap:wrap;

}

.patient-name-line h2 {

    margin:0;

    color:#203d3a;

    font-size:24px;

}

.status-badge {

    background:#e4f6f2;

    color:#0f766e;

    border-radius:20px;

    padding:5px 11px;

    font-size:11px;

    font-weight:600;

}

.status-badge i {

    font-size:7px;

}

.patient-identifiers {

    display:flex;

    flex-wrap:wrap;

    gap:25px;

    margin-top:12px;

}

.patient-identifiers span {

    display:block;

    color:#879592;

    font-size:10px;

    text-transform:uppercase;

}

.patient-identifiers strong {

    display:block;

    color:#344b48;

    font-size:13px;

    margin-top:2px;

}


/* SUMMARY */

.summary-grid {

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-bottom:20px;

}

.summary-card {

    background:white;

    border:1px solid #dce9e7;

    border-radius:12px;

    padding:17px;

    display:flex;

    align-items:center;

    gap:12px;

}

.summary-icon {

    width:42px;

    height:42px;

    border-radius:10px;

    background:#e6f5f2;

    color:#0f766e;

    display:flex;

    align-items:center;

    justify-content:center;

}

.summary-card span {

    display:block;

    font-size:10px;

    color:#859390;

    text-transform:uppercase;

}

.summary-card strong {

    display:block;

    margin-top:3px;

    color:#263d3a;

    font-size:13px;

}


/* PROFESSIONAL CARD */

.professional-card {

    background:white;

    border:1px solid #dce9e7;

    border-radius:15px;

    margin-bottom:20px;

    overflow:hidden;

    box-shadow:0 4px 15px rgba(15,95,90,.05);

}

.section-heading {

    padding:17px 20px;

    border-bottom:1px solid #e5eeee;

    display:flex;

    justify-content:space-between;

    align-items:center;

}

.section-heading > div {

    display:flex;

    align-items:center;

    gap:12px;

}

.section-heading > div > i {

    width:38px;

    height:38px;

    border-radius:10px;

    background:#e7f5f2;

    color:#0f766e;

    display:flex;

    align-items:center;

    justify-content:center;

}

.section-heading h3 {

    margin:0;

    color:#244441;

    font-size:16px;

}

.section-heading p {

    margin:3px 0 0;

    color:#8a9896;

    font-size:11px;

}

.record-count {

    background:#e7f5f2;

    color:#0f766e;

    padding:5px 10px;

    border-radius:15px;

    font-size:11px;

}


/* DETAILS */

.details-grid {

    display:grid;

    grid-template-columns:repeat(3,1fr);

}

.detail-box {

    padding:16px 20px;

    border-bottom:1px solid #edf2f1;

}

.detail-box label {

    display:block;

    color:#8a9896;

    font-size:10px;

    text-transform:uppercase;

    letter-spacing:.3px;

    margin-bottom:5px;

}

.detail-box strong {

    color:#263d3a;

    font-size:13px;

    font-weight:500;

}

.detail-wide {

    grid-column:span 2;

}

.not-added {

    color:#a8b3b1;

    font-weight:400;

}


/* DIAGNOSIS */

.diagnosis-record {

    margin:18px;

    border:1px solid #dce9e7;

    border-radius:12px;

    overflow:hidden;

}

.diagnosis-header {

    background:#f0f8f6;

    color:#0f766e;

    padding:12px 18px;

    font-size:12px;

}

.diagnosis-record .details-grid {

    grid-template-columns:repeat(4,1fr);

}


/* EMPTY */

.empty-record {

    text-align:center;

    padding:40px;

    color:#8c9a98;

}

.empty-record i {

    font-size:30px;

    color:#a7ccc7;

    margin-bottom:10px;

}

.empty-record p {

    margin:0;

    font-size:13px;

}


/* FOOTER BUTTONS */

.patient-footer-actions {

    display:flex;

    justify-content:flex-end;

    gap:10px;

    margin:10px 0 30px;

}


/* RESPONSIVE */

@media(max-width:1000px) {

    .summary-grid {

        grid-template-columns:repeat(2,1fr);

    }

    .details-grid {

        grid-template-columns:repeat(2,1fr);

    }

    .diagnosis-record .details-grid {

        grid-template-columns:repeat(2,1fr);

    }

}


@media(max-width:700px) {

    .patient-topbar {

        flex-direction:column;

        align-items:flex-start;

        gap:15px;

    }

    .patient-profile-card {

        flex-direction:column;

        align-items:flex-start;

    }

    .summary-grid,

    .details-grid,

    .diagnosis-record .details-grid {

        grid-template-columns:1fr;

    }

    .detail-wide {

        grid-column:span 1;

    }

    .patient-footer-actions,

    .top-actions {

        flex-direction:column;

        width:100%;

    }

}


/* PRINT */

@media print {

    .sidebar,

    .header,

    .top-actions,

    .profile-actions,

    .patient-footer-actions {

        display:none !important;

    }

    .main-content {

        margin:0 !important;

        padding:0 !important;

    }

    .professional-card,

    .patient-profile-card,

    .summary-card {

        box-shadow:none !important;

    }

}

</style>


<?php
include("../includes/footer.php");
?>
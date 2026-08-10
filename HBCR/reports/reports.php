<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");


/* =====================================================
   BASIC COUNTS
===================================================== */

$totalPatients = 0;
$totalDiagnosis = 0;
$totalFollowups = 0;

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients");
if ($result) {
    $totalPatients = mysqli_fetch_assoc($result)['total'];
}

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM diagnosis");
if ($result) {
    $totalDiagnosis = mysqli_fetch_assoc($result)['total'];
}

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM followup");
if ($result) {
    $totalFollowups = mysqli_fetch_assoc($result)['total'];
}


/* =====================================================
   GENDER REPORT
===================================================== */

$genderLabels = [];
$genderValues = [];

$sql = "
SELECT gender, COUNT(*) AS total
FROM patients
GROUP BY gender
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $genderLabels[] = $row['gender'] ?: 'Unknown';
    $genderValues[] = (int)$row['total'];
}


/* =====================================================
   CANCER SITE REPORT
===================================================== */

$siteLabels = [];
$siteValues = [];

$sql = "
SELECT primary_site, COUNT(*) AS total
FROM diagnosis
WHERE primary_site IS NOT NULL
AND primary_site != ''
GROUP BY primary_site
ORDER BY total DESC
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $siteLabels[] = $row['primary_site'];
    $siteValues[] = (int)$row['total'];
}


/* =====================================================
   STAGE REPORT
===================================================== */

$stageLabels = [];
$stageValues = [];

$sql = "
SELECT stage, COUNT(*) AS total
FROM diagnosis
WHERE stage IS NOT NULL
AND stage != ''
GROUP BY stage
ORDER BY total DESC
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $stageLabels[] = $row['stage'];
    $stageValues[] = (int)$row['total'];
}


/* =====================================================
   FOLLOW-UP STATUS REPORT
===================================================== */

$statusLabels = [];
$statusValues = [];

$sql = "
SELECT disease_status AS followup_status, COUNT(*) AS total
FROM followup
WHERE disease_status IS NOT NULL
AND disease_status != ''
GROUP BY disease_status
ORDER BY total DESC
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $statusLabels[] = $row['followup_status'];
    $statusValues[] = (int)$row['total'];
}

?>

<div class="main-content">

    <!-- =====================================================
         REPORT PAGE HEADER
    ===================================================== -->

    <div class="hbcr-report-top">

        <div>
            <div class="hbcr-report-title">
                <i class="fa-solid fa-chart-pie"></i>
                Registry Reports
            </div>

            <div class="hbcr-report-subtitle">
                Hospital Based Cancer Registry – Statistical Summary
            </div>
        </div>

        <div class="hbcr-report-date">
            <i class="fa-regular fa-calendar"></i>
            Registry Overview
        </div>

    </div>


    <!-- =====================================================
         SUMMARY CARDS
    ===================================================== -->

    <div class="hbcr-summary-grid">

        <div class="hbcr-summary-card">

            <div class="hbcr-summary-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="hbcr-summary-content">
                <span>Total Registered Patients</span>

                <strong>
                    <?php echo $totalPatients; ?>
                </strong>
            </div>

        </div>


        <div class="hbcr-summary-card">

            <div class="hbcr-summary-icon">
                <i class="fa-solid fa-stethoscope"></i>
            </div>

            <div class="hbcr-summary-content">
                <span>Total Diagnoses</span>

                <strong>
                    <?php echo $totalDiagnosis; ?>
                </strong>
            </div>

        </div>


        <div class="hbcr-summary-card">

            <div class="hbcr-summary-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <div class="hbcr-summary-content">
                <span>Total Follow-ups</span>

                <strong>
                    <?php echo $totalFollowups; ?>
                </strong>
            </div>

        </div>

    </div>


    <!-- =====================================================
         CHART GRID
    ===================================================== -->

    <div class="hbcr-report-chart-grid">


        <!-- GENDER -->

        <div class="hbcr-report-chart-card">

            <div class="hbcr-chart-heading">

                <div class="hbcr-chart-icon">
                    <i class="fa-solid fa-venus-mars"></i>
                </div>

                <div>
                    <h3>Gender Distribution</h3>
                    <p>Patient distribution by gender</p>
                </div>

            </div>

            <div class="hbcr-chart-body hbcr-pie-chart">
                <canvas id="genderChart"></canvas>
            </div>

        </div>


        <!-- STAGE -->

        <div class="hbcr-report-chart-card">

            <div class="hbcr-chart-heading">

                <div class="hbcr-chart-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>

                <div>
                    <h3>Cancer Stage Distribution</h3>
                    <p>Distribution of recorded cancer stages</p>
                </div>

            </div>

            <div class="hbcr-chart-body hbcr-pie-chart">
                <canvas id="stageChart"></canvas>
            </div>

        </div>


        <!-- CANCER SITE -->

        <div class="hbcr-report-chart-card hbcr-chart-wide">

            <div class="hbcr-chart-heading">

                <div class="hbcr-chart-icon">
                    <i class="fa-solid fa-disease"></i>
                </div>

                <div>
                    <h3>Cancer Site Distribution</h3>
                    <p>Number of diagnosis records by primary cancer site</p>
                </div>

            </div>

            <div class="hbcr-chart-body hbcr-bar-chart">
                <canvas id="siteChart"></canvas>
            </div>

        </div>


        <!-- FOLLOW-UP STATUS -->

        <div class="hbcr-report-chart-card hbcr-chart-wide">

            <div class="hbcr-chart-heading">

                <div class="hbcr-chart-icon">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>

                <div>
                    <h3>Follow-up Patient Status</h3>
                    <p>Current status recorded during follow-up</p>
                </div>

            </div>

            <div class="hbcr-chart-body hbcr-status-area">

                <?php if (count($statusLabels) > 0) { ?>

                    <canvas id="statusChart"></canvas>

                <?php } else { ?>

                    <div class="hbcr-empty-report">

                        <div class="hbcr-empty-icon">
                            <i class="fa-solid fa-clipboard-question"></i>
                        </div>

                        <strong>No Follow-up Status Data</strong>

                        <span>
                            No patient status has been recorded in the follow-up records yet.
                        </span>

                    </div>

                <?php } ?>

            </div>

        </div>


    </div>


    <!-- =====================================================
         REPORT SUMMARY
    ===================================================== -->

    <div class="hbcr-report-summary-card">

        <div class="hbcr-summary-heading">

            <div class="hbcr-chart-icon">
                <i class="fa-solid fa-table-list"></i>
            </div>

            <div>
                <h3>Report Summary</h3>
                <p>Overview of registry records</p>
            </div>

        </div>


        <div class="table-responsive">

            <table class="table hbcr-report-summary-table">

                <thead>

                    <tr>
                        <th>Report</th>
                        <th>Total Records</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>
                            <i class="fa-solid fa-users"></i>
                            Registered Patients
                        </td>

                        <td>
                            <span class="hbcr-total-badge">
                                <?php echo $totalPatients; ?>
                            </span>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <i class="fa-solid fa-stethoscope"></i>
                            Diagnosis Records
                        </td>

                        <td>
                            <span class="hbcr-total-badge">
                                <?php echo $totalDiagnosis; ?>
                            </span>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <i class="fa-solid fa-calendar-check"></i>
                            Follow-up Records
                        </td>

                        <td>
                            <span class="hbcr-total-badge">
                                <?php echo $totalFollowups; ?>
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- =====================================================
     CHART.JS
===================================================== -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const genderLabels = <?php echo json_encode($genderLabels); ?>;
const genderValues = <?php echo json_encode($genderValues); ?>;

const siteLabels = <?php echo json_encode($siteLabels); ?>;
const siteValues = <?php echo json_encode($siteValues); ?>;

const stageLabels = <?php echo json_encode($stageLabels); ?>;
const stageValues = <?php echo json_encode($stageValues); ?>;

const statusLabels = <?php echo json_encode($statusLabels); ?>;
const statusValues = <?php echo json_encode($statusValues); ?>;


/* =====================================================
   COMMON CHART SETTINGS
===================================================== */

const chartFont = {
    family: "Segoe UI, Arial, sans-serif"
};


/* =====================================================
   GENDER
===================================================== */

new Chart(
    document.getElementById("genderChart"),
    {
        type: "doughnut",

        data: {
            labels: genderLabels,

            datasets: [{
                data: genderValues,

                backgroundColor: [
                    "#08a88f",
                    "#1769e0",
                    "#d99a2b",
                    "#8b6fd8"
                ],

                borderWidth: 3,
                borderColor: "#ffffff"
            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: "58%",

            plugins: {

                legend: {
                    position: "bottom",

                    labels: {
                        font: chartFont,
                        boxWidth: 12,
                        padding: 15
                    }
                }
            }
        }
    }
);


/* =====================================================
   CANCER SITE
===================================================== */

new Chart(
    document.getElementById("siteChart"),
    {
        type: "bar",

        data: {

            labels: siteLabels,

            datasets: [{
                label: "Diagnosis Records",

                data: siteValues,

                backgroundColor: "#08a88f",

                borderRadius: 6,

                borderSkipped: false
            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }
            },

            scales: {

                x: {

                    grid: {
                        display: false
                    },

                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    grid: {
                        color: "#edf2f1"
                    }
                }
            }
        }
    }
);


/* =====================================================
   STAGE
===================================================== */

new Chart(
    document.getElementById("stageChart"),
    {
        type: "doughnut",

        data: {

            labels: stageLabels,

            datasets: [{
                data: stageValues,

                backgroundColor: [
                    "#08a88f",
                    "#1769e0",
                    "#d99a2b",
                    "#e85b68",
                    "#8b6fd8",
                    "#4f9d9d"
                ],

                borderWidth: 3,

                borderColor: "#ffffff"
            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: "58%",

            plugins: {

                legend: {

                    position: "bottom",

                    labels: {
                        font: chartFont,
                        boxWidth: 12,
                        padding: 15
                    }
                }
            }
        }
    }
);


/* =====================================================
   FOLLOW-UP STATUS
===================================================== */

<?php if (count($statusLabels) > 0) { ?>

new Chart(
    document.getElementById("statusChart"),
    {
        type: "doughnut",

        data: {

            labels: statusLabels,

            datasets: [{
                data: statusValues,

                backgroundColor: [
                    "#12a474",
                    "#e85b68",
                    "#d99a2b",
                    "#1769e0",
                    "#8b6fd8"
                ],

                borderWidth: 3,

                borderColor: "#ffffff"
            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: "58%",

            plugins: {

                legend: {

                    position: "bottom",

                    labels: {
                        font: chartFont,
                        boxWidth: 12,
                        padding: 15
                    }
                }
            }
        }
    }
);

<?php } ?>

</script>

<?php
include("../includes/footer.php");
?>
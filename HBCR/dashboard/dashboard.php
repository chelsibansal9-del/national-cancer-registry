<?php

include("../config/database.php");


/* =========================================================
   DASHBOARD COUNTS
========================================================= */

$totalPatients = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients")
);

$totalDiagnosis = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM diagnosis")
);

$totalTreatment = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM treatment")
);

$totalFollowup = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM followup")
);


/* =========================================================
   GENDER STATISTICS
========================================================= */

$genderData = [];

$genderQuery = mysqli_query(
    $conn,
    "SELECT gender, COUNT(*) AS total
     FROM patients
     GROUP BY gender"
);

while ($row = mysqli_fetch_assoc($genderQuery)) {
    $genderData[] = $row;
}


/* =========================================================
   CANCER SITE STATISTICS
========================================================= */

$siteData = [];

$siteQuery = mysqli_query(
    $conn,
    "SELECT primary_site, COUNT(*) AS total
     FROM diagnosis
     WHERE primary_site IS NOT NULL
     AND primary_site != ''
     GROUP BY primary_site
     ORDER BY total DESC
     LIMIT 8"
);

while ($row = mysqli_fetch_assoc($siteQuery)) {
    $siteData[] = $row;
}


/* =========================================================
   STAGE STATISTICS
========================================================= */

$stageData = [];

$stageQuery = mysqli_query(
    $conn,
    "SELECT stage, COUNT(*) AS total
     FROM diagnosis
     WHERE stage IS NOT NULL
     AND stage != ''
     GROUP BY stage
     ORDER BY stage"
);

while ($row = mysqli_fetch_assoc($stageQuery)) {
    $stageData[] = $row;
}


/* =========================================================
   MONTHLY REGISTRATION
========================================================= */

$monthlyData = [];

$months = [
    1 => "Jan",
    2 => "Feb",
    3 => "Mar",
    4 => "Apr",
    5 => "May",
    6 => "Jun",
    7 => "Jul",
    8 => "Aug",
    9 => "Sep",
    10 => "Oct",
    11 => "Nov",
    12 => "Dec"
];

$monthlyCounts = [];

$monthlyQuery = mysqli_query(
    $conn,
    "SELECT
        MONTH(created_at) AS month_number,
        COUNT(*) AS total
     FROM patients
     WHERE YEAR(created_at) = YEAR(CURDATE())
     GROUP BY MONTH(created_at)
     ORDER BY month_number"
);

while ($row = mysqli_fetch_assoc($monthlyQuery)) {

    $monthlyCounts[(int)$row['month_number']] =
        (int)$row['total'];
}

foreach ($months as $number => $name) {

    $monthlyData[] = [
        "month_name" => $name,
        "total" => $monthlyCounts[$number] ?? 0
    ];
}


/* =========================================================
   RECENT PATIENTS
========================================================= */

$recentPatients = mysqli_query(
    $conn,
    "SELECT *
     FROM patients
     ORDER BY id DESC
     LIMIT 7"
);


/* =========================================================
   HEADER + SIDEBAR
========================================================= */

include("../includes/header.php");
include("../includes/sidebar.php");

?>

<div class="main-content dashboard-page">


    <!-- =====================================================
         DASHBOARD INTRO
    ====================================================== -->

    <section class="dashboard-hero">

        <div class="hero-left">

            <div class="hero-eyebrow">
                <span class="hero-dot"></span>
                HOSPITAL BASED CANCER REGISTRY
            </div>

            <h1>
                Registry Dashboard
            </h1>

            <p>
                A centralized overview of patient records,
                diagnosis, treatment and follow-up activity.
            </p>

        </div>


        <div class="hero-date">

            <div class="hero-date-icon">
                <i class="fa-solid fa-calendar-days"></i>
            </div>

            <div>

                <span>Today</span>

                <strong>
                    <?php echo date("d M Y"); ?>
                </strong>

            </div>

        </div>

    </section>



    <!-- =====================================================
         STATISTICS
    ====================================================== -->

    <section class="dashboard-stats">


        <!-- PATIENTS -->

        <div class="stat-card stat-patients">

            <div class="stat-top">

                <div class="stat-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <span class="stat-label">
                    PATIENTS
                </span>

            </div>

            <div class="stat-number">
                <?php echo $totalPatients['total']; ?>
            </div>

            <div class="stat-description">
                Registered patients
            </div>

        </div>


        <!-- DIAGNOSIS -->

        <div class="stat-card stat-diagnosis">

            <div class="stat-top">

                <div class="stat-icon">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>

                <span class="stat-label">
                    DIAGNOSIS
                </span>

            </div>

            <div class="stat-number">
                <?php echo $totalDiagnosis['total']; ?>
            </div>

            <div class="stat-description">
                Diagnosis records
            </div>

        </div>


        <!-- TREATMENT -->

        <div class="stat-card stat-treatment">

            <div class="stat-top">

                <div class="stat-icon">
                    <i class="fa-solid fa-pills"></i>
                </div>

                <span class="stat-label">
                    TREATMENT
                </span>

            </div>

            <div class="stat-number">
                <?php echo $totalTreatment['total']; ?>
            </div>

            <div class="stat-description">
                Treatment records
            </div>

        </div>


        <!-- FOLLOW UP -->

        <div class="stat-card stat-followup">

            <div class="stat-top">

                <div class="stat-icon">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

                <span class="stat-label">
                    FOLLOW-UP
                </span>

            </div>

            <div class="stat-number">
                <?php echo $totalFollowup['total']; ?>
            </div>

            <div class="stat-description">
                Follow-up records
            </div>

        </div>


    </section>



    <!-- =====================================================
         MAIN ANALYTICS
    ====================================================== -->

    <section class="analytics-grid">


        <!-- REGISTRATION TREND -->

        <div class="dashboard-card chart-card-large">

            <div class="card-heading">

                <div>

                    <span class="section-kicker">
                        REGISTRY ACTIVITY
                    </span>

                    <h3>
                        Patient Registration Trend
                    </h3>

                    <p>
                        Monthly patient registrations for
                        <?php echo date("Y"); ?>
                    </p>

                </div>

                <div class="card-icon purple">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

            </div>

            <div class="chart-area">
                <canvas id="registrationChart"></canvas>
            </div>

        </div>


        <!-- GENDER -->

        <div class="dashboard-card">

            <div class="card-heading">

                <div>

                    <span class="section-kicker">
                        PATIENT PROFILE
                    </span>

                    <h3>
                        Gender Distribution
                    </h3>

                    <p>
                        Registered patient demographics
                    </p>

                </div>

                <div class="card-icon rose">
                    <i class="fa-solid fa-venus-mars"></i>
                </div>

            </div>

            <div class="chart-area gender-area">
                <canvas id="genderChart"></canvas>
            </div>

        </div>


    </section>



    <!-- =====================================================
         SECOND ANALYTICS
    ====================================================== -->

    <section class="analytics-grid two-column">


        <!-- CANCER SITES -->

        <div class="dashboard-card">

            <div class="card-heading">

                <div>

                    <span class="section-kicker">
                        CANCER REGISTRY
                    </span>

                    <h3>
                        Cancer Sites
                    </h3>

                    <p>
                        Most frequently recorded primary sites
                    </p>

                </div>

                <div class="card-icon sage">
                    <i class="fa-solid fa-ribbon"></i>
                </div>

            </div>

            <div class="chart-area">
                <canvas id="siteChart"></canvas>
            </div>

        </div>


        <!-- STAGE -->

        <div class="dashboard-card">

            <div class="card-heading">

                <div>

                    <span class="section-kicker">
                        CLINICAL PROFILE
                    </span>

                    <h3>
                        Cancer Stage Distribution
                    </h3>

                    <p>
                        Distribution by recorded stage
                    </p>

                </div>

                <div class="card-icon amber">
                    <i class="fa-solid fa-layer-group"></i>
                </div>

            </div>

            <div class="chart-area">
                <canvas id="stageChart"></canvas>
            </div>

        </div>


    </section>



    <!-- =====================================================
         RECENT PATIENTS
    ====================================================== -->

    <section class="dashboard-card patients-card">

        <div class="card-heading table-heading">

            <div>

                <span class="section-kicker">
                    RECENT ACTIVITY
                </span>

                <h3>
                    Recently Registered Patients
                </h3>

                <p>
                    Latest patient registrations in the registry
                </p>

            </div>

            <a
                href="../patients/patient_list.php"
                class="view-all-btn"
            >
                View All
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>


        <div class="table-wrapper">

            <table class="professional-table">

                <thead>

                    <tr>

                        <th>HBCR No.</th>

                        <th>Patient</th>

                        <th>Gender</th>

                        <th>Age</th>

                        <th>Mobile</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>


                <?php

                if (mysqli_num_rows($recentPatients) > 0) {

                    while ($row = mysqli_fetch_assoc($recentPatients)) {

                        $name = trim(
                            ($row['first_name'] ?? '') .
                            ' ' .
                            ($row['last_name'] ?? '')
                        );

                ?>

                    <tr>


                        <!-- HBCR -->

                        <td>

                            <span class="hbcr-number">

                                <?php
                                echo htmlspecialchars(
                                    $row['hbcr_no'] ?? 'N/A'
                                );
                                ?>

                            </span>

                        </td>


                        <!-- PATIENT -->

                        <td>

                            <div class="patient-name">

                                <div class="patient-avatar">
                                    <i class="fa-solid fa-user"></i>
                                </div>

                                <strong>

                                    <?php
                                    echo htmlspecialchars(
                                        $name ?: 'Unnamed Patient'
                                    );
                                    ?>

                                </strong>

                            </div>

                        </td>


                        <!-- GENDER -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row['gender'] ?? 'Not Added'
                            );
                            ?>

                        </td>


                        <!-- AGE -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row['age'] ?? 'Not Added'
                            );
                            ?>

                        </td>


                        <!-- MOBILE -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row['mobile'] ?? 'Not Added'
                            );
                            ?>

                        </td>


                        <!-- ACTION -->

                        <td>

                            <a
                                href="../patients/view_patient.php?id=<?php echo $row['id']; ?>"
                                class="action-view"
                            >

                                <i class="fa-solid fa-eye"></i>

                                View

                            </a>

                        </td>


                    </tr>


                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td
                            colspan="6"
                            class="empty-table"
                        >

                            <i class="fa-solid fa-users"></i>

                            No patients registered yet.

                        </td>

                    </tr>

                <?php

                }

                ?>


                </tbody>

            </table>

        </div>

    </section>



    <!-- =====================================================
         QUICK ACTIONS
    ====================================================== -->

    <section class="dashboard-card quick-card">

        <div class="card-heading">

            <div>

                <span class="section-kicker">
                    SHORTCUTS
                </span>

                <h3>
                    Quick Actions
                </h3>

                <p>
                    Frequently used registry functions
                </p>

            </div>

        </div>


        <div class="quick-actions">


            <!-- REGISTER -->

            <a
                href="../patients/patient_registration.php"
                class="quick-action"
            >

                <div class="quick-icon purple">
                    <i class="fa-solid fa-user-plus"></i>
                </div>

                <div class="quick-content">

                    <strong>
                        Register Patient
                    </strong>

                    <span>
                        Add a new patient
                    </span>

                </div>

                <i class="fa-solid fa-chevron-right quick-arrow"></i>

            </a>


            <!-- DIAGNOSIS -->

            <a
                href="../diagnosis/diagnosis.php"
                class="quick-action"
            >

                <div class="quick-icon rose">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>

                <div class="quick-content">

                    <strong>
                        Add Diagnosis
                    </strong>

                    <span>
                        Record cancer diagnosis
                    </span>

                </div>

                <i class="fa-solid fa-chevron-right quick-arrow"></i>

            </a>


            <!-- TREATMENT -->

            <a
                href="../treatment/treatment_form.php"
                class="quick-action"
            >

                <div class="quick-icon sage">
                    <i class="fa-solid fa-pills"></i>
                </div>

                <div class="quick-content">

                    <strong>
                        Add Treatment
                    </strong>

                    <span>
                        Record treatment details
                    </span>

                </div>

                <i class="fa-solid fa-chevron-right quick-arrow"></i>

            </a>


            <!-- FOLLOW UP -->

            <a
                href="../followup/followup_form.php"
                class="quick-action"
            >

                <div class="quick-icon amber">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

                <div class="quick-content">

                    <strong>
                        Add Follow-up
                    </strong>

                    <span>
                        Update patient outcome
                    </span>

                </div>

                <i class="fa-solid fa-chevron-right quick-arrow"></i>

            </a>


        </div>

    </section>


</div>



<!-- =========================================================
     CHART.JS
========================================================= -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

/* =========================================================
   PHP DATA
========================================================= */

const genderData =
    <?php echo json_encode($genderData); ?>;

const siteData =
    <?php echo json_encode($siteData); ?>;

const stageData =
    <?php echo json_encode($stageData); ?>;

const monthlyData =
    <?php echo json_encode($monthlyData); ?>;


/* =========================================================
   THEME
========================================================= */

const colors = {

    purple: '#65558f',

    purpleDark: '#514275',

    rose: '#9b6575',

    sage: '#617c6d',

    amber: '#a27b4c',

    text: '#302d3d',

    muted: '#817d88',

    grid: '#ebe8ee'

};


const chartFont = {

    family: 'Poppins',

    size: 11

};


/* =========================================================
   REGISTRATION CHART
========================================================= */

new Chart(

    document.getElementById('registrationChart'),

    {

        type: 'line',

        data: {

            labels:
                monthlyData.map(
                    item => item.month_name
                ),

            datasets: [{

                label: 'Registered Patients',

                data:
                    monthlyData.map(
                        item => item.total
                    ),

                borderColor: '#087f70',

                backgroundColor: 'rgba(91, 184, 169, 0.15)',
                fill: true,

                tension: 0.38,

                borderWidth: 3,

                pointRadius: 4,

                pointHoverRadius: 7,

                pointBackgroundColor: '#087f70',
                pointBorderColor:
                    '#ffffff',

                pointBorderWidth: 2

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                intersect: false,

                mode: 'index'

            },

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    backgroundColor:
                        '#302d3d',

                    titleFont: {

                        family: 'Poppins',

                        size: 12

                    },

                    bodyFont: {

                        family: 'Poppins',

                        size: 11

                    },

                    padding: 12,

                    displayColors: false,

                    callbacks: {

                        label: function(context) {

                            return ' Patients: ' +
                                context.parsed.y;

                        }

                    }

                }

            },

            scales: {

                x: {

                    grid: {
                        display: false
                    },

                    ticks: {

                        font: chartFont,

                        color:
                            colors.muted

                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0,

                        font: chartFont,

                        color:
                            colors.muted

                    },

                    grid: {

                        color:
                            colors.grid

                    }

                }

            }

        }

    }

);


/* =========================================================
   GENDER CHART
========================================================= */

new Chart(

    document.getElementById('genderChart'),

    {

        type: 'doughnut',

        data: {

            labels:
                genderData.map(
                    item => item.gender
                ),

            datasets: [{

                data:
                    genderData.map(
                        item => item.total
                    ),

                backgroundColor: [
    '#5BB8A9',
    '#A8D8CE',
    '#4F9F96'
],

                borderWidth: 4,

                borderColor: '#ffffff'

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '70%',

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {

                        usePointStyle: true,

                        padding: 15,

                        font: chartFont,

                        color:
                            colors.text

                    }

                },

                tooltip: {

                    backgroundColor:
                        '#302d3d',

                    padding: 12,

                    callbacks: {

                        label: function(context) {

                            const total =
                                context.dataset.data.reduce(
                                    (a, b) => a + b,
                                    0
                                );

                            const value =
                                context.raw;

                            const percentage =
                                total > 0
                                ? (
                                    (value / total) * 100
                                  ).toFixed(1)
                                : 0;

                            return ' ' +
                                context.label +
                                ': ' +
                                value +
                                ' (' +
                                percentage +
                                '%)';

                        }

                    }

                }

            }

        }

    }

);


/* =========================================================
   CANCER SITE CHART
========================================================= */

new Chart(

    document.getElementById('siteChart'),

    {

        type: 'bar',

        data: {

            labels:
                siteData.map(
                    item => item.primary_site
                ),

            datasets: [{

                label: 'Cancer Cases',

                data:
                    siteData.map(
                        item => item.total
                    ),

                backgroundColor:
                    colors.sage,

                borderRadius: 6,

                borderSkipped: false

            }]

        },

        options: {

            indexAxis: 'y',

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    backgroundColor:
                        '#302d3d',

                    padding: 12,

                    displayColors: false,

                    callbacks: {

                        label: function(context) {

                            return ' Cases: ' +
                                context.parsed.x;

                        }

                    }

                }

            },

            scales: {

                x: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0,

                        font: chartFont,

                        color:
                            colors.muted

                    },

                    grid: {

                        color:
                            colors.grid

                    }

                },

                y: {

                    ticks: {

                        font: chartFont,

                        color:
                            colors.text

                    },

                    grid: {

                        display: false

                    }

                }

            }

        }

    }

);


/* =========================================================
   STAGE CHART
========================================================= */

const stageOrder = [

    'Stage I',

    'Stage II',

    'Stage III',

    'Stage IV'

];


const stageCounts = {};


stageData.forEach(item => {

    stageCounts[item.stage] =
        parseInt(item.total);

});


const orderedStageData =
    stageOrder.map(stage => {

        return {

            stage: stage,

            total:
                stageCounts[stage] || 0

        };

    });


new Chart(

    document.getElementById('stageChart'),

    {

        type: 'bar',

        data: {

            labels:
                orderedStageData.map(
                    item => item.stage
                ),

            datasets: [{

                label: 'Cases',

                data:
                    orderedStageData.map(
                        item => item.total
                    ),

                backgroundColor: [

                    '#b49a72',

                    '#9b6575',

                    '#789184',

                    '#65558f'

                ],

                borderRadius: 7,

                borderSkipped: false

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    backgroundColor:
                        '#302d3d',

                    padding: 12,

                    displayColors: false,

                    callbacks: {

                        label: function(context) {

                            return ' Cases: ' +
                                context.parsed.y;

                        }

                    }

                }

            },

            scales: {

                x: {

                    ticks: {

                        font: chartFont,

                        color:
                            colors.text

                    },

                    grid: {

                        display: false

                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0,

                        font: chartFont,

                        color:
                            colors.muted

                    },

                    grid: {

                        color:
                            colors.grid

                    }

                }

            }

        }

    }

);

</script>



<!-- =========================================================
     DASHBOARD-ONLY CSS
========================================================= -->

<style>

/* =========================================================
   DASHBOARD BASE
========================================================= */

.dashboard-page {

    background:
        linear-gradient(
            135deg,
            #f5f1f4 0%,
            #f3f4ef 50%,
            #f1f0f5 100%
        ) !important;

    padding: 28px !important;

    /* Prevent dashboard from going underneath fixed header */
    padding-top: 110px !important;

}


/* =========================================================
   HERO
========================================================= */

.dashboard-hero {

    position: relative;

    overflow: hidden;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 25px;

    padding: 28px 30px;

    margin-bottom: 22px;

    border-radius: 18px;

    border: 1px solid #ddd8e2;

    background:
        linear-gradient(
            110deg,
            #e9e2ee 0%,
            #eee8ed 48%,
            #e6ece6 100%
        );

    box-shadow:
        0 8px 25px rgba(61,48,70,.07);

}

.dashboard-hero::after {

    content: "";

    position: absolute;

    width: 190px;

    height: 190px;

    right: -70px;

    top: -80px;

    border-radius: 50%;

    background:
        rgba(101,85,143,.08);

}

.hero-left {

    position: relative;

    z-index: 2;

}

.hero-eyebrow {

    display: flex;

    align-items: center;

    gap: 8px;

    margin-bottom: 7px;

    color: #665b75;

    font-size: 10px;

    font-weight: 700;

    letter-spacing: 1.5px;

}

.hero-dot {

    width: 7px;

    height: 7px;

    border-radius: 50%;

    background: #65558f;

}

.dashboard-hero h1 {

    margin: 0;

    color: #302d3d;

    font-size: 30px;

    font-weight: 700;

    letter-spacing: -.5px;

}

.dashboard-hero p {

    margin: 7px 0 0;

    color: #746f7b;

    font-size: 12px;

}

.hero-date {

    position: relative;

    z-index: 2;

    display: flex;

    align-items: center;

    gap: 11px;

    padding: 11px 15px;

    min-width: 150px;

    background:
        rgba(255,255,255,.68);

    border: 1px solid
        rgba(255,255,255,.85);

    border-radius: 12px;

}

.hero-date-icon {

    width: 36px;

    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    background: #e7e0f0;

    color: #65558f;

}

.hero-date span {

    display: block;

    margin-bottom: 2px;

    color: #89828e;

    font-size: 9px;

}

.hero-date strong {

    display: block;

    color: #393342;

    font-size: 11px;

}


/* =========================================================
   STATISTICS
========================================================= */

.dashboard-stats {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 16px;

    margin-bottom: 20px;

}

.stat-card {

    position: relative;

    overflow: hidden;

    min-height: 145px;

    padding: 19px;

    border-radius: 15px;

    background: #ffffff;

    border: 1px solid #ded9e0;

    box-shadow:
        0 6px 20px rgba(55,44,62,.055);

    transition:
        transform .22s ease,
        box-shadow .22s ease;

}

.stat-card:hover {

    transform: translateY(-3px);

    box-shadow:
        0 11px 25px rgba(55,44,62,.09);

}

.stat-card::after {

    content: "";

    position: absolute;

    width: 85px;

    height: 85px;

    right: -35px;

    bottom: -38px;

    border-radius: 50%;

    opacity: .5;

}

.stat-patients {
    border-top: 3px solid #65558f;
}

.stat-diagnosis {
    border-top: 3px solid #9b6575;
}

.stat-treatment {
    border-top: 3px solid #617c6d;
}

.stat-followup {
    border-top: 3px solid #a27b4c;
}

.stat-patients::after {
    background: #e8e2f0;
}

.stat-diagnosis::after {
    background: #f1e4e8;
}

.stat-treatment::after {
    background: #e3ece5;
}

.stat-followup::after {
    background: #f2e9dc;
}

.stat-top {

    position: relative;

    z-index: 2;

    display: flex;

    justify-content: space-between;

    align-items: center;

}

.stat-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    font-size: 17px;

}

.stat-patients .stat-icon {

    background: #ece7f2;

    color: #65558f;

}

.stat-diagnosis .stat-icon {

    background: #f2e8eb;

    color: #9b6575;

}

.stat-treatment .stat-icon {

    background: #e8eee9;

    color: #617c6d;

}

.stat-followup .stat-icon {

    background: #f3ebdf;

    color: #a27b4c;

}

.stat-label {

    color: #958f99;

    font-size: 8px;

    font-weight: 700;

    letter-spacing: 1.2px;

}

.stat-number {

    position: relative;

    z-index: 2;

    margin-top: 12px;

    color: #302d3d;

    font-size: 29px;

    font-weight: 700;

    line-height: 1;

}

.stat-description {

    position: relative;

    z-index: 2;

    margin-top: 7px;

    color: #8c8790;

    font-size: 10px;

}


/* =========================================================
   ANALYTICS GRID
========================================================= */

.analytics-grid {

    display: grid;

    grid-template-columns:
        1.8fr 1fr;

    gap: 18px;

    margin-bottom: 18px;

}

.analytics-grid.two-column {

    grid-template-columns:
        1fr 1fr;

}


/* =========================================================
   DASHBOARD CARDS
========================================================= */

.dashboard-card {

    min-width: 0;

    background: #ffffff;

    border: 1px solid #ded9e0;

    border-radius: 16px;

    box-shadow:
        0 6px 20px rgba(55,44,62,.045);

    overflow: hidden;

}

.card-heading {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    gap: 15px;

    padding: 19px 20px 8px;

}

.section-kicker {

    display: block;

    margin-bottom: 5px;

    color: #81758d;

    font-size: 8px;

    font-weight: 700;

    letter-spacing: 1.3px;

}

.card-heading h3 {

    margin: 0;

    color: #363240;

    font-size: 15px;

    font-weight: 650;

}

.card-heading p {

    margin: 4px 0 0;

    color: #96919a;

    font-size: 10px;

}

.card-icon {

    width: 35px;

    height: 35px;

    min-width: 35px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    font-size: 13px;

}

.card-icon.purple,
.quick-icon.purple {

    background: #ece7f3;

    color: #65558f;

}

.card-icon.rose,
.quick-icon.rose {

    background: #f2e7ea;

    color: #9b6575;

}

.card-icon.sage,
.quick-icon.sage {

    background: #e7eee9;

    color: #617c6d;

}

.card-icon.amber,
.quick-icon.amber {

    background: #f3ebdf;

    color: #a27b4c;

}


/* =========================================================
   CHARTS
========================================================= */

.chart-area {

    position: relative;

    height: 280px;

    padding: 10px 18px 18px;

}

.gender-area {

    height: 280px;

}


/* =========================================================
   RECENT PATIENTS
========================================================= */

.patients-card {

    margin-bottom: 18px;

}

.table-heading {

    padding-bottom: 16px;

    border-bottom: 1px solid #ebe7ec;

}

.view-all-btn {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 8px 12px;

    color: #5e527f;

    background: #f0ebf4;

    border: 1px solid #e0d8e8;

    border-radius: 8px;

    text-decoration: none;

    font-size: 10px;

    font-weight: 600;

    transition: .2s;

}

.view-all-btn:hover {

    color: #4d416d;

    background: #e8e1ed;

}

.table-wrapper {

    width: 100%;

    overflow-x: auto;

}

.professional-table {

    width: 100%;

    border-collapse: collapse;

}

.professional-table th {

    padding: 12px 18px;

    background: #f7f5f7;

    color: #817b85;

    border-bottom: 1px solid #e8e4e9;

    text-align: left;

    font-size: 9px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .6px;

    white-space: nowrap;

}

.professional-table td {

    padding: 12px 18px;

    color: #615c65;

    border-bottom: 1px solid #eeeaf0;

    font-size: 11px;

}

.professional-table tbody tr {

    transition: background .18s ease;

}

.professional-table tbody tr:hover {

    background: #faf8fb;

}

.professional-table tbody tr:last-child td {

    border-bottom: none;

}

.hbcr-number {

    display: inline-block;

    padding: 5px 8px;

    border-radius: 6px;

    background: #eee9f3;

    color: #65558f;

    font-size: 9px;

    font-weight: 700;

}

.patient-name {

    display: flex;

    align-items: center;

    gap: 9px;

}

.patient-avatar {

    width: 29px;

    height: 29px;

    min-width: 29px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #f0ebf3;

    color: #65558f;

    font-size: 10px;

}

.patient-name strong {

    color: #45414a;

    font-size: 11px;

    font-weight: 600;

}

.action-view {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 10px;

    border-radius: 7px;

    background: #f0ebf4;

    color: #5d507d;

    text-decoration: none;

    font-size: 9px;

    font-weight: 600;

    transition: .2s;

}

.action-view:hover {

    background: #e5deea;

    color: #493d67;

}

.empty-table {

    padding: 35px !important;

    color: #99939d !important;

    text-align: center;

}


/* =========================================================
   QUICK ACTIONS
========================================================= */

.quick-card {

    padding-bottom: 18px;

}

.quick-actions {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 11px;

    padding: 12px 18px 0;

}

.quick-action {

    display: flex;

    align-items: center;

    gap: 10px;

    min-width: 0;

    padding: 13px;

    background: #fbfafb;

    border: 1px solid #e4e0e5;

    border-radius: 11px;

    text-decoration: none;

    transition:
        transform .2s ease,
        border-color .2s ease,
        background .2s ease;

}

.quick-action:hover {

    transform: translateY(-2px);

    background: #f7f4f8;

    border-color: #cfc5d6;

}

.quick-icon {

    width: 38px;

    height: 38px;

    min-width: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    font-size: 13px;

}

.quick-content {

    min-width: 0;

}

.quick-content strong {

    display: block;

    color: #45404a;

    font-size: 11px;

    font-weight: 600;

}

.quick-content span {

    display: block;

    margin-top: 3px;

    color: #99939b;

    font-size: 9px;

}

.quick-arrow {

    margin-left: auto;

    color: #aaa4ad;

    font-size: 9px;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1100px) {

    .dashboard-stats {

        grid-template-columns:
            repeat(2, 1fr);

    }

    .quick-actions {

        grid-template-columns:
            repeat(2, 1fr);

    }

    .analytics-grid {

        grid-template-columns: 1fr;

    }

    .analytics-grid.two-column {

        grid-template-columns: 1fr;

    }

}


@media(max-width:768px) {

    .dashboard-page {

        padding: 18px !important;

    }

    .dashboard-hero {

        flex-direction: column;

        align-items: flex-start;

    }

    .hero-date {

        width: 100%;

    }

    .dashboard-hero h1 {

        font-size: 25px;

    }

}


@media(max-width:600px) {

    .dashboard-stats {

        grid-template-columns: 1fr;

    }

    .quick-actions {

        grid-template-columns: 1fr;

    }

    .dashboard-hero {

        padding: 22px;

    }

    .card-heading {

        padding-left: 16px;

        padding-right: 16px;

    }

    .chart-area {

        height: 250px;

        padding-left: 10px;

        padding-right: 10px;

    }

}

</style>


<?php

include("../includes/footer.php");

?>
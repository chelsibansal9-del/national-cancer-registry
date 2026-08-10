<!-- =====================================================
     HBCR SIDEBAR
===================================================== -->

<aside class="hbcr-sidebar">

    <!-- SIDEBAR BRAND -->

    <div class="hbcr-sidebar-brand">

        <div class="hbcr-sidebar-logo">

            <img
             src="../assets/images/hbcr-final.png"
            class="sidebar-logo"
            alt="HBCR Logo"
            >

        </div>

        <h2>HBCR</h2>

        <span>Cancer Registry</span>

    </div>


    <!-- NAVIGATION -->

    <nav class="hbcr-sidebar-nav">


        <!-- DASHBOARD -->

        <a
            href="../dashboard/dashboard.php"
            class="hbcr-nav-item"
        >

            <span class="hbcr-nav-icon">
                <i class="bi bi-speedometer2"></i>
            </span>

            <span class="hbcr-nav-text">
                Dashboard
            </span>

        </a>


        <!-- PATIENT MANAGEMENT -->

        <div class="hbcr-nav-section">
            PATIENT MANAGEMENT
        </div>


        <a
            href="../patients/patient_registration.php"
            class="hbcr-nav-item"
        >

            <span class="hbcr-nav-icon">
                <i class="bi bi-person-plus"></i>
            </span>

            <span class="hbcr-nav-text">
                Patient Registration
            </span>

        </a>


        <a
            href="../patients/patient_list.php"
            class="hbcr-nav-item"
        >

            <span class="hbcr-nav-icon">
                <i class="bi bi-people"></i>
            </span>

            <span class="hbcr-nav-text">
                Patient List
            </span>

        </a>


        <!-- CLINICAL RECORDS -->

        <div class="hbcr-nav-section">
            CLINICAL RECORDS
        </div>


        <a
            href="../diagnosis/diagnosis_list.php"
            class="hbcr-nav-item"
        >

            <span class="hbcr-nav-icon">
                <i class="bi bi-heart-pulse"></i>
            </span>

            <span class="hbcr-nav-text">
                Diagnosis
            </span>

        </a>


        <a
            href="../treatment/treatment.php"
            class="hbcr-nav-item"
        >

            <span class="hbcr-nav-icon">
                <i class="bi bi-capsule"></i>
            </span>

            <span class="hbcr-nav-text">
                Treatment
            </span>

        </a>


        <a
            href="../followup/followup.php"
            class="hbcr-nav-item"
        >

            <span class="hbcr-nav-icon">
                <i class="bi bi-calendar-check"></i>
            </span>

            <span class="hbcr-nav-text">
                Follow-up
            </span>

        </a>


        <!-- REPORTING -->

        <div class="hbcr-nav-section">
            REPORTING
        </div>


        <a
            href="../reports/reports.php"
            class="hbcr-nav-item"
        >

            <span class="hbcr-nav-icon">
                <i class="bi bi-bar-chart-line"></i>
            </span>

            <span class="hbcr-nav-text">
                Reports
            </span>

        </a>

    </nav>


    <!-- LOGOUT -->

    <div class="hbcr-sidebar-footer">

        <a
            href="../auth/logout.php"
            class="hbcr-logout"
        >

            <span class="hbcr-nav-icon">
                <i class="bi bi-box-arrow-right"></i>
            </span>

            <span>
                Logout
            </span>

        </a>

    </div>

</aside>


<!-- =====================================================
     ACTIVE SIDEBAR ITEM
===================================================== -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    const currentFile =
        window.location.pathname
            .split("/")
            .pop()
            .toLowerCase();


    const navItems =
        document.querySelectorAll(
            ".hbcr-sidebar-nav .hbcr-nav-item"
        );


    navItems.forEach(function (item) {

        const href =
            item.getAttribute("href");


        if (!href) {
            return;
        }


        const linkFile =
            href
                .split("/")
                .pop()
                .split("?")[0]
                .toLowerCase();


        if (
            linkFile === currentFile
        ) {

            item.classList.add("active");

        }

    });

});

</script>

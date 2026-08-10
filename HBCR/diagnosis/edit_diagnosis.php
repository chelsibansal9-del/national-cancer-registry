<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/database.php");

/* =====================================================
   GET DIAGNOSIS ID
===================================================== */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid diagnosis ID.");
}

$id = (int) $_GET['id'];


/* =====================================================
   FETCH DIAGNOSIS + PATIENT
===================================================== */

$sql = "SELECT
            diagnosis.*,
            patients.hbcr_no,
            patients.hospital_no,
            patients.aadhaar,
            patients.abha_id,
            patients.first_name,
            patients.middle_name,
            patients.last_name,
            patients.age,
            patients.gender,
            patients.mobile
        FROM diagnosis
        LEFT JOIN patients
            ON diagnosis.patient_id = patients.id
        WHERE diagnosis.id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("Diagnosis record not found.");
}

$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* =====================================================
   PATIENT NAME
===================================================== */

$patient_name = trim(
    ($row['first_name'] ?? '') . " " .
    ($row['middle_name'] ?? '') . " " .
    ($row['last_name'] ?? '')
);

?>

<div class="main-content">

    <div class="page-header">

        <h2>
            <i class="fa fa-edit"></i>
            Edit Diagnosis
        </h2>

        <p>
            Update complete diagnosis information
        </p>

    </div>


    <form
        action="update_diagnosis.php"
        method="POST"
        id="editDiagnosisForm"
    >

        <!-- =================================================
             IMPORTANT: ID
        ================================================== -->

        <input
            type="hidden"
            name="id"
            value="<?php echo (int)$row['id']; ?>"
        >


        <!-- =================================================
             PATIENT INFORMATION
        ================================================== -->

        <div class="card">

            <h3>
                <i class="fa fa-user"></i>
                Patient Information
            </h3>

            <div class="edit-grid">

                <div class="form-group">

                    <label>HBCR No.</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['hbcr_no'] ?? ''); ?>"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>Hospital Registration No.</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['hospital_no'] ?? ''); ?>"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>Aadhaar No.</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['aadhaar'] ?? ''); ?>"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>ABHA ID</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['abha_id'] ?? ''); ?>"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>Patient Name</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo htmlspecialchars($patient_name); ?>"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>Age</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['age'] ?? ''); ?>"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>Gender</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['gender'] ?? ''); ?>"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>Mobile</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['mobile'] ?? ''); ?>"
                        readonly
                    >

                </div>

            </div>

        </div>


        <!-- =================================================
             DIAGNOSIS INFORMATION
        ================================================== -->

        <div class="card">

            <h3>
                <i class="fa fa-stethoscope"></i>
                Diagnosis Information
            </h3>

            <div class="edit-grid">

                <div class="form-group">

                    <label class="required">
                        Date of Diagnosis
                    </label>

                    <input
                        type="date"
                        name="diagnosis_date"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['diagnosis_date'] ?? ''); ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label class="required">
                        Method of Diagnosis
                    </label>

                    <select
                        name="diagnosis_method"
                        class="form-control"
                        required
                    >

                        <option value="">-- Select Method --</option>

                        <?php
                        $methods = [
                            "Clinical Examination",
                            "Biopsy",
                            "FNAC",
                            "Histopathology",
                            "Cytology",
                            "Imaging",
                            "Other"
                        ];

                        foreach ($methods as $method) {
                            $selected =
                                ($row['diagnosis_method'] == $method)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($method) .
                                "\" $selected>" .
                                htmlspecialchars($method) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Duration of Symptoms
                    </label>

                    <input
                        type="text"
                        name="symptom_duration"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['symptom_duration'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Microscopic Confirmation
                    </label>

                    <select
                        name="microscopic_confirmation"
                        class="form-control"
                    >

                        <option value="">-- Select --</option>

                        <?php
                        $options = ["Yes", "No", "Unknown"];

                        foreach ($options as $option) {

                            $selected =
                                ($row['microscopic_confirmation'] == $option)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($option) .
                                "\" $selected>" .
                                htmlspecialchars($option) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group full">

                    <label>
                        Site of Specimen / Biopsy
                    </label>

                    <input
                        type="text"
                        name="specimen_site"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['specimen_site'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Pathology / Slide No.
                    </label>

                    <input
                        type="text"
                        name="pathology_slide_no"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['pathology_slide_no'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Pathology Report Date
                    </label>

                    <input
                        type="date"
                        name="pathology_report_date"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['pathology_report_date'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group full">

                    <label>
                        Diagnosis / Clinical Diagnosis
                    </label>

                    <textarea
                        name="diagnosis"
                        class="form-control"
                        rows="3"
                    ><?php echo htmlspecialchars($row['diagnosis'] ?? ''); ?></textarea>

                </div>

            </div>

        </div>


        <!-- =================================================
             PRIMARY SITE
        ================================================== -->

        <div class="card">

            <h3>
                <i class="fa fa-map-marker"></i>
                Primary Site / Topography
            </h3>

            <div class="edit-grid">

                <div class="form-group">

                    <label class="required">
                        Primary Site
                    </label>

                    <select
                        name="primary_site"
                        class="form-control"
                        required
                    >

                        <option value="">-- Select Primary Site --</option>

                        <?php

                        $sites = [
                            "Oral Cavity",
                            "Oropharynx",
                            "Nasopharynx",
                            "Hypopharynx",
                            "Larynx",
                            "Oesophagus",
                            "Stomach",
                            "Colon",
                            "Rectum",
                            "Liver",
                            "Pancreas",
                            "Lung",
                            "Breast",
                            "Cervix Uteri",
                            "Corpus Uteri",
                            "Ovary",
                            "Prostate",
                            "Kidney",
                            "Urinary Bladder",
                            "Brain",
                            "Thyroid",
                            "Skin",
                            "Other"
                        ];

                        foreach ($sites as $site) {

                            $selected =
                                ($row['primary_site'] == $site)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($site) .
                                "\" $selected>" .
                                htmlspecialchars($site) .
                                "</option>";
                        }

                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>ICD-10 Code</label>

                    <input
                        type="text"
                        name="icd_code"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['icd_code'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group">

                    <label>ICD-O-3 Topography Code</label>

                    <input
                        type="text"
                        name="topography"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['topography'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group">

                    <label class="required">Laterality</label>

                    <select
                        name="laterality"
                        class="form-control"
                        required
                    >

                        <option value="">-- Select --</option>

                        <?php
                        $laterality = [
                            "Right",
                            "Left",
                            "Bilateral",
                            "Not Applicable",
                            "Unknown"
                        ];

                        foreach ($laterality as $value) {

                            $selected =
                                ($row['laterality'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group full">

                    <label>
                        Secondary / Metastatic Site
                    </label>

                    <input
                        type="text"
                        name="secondary_site"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['secondary_site'] ?? ''); ?>"
                    >

                </div>

            </div>

        </div>


        <!-- =================================================
             HISTOLOGY
        ================================================== -->

        <div class="card">

            <h3>
                <i class="fa fa-microscope"></i>
                Histology / Morphology
            </h3>

            <div class="edit-grid">

                <div class="form-group">

                    <label class="required">
                        Histology
                    </label>

                    <select
                        name="histology"
                        class="form-control"
                        required
                    >

                        <option value="">-- Select Histology --</option>

                        <?php
                        $histologies = [
                            "Adenocarcinoma",
                            "Squamous Cell Carcinoma",
                            "Ductal Carcinoma",
                            "Lobular Carcinoma",
                            "Small Cell Carcinoma",
                            "Large Cell Carcinoma",
                            "Sarcoma",
                            "Lymphoma",
                            "Melanoma",
                            "Other"
                        ];

                        foreach ($histologies as $value) {

                            $selected =
                                ($row['histology'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        ICD-O-3 Morphology Code
                    </label>

                    <input
                        type="text"
                        name="morphology"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['morphology'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group">

                    <label class="required">
                        Behaviour
                    </label>

                    <select
                        name="tumour_behaviour"
                        class="form-control"
                        required
                    >

                        <option value="">-- Select --</option>

                        <?php
                        $behaviours = [
                            "Malignant",
                            "Benign",
                            "Uncertain",
                            "Unknown"
                        ];

                        foreach ($behaviours as $value) {

                            $selected =
                                ($row['tumour_behaviour'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>

            </div>

        </div>


        <!-- =================================================
             CLINICAL EXTENT
        ================================================== -->

        <div class="card">

            <h3>
                <i class="fa fa-search-plus"></i>
                Clinical Extent of Disease
            </h3>

            <div class="edit-grid">

                <div class="form-group">

                    <label class="required">
                        Clinical Extent
                    </label>

                    <select
                        name="clinical_extent"
                        class="form-control"
                        required
                    >

                        <option value="">-- Select --</option>

                        <?php
                        $extent = [
                            "Localized",
                            "Regional Spread",
                            "Distant Metastasis",
                            "Unknown"
                        ];

                        foreach ($extent as $value) {

                            $selected =
                                ($row['clinical_extent'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Regional Lymph Node Involvement
                    </label>

                    <select
                        name="lymph_node_involvement"
                        class="form-control"
                    >

                        <option value="">-- Select --</option>

                        <?php
                        foreach (["Present", "Absent", "Unknown"] as $value) {

                            $selected =
                                ($row['lymph_node_involvement'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Distant Metastasis
                    </label>

                    <select
                        name="distant_metastasis"
                        class="form-control"
                    >

                        <option value="">-- Select --</option>

                        <?php
                        foreach (["Present", "Absent", "Unknown"] as $value) {

                            $selected =
                                ($row['distant_metastasis'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>

            </div>

        </div>


        <!-- =================================================
             TNM STAGING
        ================================================== -->

        <div class="card">

            <h3>
                <i class="fa fa-layer-group"></i>
                TNM Staging
            </h3>

            <div class="edit-grid">

                <div class="form-group">

                    <label>Staging System</label>

                    <select
                        name="staging_system"
                        class="form-control"
                    >

                        <option value="">-- Select --</option>

                        <?php
                        foreach (
                            [
                                "TNM Clinical",
                                "TNM Pathological",
                                "Other",
                                "Unknown"
                            ] as $value
                        ) {

                            $selected =
                                ($row['staging_system'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>T Category</label>

                    <select
                        name="t_category"
                        class="form-control"
                    >

                        <option value="">-- Select --</option>

                        <?php
                        foreach (
                            ["TX", "T0", "Tis", "T1", "T2", "T3", "T4"]
                            as $value
                        ) {

                            $selected =
                                ($row['t_category'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>N Category</label>

                    <select
                        name="n_category"
                        class="form-control"
                    >

                        <option value="">-- Select --</option>

                        <?php
                        foreach (
                            ["NX", "N0", "N1", "N2", "N2a", "N2b", "N3"]
                            as $value
                        ) {

                            $selected =
                                ($row['n_category'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>M Category</label>

                    <select
                        name="m_category"
                        class="form-control"
                    >

                        <option value="">-- Select --</option>

                        <?php
                        foreach (["MX", "M0", "M1"] as $value) {

                            $selected =
                                ($row['m_category'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>TNM Stage</label>

                    <input
                        type="text"
                        name="tnm_stage"
                        class="form-control"
                        value="<?php echo htmlspecialchars($row['tnm_stage'] ?? ''); ?>"
                    >

                </div>


                <div class="form-group">

                    <label>Composite Stage</label>

                    <select
                        name="stage"
                        class="form-control"
                    >

                        <option value="">-- Select Stage --</option>

                        <?php
                        foreach (
                            [
                                "Stage I",
                                "Stage II",
                                "Stage III",
                                "Stage IV",
                                "Unknown"
                            ] as $value
                        ) {

                            $selected =
                                ($row['stage'] == $value)
                                ? "selected"
                                : "";

                            echo "<option value=\"" .
                                htmlspecialchars($value) .
                                "\" $selected>" .
                                htmlspecialchars($value) .
                                "</option>";
                        }
                        ?>

                    </select>

                </div>

            </div>

        </div>


        <!-- =================================================
             REMARKS
        ================================================== -->

        <div class="card">

            <h3>
                <i class="fa fa-comment"></i>
                Additional Information
            </h3>

            <div class="form-group">

                <label>
                    Remarks / Additional Notes
                </label>

                <textarea
                    name="remarks"
                    class="form-control"
                    rows="5"
                ><?php echo htmlspecialchars($row['remarks'] ?? ''); ?></textarea>

            </div>

        </div>


        <!-- =================================================
             BUTTONS
        ================================================== -->

        <div class="edit-actions">

            <a
                href="diagnosis_list.php"
                class="btn btn-secondary"
            >
                <i class="fa fa-arrow-left"></i>
                Back
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                <i class="fa fa-save"></i>
                Update Diagnosis
            </button>

        </div>

    </form>

</div>


<style>

/* =====================================================
   EDIT DIAGNOSIS PAGE
===================================================== */

.main-content {
    padding: 35px 40px 60px !important;
    box-sizing: border-box;
}


/* HEADER */

.page-header {
    margin-top: 0 !important;
    margin-bottom: 28px !important;
    padding: 24px 28px !important;
}

.page-header h2 {
    margin: 0 !important;
}

.page-header p {
    margin: 7px 0 0 55px !important;
}


/* CARD */

.main-content .card {
    background: #ffffff;
    border: 1px solid #dce6e4;
    border-radius: 10px;
    padding: 28px 30px 30px !important;
    margin-bottom: 25px !important;
    box-sizing: border-box;
}


/* CARD HEADING */

.main-content .card h3 {
    margin: -28px -30px 27px !important;
    padding: 15px 20px !important;

    background: #f0f6f5;

    border-left: 4px solid #164e4a;
    border-bottom: 1px solid #dce6e4;

    border-radius: 10px 10px 0 0;

    color: #164e4a;

    font-size: 16px;
}


/* GRID */

.edit-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    column-gap: 28px;
    row-gap: 23px;
}


/* FULL WIDTH */

.form-group.full {
    grid-column: 1 / -1;
}


/* GROUP */

.form-group {
    min-width: 0;
}


/* LABEL */

.form-group label {
    display: block;

    margin-bottom: 8px;

    color: #344545;

    font-size: 13px;

    font-weight: 600;
}


/* REQUIRED */

.form-group label.required::after {
    content: " *";

    color: #dc3545;
}


/* FIELDS */

.form-control {
    width: 100% !important;

    min-height: 43px;

    padding: 9px 12px;

    box-sizing: border-box;

    border: 1px solid #ccd8d5;

    border-radius: 7px;

    background: #ffffff;

    color: #263635;

    font-size: 13px;

    font-family: inherit;
}


/* TEXTAREA */

textarea.form-control {
    min-height: 105px;
    resize: vertical;
    line-height: 1.5;
}


/* READONLY */

.form-control[readonly] {
    background: #f2f5f4 !important;
    color: #657370;
}


/* FOCUS */

.form-control:focus {
    outline: none;

    border-color: #164e4a;

    box-shadow:
        0 0 0 3px rgba(22,78,74,.09);
}


/* BUTTONS */

.edit-actions {
    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 12px;

    margin-top: 30px;

    margin-bottom: 30px;
}


.edit-actions .btn {
    min-width: 140px;

    padding: 11px 20px;

    border-radius: 7px;

    text-decoration: none;

    text-align: center;

    font-size: 13px;

    font-weight: 600;

    box-sizing: border-box;
}


.edit-actions .btn-primary {
    background: #164e4a !important;

    border: 1px solid #164e4a !important;

    color: #ffffff !important;
}


.edit-actions .btn-secondary {
    background: #ffffff;

    border: 1px solid #cbd7d4;

    color: #40504e;
}


/* TABLET */

@media (max-width: 1100px) {

    .main-content {
        padding-left: 25px !important;
        padding-right: 25px !important;
    }

    .edit-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        column-gap: 22px;
    }

}


/* MOBILE */

@media (max-width: 700px) {

    .main-content {
        padding: 20px 15px 40px !important;
    }

    .main-content .card {
        padding: 22px 20px 24px !important;
    }

    .main-content .card h3 {
        margin: -22px -20px 22px !important;
    }

    .edit-grid {
        grid-template-columns: 1fr;
        row-gap: 18px;
    }

    .form-group.full {
        grid-column: auto;
    }

    .edit-actions {
        flex-direction: column-reverse;
    }

    .edit-actions .btn {
        width: 100%;
    }

}

</style>


<?php
include("../includes/footer.php");
?>
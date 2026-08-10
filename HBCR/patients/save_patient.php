<?php

include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: patient_registration.php");
    exit;
}


/* =====================================================
   HELPER
===================================================== */

function post($name)
{
    return isset($_POST[$name]) ? trim($_POST[$name]) : "";
}


/* =====================================================
   IDENTIFYING INFORMATION
===================================================== */

$institution = post('institution');
$centre_code = post('centre_code');
$department = post('department');
$unit_number = post('unit_number');

/*
   IMPORTANT:
   Hospital Registration No. is now AUTO GENERATED.
   We do NOT use the value entered from the form.
*/

$report_date = post('report_date');
$first_diagnosis_date = post('first_diagnosis_date');


/* =====================================================
   PATIENT INFORMATION
===================================================== */

$first_name = post('first_name');
$middle_name = post('middle_name');
$last_name = post('last_name');
$age = post('age');
$dob = post('dob');
$gender = post('gender');


/* =====================================================
   IDENTIFICATION
===================================================== */

$aadhaar = post('aadhaar');

/*
   ABHA IS NOT GENERATED FROM AADHAAR.

   This is the ABHA number entered by the user
   during patient registration.
*/
$abha_id = post('abha_id');

$health_scheme = post('health_scheme');
$id_status = post('id_status');


/* =====================================================
   NEXT OF KIN
===================================================== */

$next_kin_relation = post('next_kin_relation');
$next_kin_name = post('next_kin_name');
$next_kin_mobile = post('next_kin_mobile');


/* =====================================================
   REFERRAL
===================================================== */

$case_registered_through = post('case_registered_through');
$referral_type = post('referral_type');
$referral_facility = post('referral_facility');
$referral_city = post('referral_city');
$referral_district = post('referral_district');
$referral_pin = post('referral_pin');


/* =====================================================
   CURRENT ADDRESS
===================================================== */

$residence_type = post('residence_type');
$house_no = post('house_no');
$street_name = post('street_name');
$locality = post('locality');
$ward = post('ward');
$city = post('city');
$sub_district = post('sub_district');
$district = post('district');
$pin = post('pin');
$state = post('state');
$mobile = post('mobile');
$mobile2 = post('mobile2');
$email = post('email');
$residence_duration = post('residence_duration');


/* =====================================================
   PERMANENT ADDRESS
===================================================== */

$permanent_village = post('permanent_village');
$permanent_city = post('permanent_city');
$permanent_district = post('permanent_district');
$permanent_pin = post('permanent_pin');
$permanent_state = post('permanent_state');


/* =====================================================
   DEMOGRAPHIC DETAILS
===================================================== */

$marital_status = post('marital_status');
$education = post('education');


/* =====================================================
   HABITS
===================================================== */

$smoking = post('smoking');
$smoking_duration = post('smoking_duration');

$smokeless = post('smokeless');
$smokeless_duration = post('smokeless_duration');

$betelnut_tobacco = post('betelnut_tobacco');
$betelnut_tobacco_duration = post('betelnut_tobacco_duration');

$betelnut = post('betelnut');
$betelnut_duration = post('betelnut_duration');

$alcohol = post('alcohol');
$alcohol_duration = post('alcohol_duration');


/* =====================================================
   CO-MORBIDITIES
===================================================== */

$tuberculosis = post('tuberculosis');
$hypertension = post('hypertension');
$diabetes = post('diabetes');
$ischemic_heart = post('ischemic_heart');
$copd = post('copd');
$stroke = post('stroke');
$depression = post('depression');
$hepatitis_b = post('hepatitis_b');
$hepatitis_c = post('hepatitis_c');
$nafld = post('nafld');
$kidney_disease = post('kidney_disease');
$hiv = post('hiv');
$hypothyroidism = post('hypothyroidism');
$other_comorbidity = post('other_comorbidity');


/* =====================================================
   ANTHROPOMETRIC
===================================================== */

$height = post('height');
$weight = post('weight');


/* =====================================================
   FAMILY CANCER HISTORY
===================================================== */

$family_cancer_history = post('family_cancer_history');
$family_cancer_type = post('family_cancer_type');
$family_relation = post('family_relation');
$family_cancer_site = post('family_cancer_site');
$family_cancer_age = post('family_cancer_age');
$family_cancer_date = post('family_cancer_date');


/* =====================================================
   INSERT COLUMNS
===================================================== */

/*
   NOTE:

   hbcr_no and hospital_no are intentionally NOT inserted
   initially.

   After MySQL creates the patient ID, we generate:

   HBCR-001
   HOSP-001

   This guarantees both numbers follow the patient ID.
*/

$columns = [

    "institution",
    "centre_code",
    "department",
    "unit_number",
    "report_date",
    "first_diagnosis_date",

    "case_registered_through",
    "referral_type",
    "referral_facility",
    "referral_city",
    "referral_district",
    "referral_pin",

    "first_name",
    "middle_name",
    "last_name",
    "age",
    "dob",
    "gender",

    "aadhaar",
    "abha_id",
    "health_scheme",
    "id_status",

    "next_kin_relation",
    "next_kin_name",
    "next_kin_mobile",

    "residence_type",
    "house_no",
    "street_name",
    "locality",
    "ward",
    "city",
    "sub_district",
    "district",
    "pin",
    "state",
    "mobile",
    "mobile2",
    "email",
    "residence_duration",

    "permanent_village",
    "permanent_city",
    "permanent_district",
    "permanent_pin",
    "permanent_state",

    "marital_status",
    "education",

    "smoking",
    "smoking_duration",
    "smokeless",
    "smokeless_duration",
    "betelnut_tobacco",
    "betelnut_tobacco_duration",
    "betelnut",
    "betelnut_duration",
    "alcohol",
    "alcohol_duration",

    "tuberculosis",
    "hypertension",
    "diabetes",
    "ischemic_heart",
    "copd",
    "stroke",
    "depression",
    "hepatitis_b",
    "hepatitis_c",
    "nafld",
    "kidney_disease",
    "hiv",
    "hypothyroidism",
    "other_comorbidity",

    "height",
    "weight",

    "family_cancer_history",
    "family_cancer_type",
    "family_relation",
    "family_cancer_site",
    "family_cancer_age",
    "family_cancer_date"
];


/* =====================================================
   VALUES
===================================================== */

$values = [

    $institution,
    $centre_code,
    $department,
    $unit_number,
    $report_date,
    $first_diagnosis_date,

    $case_registered_through,
    $referral_type,
    $referral_facility,
    $referral_city,
    $referral_district,
    $referral_pin,

    $first_name,
    $middle_name,
    $last_name,
    $age,
    $dob,
    $gender,

    $aadhaar,
    $abha_id,
    $health_scheme,
    $id_status,

    $next_kin_relation,
    $next_kin_name,
    $next_kin_mobile,

    $residence_type,
    $house_no,
    $street_name,
    $locality,
    $ward,
    $city,
    $sub_district,
    $district,
    $pin,
    $state,
    $mobile,
    $mobile2,
    $email,
    $residence_duration,

    $permanent_village,
    $permanent_city,
    $permanent_district,
    $permanent_pin,
    $permanent_state,

    $marital_status,
    $education,

    $smoking,
    $smoking_duration,
    $smokeless,
    $smokeless_duration,
    $betelnut_tobacco,
    $betelnut_tobacco_duration,
    $betelnut,
    $betelnut_duration,
    $alcohol,
    $alcohol_duration,

    $tuberculosis,
    $hypertension,
    $diabetes,
    $ischemic_heart,
    $copd,
    $stroke,
    $depression,
    $hepatitis_b,
    $hepatitis_c,
    $nafld,
    $kidney_disease,
    $hiv,
    $hypothyroidism,
    $other_comorbidity,

    $height,
    $weight,

    $family_cancer_history,
    $family_cancer_type,
    $family_relation,
    $family_cancer_site,
    $family_cancer_age,
    $family_cancer_date
];


/* =====================================================
   CREATE PLACEHOLDERS
===================================================== */

$placeholders = implode(
    ", ",
    array_fill(0, count($values), "?")
);


$sql = "INSERT INTO patients (" .
       implode(", ", $columns) .
       ") VALUES (" .
       $placeholders .
       ")";


/* =====================================================
   PREPARE
===================================================== */

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {

    die(
        "Prepare Error: " .
        mysqli_error($conn)
    );

}


/* =====================================================
   BIND PARAMETERS
===================================================== */

$types = str_repeat("s", count($values));

$params = [];

$params[] = $types;

foreach ($values as $key => $value) {

    $params[] = &$values[$key];

}

call_user_func_array(
    [$stmt, 'bind_param'],
    $params
);


/* =====================================================
   EXECUTE PATIENT INSERT
===================================================== */

if (mysqli_stmt_execute($stmt)) {

    /*
       MySQL has now created the patient's ID.
    */

    $patient_id = mysqli_insert_id($conn);


    /* =================================================
       AUTOMATIC HBCR NUMBER
    ================================================= */

    $hbcr_no = "HBCR-" . str_pad(
        $patient_id,
        3,
        "0",
        STR_PAD_LEFT
    );


    /* =================================================
       AUTOMATIC HOSPITAL REGISTRATION NUMBER
    ================================================= */

    $hospital_no = "HOSP-" . str_pad(
        $patient_id,
        3,
        "0",
        STR_PAD_LEFT
    );


    /* =================================================
       UPDATE GENERATED NUMBERS
    ================================================= */

    $update_sql = "
        UPDATE patients
        SET
            hbcr_no = ?,
            hospital_no = ?
        WHERE id = ?
    ";

    $update_stmt = mysqli_prepare(
        $conn,
        $update_sql
    );

    if (!$update_stmt) {

        die(
            "Number Generation Error: " .
            mysqli_error($conn)
        );

    }


    mysqli_stmt_bind_param(
        $update_stmt,
        "ssi",
        $hbcr_no,
        $hospital_no,
        $patient_id
    );


    if (!mysqli_stmt_execute($update_stmt)) {

        die(
            "Number Update Error: " .
            mysqli_stmt_error($update_stmt)
        );

    }


    mysqli_stmt_close($update_stmt);


    /* =================================================
       GO TO REGISTRATION RECEIPT
    ================================================= */

    header(
        "Location: registration_receipt.php?id=" .
        $patient_id
    );

    exit;

}
else {

    echo "<script>

        alert('Database Error: " .
        addslashes(mysqli_stmt_error($stmt)) .
        "');

        window.history.back();

    </script>";

}


mysqli_stmt_close($stmt);

?>
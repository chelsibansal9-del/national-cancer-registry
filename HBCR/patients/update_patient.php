<?php

include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: patient_list.php");
    exit;
}

function post($name)
{
    return isset($_POST[$name]) ? trim($_POST[$name]) : "";
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    echo "<script>
        alert('Invalid Patient ID');
        window.location='patient_list.php';
    </script>";
    exit;
}


/* =====================================================
   GET VALUES FROM EDIT FORM
===================================================== */

$institution = post('institution');
$centre_code = post('centre_code');
$department = post('department');
$unit_number = post('unit_number');
$hospital_no = post('hospital_no');
$report_date = post('report_date');
$first_diagnosis_date = post('first_diagnosis_date');

$first_name = post('first_name');
$middle_name = post('middle_name');
$last_name = post('last_name');
$age = post('age');
$dob = post('dob');
$gender = post('gender');

$case_registered_through = post('case_registered_through');
$referral_type = post('referral_type');
$referral_facility = post('referral_facility');
$referral_city = post('referral_city');
$referral_district = post('referral_district');
$referral_pin = post('referral_pin');

$aadhaar = post('aadhaar');
$abha_id = post('abha_id');
$health_scheme = post('health_scheme');
$id_status = post('id_status');

$next_kin_relation = post('next_kin_relation');
$next_kin_name = post('next_kin_name');
$next_kin_mobile = post('next_kin_mobile');

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

$permanent_village = post('permanent_village');
$permanent_city = post('permanent_city');
$permanent_district = post('permanent_district');
$permanent_pin = post('permanent_pin');
$permanent_state = post('permanent_state');

$marital_status = post('marital_status');
$education = post('education');

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

$height = post('height');
$weight = post('weight');

$family_cancer_history = post('family_cancer_history');
$family_cancer_type = post('family_cancer_type');
$family_relation = post('family_relation');
$family_cancer_site = post('family_cancer_site');
$family_cancer_age = post('family_cancer_age');
$family_cancer_date = post('family_cancer_date');


/* =====================================================
   VALIDATION
===================================================== */

if ($first_name === "" || $gender === "") {

    echo "<script>
        alert('First Name and Sex are mandatory.');
        window.history.back();
    </script>";

    exit;
}


/* =====================================================
   UPDATE PATIENT
===================================================== */

$sql = "UPDATE patients SET

institution = ?,
centre_code = ?,
department = ?,
unit_number = ?,
hospital_no = ?,
report_date = ?,
first_diagnosis_date = ?,

first_name = ?,
middle_name = ?,
last_name = ?,
age = ?,
dob = ?,
gender = ?,

case_registered_through = ?,
referral_type = ?,
referral_facility = ?,
referral_city = ?,
referral_district = ?,
referral_pin = ?,

aadhaar = ?,
abha_id = ?,
health_scheme = ?,
id_status = ?,

next_kin_relation = ?,
next_kin_name = ?,
next_kin_mobile = ?,

residence_type = ?,
house_no = ?,
street_name = ?,
locality = ?,
ward = ?,
city = ?,
sub_district = ?,
district = ?,
pin = ?,
state = ?,
mobile = ?,
mobile2 = ?,
email = ?,
residence_duration = ?,

permanent_village = ?,
permanent_city = ?,
permanent_district = ?,
permanent_pin = ?,
permanent_state = ?,

marital_status = ?,
education = ?,

smoking = ?,
smoking_duration = ?,
smokeless = ?,
smokeless_duration = ?,
betelnut_tobacco = ?,
betelnut_tobacco_duration = ?,
betelnut = ?,
betelnut_duration = ?,
alcohol = ?,
alcohol_duration = ?,

tuberculosis = ?,
hypertension = ?,
diabetes = ?,
ischemic_heart = ?,
copd = ?,
stroke = ?,
depression = ?,
hepatitis_b = ?,
hepatitis_c = ?,
nafld = ?,
kidney_disease = ?,
hiv = ?,
hypothyroidism = ?,
other_comorbidity = ?,

height = ?,
weight = ?,

family_cancer_history = ?,
family_cancer_type = ?,
family_relation = ?,
family_cancer_site = ?,
family_cancer_age = ?,
family_cancer_date = ?

WHERE id = ?";


$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Prepare Error: " . mysqli_error($conn));
}


/* =====================================================
   VALUES
===================================================== */

$values = [

    $institution,
    $centre_code,
    $department,
    $unit_number,
    $hospital_no,
    $report_date,
    $first_diagnosis_date,

    $first_name,
    $middle_name,
    $last_name,
    $age,
    $dob,
    $gender,

    $case_registered_through,
    $referral_type,
    $referral_facility,
    $referral_city,
    $referral_district,
    $referral_pin,

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
    $family_cancer_date,

    $id
];


/* =====================================================
   BIND ALL AS STRING
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
   EXECUTE
===================================================== */

if (mysqli_stmt_execute($stmt)) {

    echo "<script>

        alert('Patient Updated Successfully');

        window.location='view_patient.php?id=$id';

    </script>";

} else {

    $error = addslashes(mysqli_stmt_error($stmt));

    echo "<script>

        alert('Database Error: $error');

        window.history.back();

    </script>";
}


mysqli_stmt_close($stmt);

?>
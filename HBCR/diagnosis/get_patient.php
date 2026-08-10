<?php

include("../config/database.php");

header("Content-Type: application/json");

if (!isset($_GET['aadhaar']) || trim($_GET['aadhaar']) === "") {
    echo json_encode([
        "success" => false,
        "message" => "Aadhaar number is required."
    ]);
    exit;
}

$aadhaar = trim($_GET['aadhaar']);

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        id,
        aadhaar,
        abha_id,
        hbcr_no,
        hospital_no,
        first_name,
        middle_name,
        last_name,
        age,
        gender,
        mobile,
        house_no,
        street_name,
        locality,
        ward,
        city,
        sub_district,
        district,
        pin,
        state
     FROM patients
     WHERE aadhaar = ?
     LIMIT 1"
);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Database prepare error."
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $aadhaar);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {

    echo json_encode([
        "success" => false,
        "message" => "No patient found with this Aadhaar number."
    ]);

    mysqli_stmt_close($stmt);
    exit;
}

$patient = mysqli_fetch_assoc($result);


/* =====================================================
   PATIENT NAME
===================================================== */

$patient["patient_name"] = trim(
    ($patient["first_name"] ?? "") . " " .
    ($patient["middle_name"] ?? "") . " " .
    ($patient["last_name"] ?? "")
);


/* =====================================================
   ADDRESS — ONE LINE
===================================================== */

$address_parts = [];

$address_fields = [
    "house_no",
    "street_name",
    "locality",
    "ward",
    "city",
    "sub_district",
    "district",
    "pin",
    "state"
];

foreach ($address_fields as $field) {

    if (
        isset($patient[$field]) &&
        trim($patient[$field]) !== ""
    ) {

        $address_parts[] = trim($patient[$field]);

    }
}

$patient["address_one_line"] = implode(
    ", ",
    $address_parts
);


/* =====================================================
   RESPONSE
===================================================== */

echo json_encode([
    "success" => true,
    "patient" => $patient
]);

mysqli_stmt_close($stmt);

?>
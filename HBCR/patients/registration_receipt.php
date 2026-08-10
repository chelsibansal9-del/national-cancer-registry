<?php
include("../config/database.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Patient ID");
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM patients WHERE id=$id");

if (!$result || mysqli_num_rows($result) == 0) {
    die("Patient not found");
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>

<title>Patient Registration Receipt</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body {
    background: #f5f5f5;
}

.receipt {
    width: 650px;
    margin: 30px auto;
    background: white;
    padding: 30px;
    border: 2px solid #0d6efd;
}

@media print {
    button,
    .no-print {
        display: none !important;
    }

    body {
        background: white;
    }

    .receipt {
        border: none;
        margin: 0 auto;
    }
}

</style>

</head>

<body>

<div class="receipt">

<div class="text-center">

<img src="../assets/images/hbcr-final.png" width="100">

<h3>Hospital Based Cancer Registry</h3>

<h5>Patient Registration Receipt</h5>

<hr>

</div>


<table class="table table-bordered">

<tr>
    <th>HBCR Registration No.</th>
    <td><?php echo htmlspecialchars($row['hbcr_no']); ?></td>
</tr>

<tr>
    <th>Patient Name</th>
    <td>
        <?php
        echo htmlspecialchars(
            trim(
                $row['first_name'] . " " .
                $row['middle_name'] . " " .
                $row['last_name']
            )
        );
        ?>
    </td>
</tr>

<tr>
    <th>Age</th>
    <td><?php echo htmlspecialchars($row['age']); ?></td>
</tr>

<tr>
    <th>Sex</th>
    <td><?php echo htmlspecialchars($row['gender']); ?></td>
</tr>

<tr>
    <th>Hospital Registration No.</th>
    <td><?php echo htmlspecialchars($row['hospital_no']); ?></td>
</tr>

<tr>
    <th>Date of Reporting</th>
    <td><?php echo htmlspecialchars($row['report_date']); ?></td>
</tr>

</table>


<div class="text-center mt-4 no-print">

<button onclick="window.print()" class="btn btn-primary">
    <i class="fa fa-print"></i> Print Receipt
</button>

<a href="patient_list.php" class="btn btn-success">
    Patient List
</a>

</div>

</div>

</body>
</html>
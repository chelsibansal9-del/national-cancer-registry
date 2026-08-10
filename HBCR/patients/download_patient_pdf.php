<?php

include("../config/database.php");

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid patient ID.");
}

$sql = "SELECT * FROM patients WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Patient not found.");
}

$patient = mysqli_fetch_assoc($result);

$fullName = trim(($patient['first_name'] ?? '') . ' ' . ($patient['middle_name'] ?? '') . ' ' . ($patient['last_name'] ?? ''));
$gender = $patient['gender'] ?? 'Not Added';
$dob = $patient['dob'] ?? 'Not Added';
$mobile = $patient['mobile'] ?? 'Not Added';
$hbcrNo = $patient['hbcr_no'] ?? 'Not Added';
$hospitalNo = $patient['hospital_no'] ?? 'Not Added';
$department = $patient['department'] ?? 'Not Added';
$reportDate = $patient['report_date'] ?? 'Not Added';

$diagnosisSql = "SELECT diagnosis, diagnosis_date, primary_site, stage FROM diagnosis WHERE patient_id = $id ORDER BY id DESC LIMIT 1";
$diagnosisResult = mysqli_query($conn, $diagnosisSql);
$diagnosisRecord = null;
if ($diagnosisResult && mysqli_num_rows($diagnosisResult) > 0) {
    $diagnosisRecord = mysqli_fetch_assoc($diagnosisResult);
}

$doctorName = 'Medical Officer';
$treatmentQuery = mysqli_query($conn, "SELECT doctor FROM treatment WHERE patient_id = $id ORDER BY id DESC LIMIT 1");
if ($treatmentQuery && mysqli_num_rows($treatmentQuery) > 0) {
    $treatmentRecord = mysqli_fetch_assoc($treatmentQuery);
    $docName = trim((string) ($treatmentRecord['doctor'] ?? ''));
    if ($docName !== '') {
        $doctorName = $docName;
    }
}

$signatureData = '';
$signatureQuery = mysqli_query($conn, "SELECT digital_signature FROM followup WHERE patient_id = $id AND digital_signature <> '' ORDER BY id DESC LIMIT 1");
if ($signatureQuery && mysqli_num_rows($signatureQuery) > 0) {
    $signatureRecord = mysqli_fetch_assoc($signatureQuery);
    $signatureData = trim($signatureRecord['digital_signature'] ?? '');
}

function pdf_escape($text) {
    return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
}

function pdf_text($x, $y, $size, $text, $color = '0 0 0') {
    return "$color rg\nBT /F1 $size Tf 1 0 0 1 $x $y Tm (" . pdf_escape($text) . ") Tj ET\n";
}

function pdf_rect($x, $y, $w, $h, $color) {
    return "$color rg\n$x $y $w $h re f\n";
}

function pdf_line($x1, $y1, $x2, $y2, $color, $width = 1) {
    return "$color RG\n$width w\n$x1 $y1 m $x2 $y2 l S\n";
}

function pdf_image_from_png($pngData) {
    if (!function_exists('gzuncompress') && !function_exists('gzinflate')) {
        return null;
    }

    if (substr($pngData, 0, 8) !== "\x89PNG\r\n\x1A\n") {
        return null;
    }

    $offset = 8;
    $width = $height = $bitDepth = $colorType = null;
    $idat = '';

    while ($offset + 8 <= strlen($pngData)) {
        $len = unpack('N', substr($pngData, $offset, 4))[1];
        $type = substr($pngData, $offset + 4, 4);
        $data = substr($pngData, $offset + 8, $len);

        if ($type === 'IHDR') {
            $hdr = unpack('Nwidth/Nheight/CbitDepth/CcolorType/Ccompression/Cfilter/Cinterlace', $data);
            $width = $hdr['width'];
            $height = $hdr['height'];
            $bitDepth = $hdr['bitDepth'];
            $colorType = $hdr['colorType'];
            if ($bitDepth !== 8 || !in_array($colorType, [2, 6], true)) {
                return null;
            }
        } elseif ($type === 'IDAT') {
            $idat .= $data;
        } elseif ($type === 'IEND') {
            break;
        }

        $offset += 12 + $len;
    }

    if (!$width || !$height || $idat === '') {
        return null;
    }

    $decoded = @gzuncompress($idat);
    if ($decoded === false) {
        $decoded = @gzinflate($idat);
        if ($decoded === false) {
            return null;
        }
    }

    $bytesPerPixel = $colorType === 6 ? 4 : 3;
    $rowBytes = $bytesPerPixel * $width;
    $raw = '';
    $prevRecon = str_repeat("\0", $rowBytes);
    $pos = 0;

    for ($y = 0; $y < $height; $y++) {
        if ($pos >= strlen($decoded)) {
            return null;
        }

        $filter = ord($decoded[$pos++]);
        $scanline = substr($decoded, $pos, $rowBytes);
        if (strlen($scanline) !== $rowBytes) {
            return null;
        }
        $pos += $rowBytes;

        $recon = str_repeat("\0", $rowBytes);

        for ($x = 0; $x < $rowBytes; $x++) {
            $cur = ord($scanline[$x]);
            $left = $x >= $bytesPerPixel ? ord($recon[$x - $bytesPerPixel]) : 0;
            $up = $y > 0 ? ord($prevRecon[$x]) : 0;
            $upLeft = ($x >= $bytesPerPixel && $y > 0) ? ord($prevRecon[$x - $bytesPerPixel]) : 0;

            switch ($filter) {
                case 0:
                    $val = $cur;
                    break;
                case 1:
                    $val = ($cur + $left) & 0xFF;
                    break;
                case 2:
                    $val = ($cur + $up) & 0xFF;
                    break;
                case 3:
                    $val = ($cur + (int) floor(($left + $up) / 2)) & 0xFF;
                    break;
                case 4:
                    $p = $left + $up - $upLeft;
                    $pa = abs($p - $left);
                    $pb = abs($p - $up);
                    $pc = abs($p - $upLeft);
                    if ($pa <= $pb && $pa <= $pc) {
                        $paeth = $left;
                    } elseif ($pb <= $pc) {
                        $paeth = $up;
                    } else {
                        $paeth = $upLeft;
                    }
                    $val = ($cur + $paeth) & 0xFF;
                    break;
                default:
                    return null;
            }

            $recon[$x] = chr($val);
        }

        if ($colorType === 6) {
            for ($x = 0; $x < $width; $x++) {
                $r = ord($recon[$x * 4]);
                $g = ord($recon[$x * 4 + 1]);
                $b = ord($recon[$x * 4 + 2]);
                $a = ord($recon[$x * 4 + 3]) / 255;
                $r = (int) round($r * $a + 255 * (1 - $a));
                $g = (int) round($g * $a + 255 * (1 - $a));
                $b = (int) round($b * $a + 255 * (1 - $a));
                $raw .= chr($r) . chr($g) . chr($b);
            }
        } else {
            $raw .= $recon;
        }

        $prevRecon = $recon;
    }

    $compressed = gzcompress($raw);
    return [
        'data' => $compressed,
        'width' => $width,
        'height' => $height,
        'length' => strlen($compressed),
    ];
}

function build_pdf($stream, $imageObject = null) {
    $objects = [];
    $objects[] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
    $objects[] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";

    $resource = "<< /Font << /F1 4 0 R >>";
    if ($imageObject) {
        $resource .= " /XObject << /SigImg 5 0 R >>";
    }
    $resource .= " >>";

    $contentRef = $imageObject ? 6 : 5;
    $objects[] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources $resource /Contents $contentRef 0 R >>\nendobj\n";
    $objects[] = "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

    if ($imageObject) {
        $objects[] = "5 0 obj\n<< /Type /XObject /Subtype /Image /Width " . $imageObject['width'] . " /Height " . $imageObject['height'] . " /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /FlateDecode /Length " . $imageObject['length'] . " >>\nstream\n" . $imageObject['data'] . "\nendstream\nendobj\n";
    }

    $objects[] = "{$contentRef} 0 obj\n<< /Length " . strlen($stream) . " >>\nstream\n" . $stream . "endstream\nendobj\n";

    $pdf = "%PDF-1.4\n";
    $offsets = [];
    foreach ($objects as $object) {
        $offsets[] = strlen($pdf);
        $pdf .= $object;
    }

    $xrefStart = strlen($pdf);
    $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
    $pdf .= sprintf("%010d %05d f \n", 0, 65535);
    for ($i = 0; $i < count($objects); $i++) {
        $pdf .= sprintf("%010d %05d n \n", $offsets[$i], 0);
    }
    $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
    $pdf .= "startxref\n" . $xrefStart . "\n%%EOF";

    return $pdf;
}

$signatureImageObject = null;
if ($signatureData !== '') {
    if (preg_match('/^data:image\/(png|jpeg|jpg);base64,(.+)$/i', $signatureData, $matches)) {
        $decoded = base64_decode($matches[2]);
        if ($decoded !== false) {
            $signatureImageObject = pdf_image_from_png($decoded);
        }
    }
}

$stream = '';
$stream .= pdf_rect(36, 700, 540, 80, '0.91 0.98 0.93');
$stream .= pdf_text(48, 760, 22, 'ONCOLOGY DEPARTMENT', '0 0.33 0.16');
$stream .= pdf_text(48, 740, 11, 'Patient Medical Summary Report', '0 0.40 0.24');
$stream .= pdf_rect(380, 720, 190, 30, '0.79 0.93 0.83');
$stream .= pdf_text(388, 736, 8, 'HBCR: ' . $hbcrNo, '0 0.24 0.11');
$stream .= pdf_rect(380, 690, 190, 30, '0.79 0.93 0.83');
$stream .= pdf_text(388, 706, 8, 'HOSP REG: ' . $hospitalNo, '0 0.24 0.11');

$stream .= pdf_text(48, 675, 14, 'PATIENT INFORMATION', '0 0.33 0.16');
$stream .= pdf_text(48, 658, 10, 'Patient Details', '0 0.47 0.26');

$stream .= pdf_text(48, 640, 9, 'PATIENT NAME', '0 0.36 0.18');
$stream .= pdf_text(48, 626, 11, $fullName ?: 'Not Added');
$stream .= pdf_text(300, 640, 9, 'GENDER', '0 0.36 0.18');
$stream .= pdf_text(300, 626, 11, $gender);
$stream .= pdf_text(48, 604, 9, 'DATE OF BIRTH', '0 0.36 0.18');
$stream .= pdf_text(48, 590, 11, $dob);
$stream .= pdf_text(300, 604, 9, 'MOBILE NUMBER', '0 0.36 0.18');
$stream .= pdf_text(300, 590, 11, $mobile);
$stream .= pdf_text(48, 568, 9, 'DEPARTMENT', '0 0.36 0.18');
$stream .= pdf_text(48, 554, 11, $department);
$stream .= pdf_text(300, 568, 9, 'REPORTING DATE', '0 0.36 0.18');
$stream .= pdf_text(300, 554, 11, $reportDate);

$stream .= pdf_text(48, 525, 14, 'CLINICAL SUMMARY', '0 0.33 0.16');
$stream .= pdf_text(48, 508, 10, 'Summary Table', '0 0.47 0.26');
$stream .= pdf_line(48, 500, 560, 500, '0.60 0.72 0.64', 1);
$stream .= pdf_line(48, 470, 560, 470, '0.60 0.72 0.64', 1);
$stream .= pdf_line(48, 500, 48, 470, '0.60 0.72 0.64', 1);
$stream .= pdf_line(170, 500, 170, 470, '0.60 0.72 0.64', 1);
$stream .= pdf_line(330, 500, 330, 470, '0.60 0.72 0.64', 1);
$stream .= pdf_line(470, 500, 470, 470, '0.60 0.72 0.64', 1);
$stream .= pdf_line(560, 500, 560, 470, '0.60 0.72 0.64', 1);
$stream .= pdf_text(55, 486, 9, 'Anatomical Site', '0 0.24 0.11');
$stream .= pdf_text(175, 486, 9, 'Diagnosis Date', '0 0.24 0.11');
$stream .= pdf_text(340, 486, 9, 'Organ System', '0 0.24 0.11');
$stream .= pdf_text(475, 486, 9, 'Clinical Stage', '0 0.24 0.11');

if ($diagnosisRecord) {
    $site = $diagnosisRecord['primary_site'] ?? 'Not Added';
    $diagDate = $diagnosisRecord['diagnosis_date'] ?? 'Not Added';
    $stage = $diagnosisRecord['stage'] ?? 'Not Specified';
    $stageText = $stage !== '' ? $stage : 'Not Specified';
    $stream .= pdf_text(55, 478, 10, $site);
    $stream .= pdf_text(175, 478, 10, $diagDate);
    $stream .= pdf_text(340, 478, 10, $site);
    $stream .= pdf_text(475, 478, 10, $stageText);
} else {
    $stream .= pdf_text(48, 478, 10, 'No diagnosis records found.', '0 0 0');
}

$stream .= pdf_text(48, 425, 14, 'SIGNATURE BLOCK', '0 0.33 0.16');
$stream .= pdf_text(48, 388, 10, 'Report Generated By', '0 0.36 0.18');
$stream .= pdf_text(300, 388, 10, 'Authorized Consultant / Oncologist', '0 0.36 0.18');
$stream .= pdf_text(300, 375, 9, 'Digital Signature', '0 0.36 0.18');
$stream .= pdf_line(48, 365, 200, 365, '0.23 0.42 0.25', 0.8);
$stream .= pdf_line(300, 365, 552, 365, '0.23 0.42 0.25', 0.8);
$stream .= pdf_text(48, 355, 10, 'Oncology Records System');
$stream .= pdf_text(300, 355, 10, $doctorName);

if ($signatureImageObject) {
    $displayWidth = 120;
    $displayHeight = (int) round($signatureImageObject['height'] * ($displayWidth / $signatureImageObject['width']));
    $imageX = 300;
    $imageY = 410;
    $stream .= "q\n$displayWidth 0 0 $displayHeight $imageX $imageY cm /SigImg Do\nQ\n";
}

$stream .= pdf_text(48, 350, 8, 'Confidential Medical Document: This document contains confidential patient healthcare information intended solely for authorized medical use.', '0 0.38 0.24');

$pdfData = build_pdf($stream, $signatureImageObject);

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="patient_' . $id . '.pdf"');
header('Pragma: no-cache');
header('Expires: 0');
echo $pdfData;
exit;

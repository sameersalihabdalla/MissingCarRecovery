<?php
require_once "db.php"; // الاتصال بقاعدة البيانات
require_once "../vendor/autoload.php"; // تحميل مكتبات OCR و PHPMailer

use thiagoalessio\TesseractOCR\TesseractOCR;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * استخراج رقم الهيكل (VIN) من صورة السيارة باستخدام OCR
 */
function extractVIN($imagePath) {
    $ocr = new TesseractOCR($imagePath);
    $ocr->lang('eng'); // التأكد من اللغة المستخدمة
    return $ocr->run(); // استخراج رقم VIN
}

/**
 * استخراج بيانات السيارة بناءً على رقم VIN باستخدام API
 */
function decodeVIN($vin) {
    $apiUrl = "https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvalues/" . $vin . "?format=json";
    $data = json_decode(file_get_contents($apiUrl), true);

    return [
        "make" => $data["Results"][0]["Make"] ?? "غير متوفر",
        "model" => $data["Results"][0]["Model"] ?? "غير متوفر",
        "year" => $data["Results"][0]["ModelYear"] ?? "غير متوفر",
        "color" => "غير متوفر"
    ];
}

/**
 * إرسال إشعار بالبريد الإلكتروني عند العثور على سيارة
 */
function sendNotification($email, $carDetails) {
    $mail = new PHPMailer(true);
    try {
        $mail->setFrom("no-reply@cartracker.com", "Car Tracking System");
        $mail->addAddress($email);
        $mail->Subject = "تم العثور على سيارتك!";
        $mail->Body = "لقد تم العثور على سيارتك: " . implode(", ", $carDetails);
        $mail->send();
        return "تم إرسال الإشعار!";
    } catch (Exception $e) {
        return "خطأ: " . $mail->ErrorInfo;
    }
}

/**
 * جلب قائمة المحليات بناءً على الولاية المختارة
 */
function getLocalities($state_id) {
    global $conn;
    $query = $conn->prepare("SELECT * FROM localities WHERE state_id = ?");
    $query->bind_param("i", $state_id);
    $query->execute();
    $result = $query->get_result();

    $localities = [];
    while ($row = $result->fetch_assoc()) {
        $localities[] = $row;
    }
    return $localities;
}
?>

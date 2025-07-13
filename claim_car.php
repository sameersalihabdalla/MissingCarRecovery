<?php
if (isset($_GET['report_id'])) {
    $report_id = $_GET['report_id'];

    // نص الرسالة
    $message = "أنا صاحب السيارة بالبلاغ رقم $report_id";
    $phone = "249999249900"; // رقم الهاتف المرسل إليه

    // إعادة توجيه إلى واتساب
    header("Location: https://wa.me/$phone?text=" . urlencode($message));
    exit();
}
?>

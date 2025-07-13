<?php
include 'db_connection.php';

if (isset($_GET['report_id'])) {
    $report_id = $_GET['report_id'];

    // تحديث حالة البلاغ أو تنفيذ أي عملية تأكيد مطلوبة
    echo "تم تأكيد البلاغ رقم $report_id.<br>";
    echo "تم إرسال الموقع الجغرافي إلى الجهات المعنية.";
}
?>

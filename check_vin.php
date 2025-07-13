<?php
include("db_connection.php");

$vin = isset($_GET['vin']) ? trim($_GET['vin']) : '';

if (strlen($vin) < 3) {
    echo '';
    exit;
}

$stmt = $conn->prepare("SELECT plate_number, manufactor, reporter_name, reporter_phone, p_date FROM cars WHERE vin = ? LIMIT 1");
$stmt->bind_param("s", $vin);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo '<span class="text-danger small">🚨 موجود مسبقًا: ';
    echo 'اللوحة: ' . htmlspecialchars($row['plate_number']) . ' | ';
    echo 'الماركة: ' . htmlspecialchars($row['manufactor']) . ' | ';
    echo 'المبلّغ: ' . htmlspecialchars($row['reporter_name']) . ' | ';
    echo '📞 ' . htmlspecialchars($row['reporter_phone']) . ' | ';
    echo '📅 ' . htmlspecialchars($row['p_date']);
    echo '</span>';
} else {
    echo '<span class="text-success small">✅ غير مضاف</span>';
}

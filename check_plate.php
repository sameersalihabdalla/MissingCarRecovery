<?php
include("db_connection.php");

$plate = isset($_GET['plate']) ? trim($_GET['plate']) : '';

if (strlen($plate) < 3) {
    echo '';
    exit;
}

$stmt = $conn->prepare("SELECT vin, manufactor, reporter_name, reporter_phone, p_date FROM cars WHERE plate_number = ? LIMIT 1");
$stmt->bind_param("s", $plate);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo '<span class="text-danger small">🚨 موجود مسبقًا: ';
    echo 'الشاسي: ' . htmlspecialchars($row['vin']) . ' | ';
    echo 'الماركة: ' . htmlspecialchars($row['manufactor']) . ' | ';
    echo 'المبلّغ: ' . htmlspecialchars($row['reporter_name']) . ' | ';
    echo '📞 ' . htmlspecialchars($row['reporter_phone']) . ' | ';
    echo '📅 ' . htmlspecialchars($row['p_date']);
    echo '</span>';
} else {
    echo '<span class="text-success small">✅ غير مضافة</span>';
}

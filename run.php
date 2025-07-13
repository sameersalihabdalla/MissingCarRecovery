<?php
$admin_password = "123321"; // غيّرها إلى كلمة سر قوية


echo'<br>INSERT INTO cars (vin, plate_number, color, manufactor, description, reporter_phone, p_date, model) VALUES</br>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['password'] !== $admin_password) {
        die("❌ كلمة المرور غير صحيحة.");
    }

    $sql = trim($_POST['sql_query'] ?? '');

    // التحقق من أن الاستعلام يبدأ بـ INSERT فقط
    if (!preg_match('/^INSERT\s+/i', $sql)) {
        die("❌ مسموح فقط باستعلامات INSERT.");
    }

    // استدعاء الاتصال من ملف خارجي
    require_once 'db_connection.php';

    if ($conn->query($sql) === TRUE) {
        echo "✅ تم تنفيذ استعلام INSERT بنجاح.";
    } else {
        echo "❌ خطأ في الاستعلام: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تنفيذ استعلام INSERT</title>
</head>
<body>
    <h2>🛠️ تنفيذ استعلام INSERT فقط</h2>
    <form method="post">
        <label>🔑 كلمة المرور:</label><br>
        <input type="password" name="password" required><br><br>

        <label>📝 استعلام INSERT:</label><br>
        <textarea name="sql_query" rows="6" cols="60" placeholder="مثال: INSERT INTO users (name, email) VALUES ('Samir', 'samir@example.com');" required></textarea><br><br>

        <button type="submit">تنفيذ</button>
    </form>
</body>
</html>

<?php
if ($_FILES['car_image']['error'] === 0) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir);

    $imageName = uniqid() . '_' . basename($_FILES['car_image']['name']);
    $imagePath = $uploadDir . $imageName;

    move_uploaded_file($_FILES['car_image']['tmp_name'], $imagePath);

    // تشغيل سكريبت Python
    $command = escapeshellcmd("python analyze.py $imagePath");
    $output = shell_exec($command);

    echo "<h2>📋 النتائج:</h2><pre>$output</pre>";
    echo "<img src='$imagePath' width='300'>";
} else {
    echo "❌ حدث خطأ أثناء رفع الصورة.";
}
?>

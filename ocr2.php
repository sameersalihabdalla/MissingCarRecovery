<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تحليل بيانات السيارات السودانية</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; direction: rtl; padding: 20px; background: #f9f9f9; }
        textarea, input { width: 100%; font-family: monospace; padding: 10px; margin-top: 10px; }
        button { padding: 10px 20px; font-size: 16px; margin-top: 10px; }
        .ltr-output textarea { direction: ltr; text-align: left; height: 300px; background: #fff; }
    </style>
</head>
<body>

<h2>📋 أدخل الكشف:</h2>
<form method="post">
    <label>الكشف:</label>
    <textarea name="raw_data" rows="15" placeholder="مثال:&#10;أفانتي موديل 2014 شاسي 234792 لوحة 10925/خ5"></textarea>
    
    <label>📞 رقم الهاتف:</label>
    <input type="text" name="reporter_phone" placeholder="مثال: 092xxxxxxx">
    
    <label>🧑‍💼 اسم الناشر:</label>
    <input type="text" name="reporter_name" placeholder="مثال: محمد أحمد">
    
    <button type="submit">🛠️ توليد أوامر SQL</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['raw_data'])) {
    $lines = explode("\n", $_POST['raw_data']);
    $sql_preview = [];

    // بيانات الناشر
    $reporter_phone = isset($_POST['reporter_phone']) ? trim($_POST['reporter_phone']) : '-';
    $reporter_name = isset($_POST['reporter_name']) ? trim($_POST['reporter_name']) : '-';

    // قائمة الأنواع/الماركات الشائعة
    $manufactors = ['برادو','كورولا','اكسنت','النترا','سوناتا','توسان','كلك','مورنينق','مورينيق','ركشة','تكتك','فيرنا','افانتي','i10','i20','اسبورتاج','لانسر','مورنق','سنتافي','اوبتيما','بوكس','دبدوب','BYD','تويوتا','هيونداي','كيا','ميتسوبيشي','نيسان','جياد','سوزوكي','شيري','فورد','هوندا','مازدا','جيلي'];

    $colors = ['أبيض','ابيض','أسود','اسود','سوداء','سودا','أحمر','أزرق','أخضر','رمادي','فضي','ذهبي','أصفر','كبدية','بحريني'];

    $plate_patterns = '/(\d+\s?\/\s?[^\s]+)/u';

    $current = ['manufactor' => '-', 'vin' => '-', 'plate' => '-', 'model' => '-', 'color' => '-'];

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') continue;

        // شاسيه
        if (preg_match('/شاسي\s*:?[\s]*([0-9]+)/u', $line, $vin_match)) {
            $current['vin'] = $vin_match[1];
        }

        // لوحة
        if (preg_match($plate_patterns, $line, $plate_match)) {
            $current['plate'] = preg_replace('/\s+/', ' ', trim($plate_match[0]));
        }

        // شاسيه بديل إذا لم يُذكر صراحة
        if ($current['vin'] === '-') {
            if (preg_match_all('/\b\d{5,}\b/u', $line, $numbers)) {
                foreach ($numbers[0] as $num) {
                    if (strpos($line, '/') !== false) continue;
                    $current['vin'] = $num;
                    break;
                }
            }
        }

        // سنة الصنع
        if (preg_match('/موديل\s*:?[\s]*([0-9]{4})/u', $line, $year_match)) {
            $current['model'] = $year_match[1];
        }

        // اللون
        foreach ($colors as $c) {
            if (mb_stripos($line, $c) !== false) {
                $current['color'] = $c;
                break;
            }
        }

        // نوع المركبة أو الماركة
        foreach ($manufactors as $m) {
            if (mb_stripos($line, $m) !== false) {
                $current['manufactor'] = $m;
                break;
            }
        }

        // إذا وُجد شاسيه أو لوحة، نحفظ السطر
        if ($current['vin'] !== '-' || $current['plate'] !== '-') {
            $sql = sprintf(
                "INSERT INTO cars (vin, plate_number, color, manufactor, description, state, locality, reporter_phone, reporter_name, image_url1, image_url2, image_url3, p_date, model, post_link) VALUES ('%s', '%s', '%s', '%s', '-', '-', '-', '%s', '%s', '', '', '', NOW(), '%s', '');",
                addslashes($current['vin']),
                addslashes($current['plate']),
                addslashes($current['color']),
                addslashes($current['manufactor']),
                addslashes($reporter_phone),
                addslashes($reporter_name),
                addslashes($current['model'])
            );
            $sql_preview[] = $sql;

            // إعادة التهيئة
            $current = ['manufactor' => '-', 'vin' => '-', 'plate' => '-', 'model' => '-', 'color' => '-'];
        }
    }

    echo "<h3>✅ تم توليد " . count($sql_preview) . " أمر SQL:</h3>";
    echo '<div class="ltr-output"><textarea readonly>' . htmlspecialchars(implode("\n", $sql_preview)) . '</textarea></div>';
}
?>

</body>
</html>

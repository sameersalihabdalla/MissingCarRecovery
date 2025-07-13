<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تحليل صورة سيارة</title>
</head>
<body>
    <h2>📸 ارفع صورة السيارة</h2>
    <form action="result.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="car_image" accept="image/*" required>
        <button type="submit">تحليل</button>
    </form>
</body>
</html>

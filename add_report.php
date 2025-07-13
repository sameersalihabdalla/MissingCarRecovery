<!DOCTYPE html>
<?php include("texts.php"); ?>
<html lang="<?=$language_ch?>">
<head>
  <title><?=$site_name_c?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include("meta.php"); ?>
</head>
<body dir="<?=$direction?>">
<?php include("menu.php") ?>

<div class="hero-wrap hero-wrap-2" style="background-color:#4d4a45;" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-start">
      <div class="col-md-12 text-center mb-5">
        <p class="breadcrumbs mb-0"><span class="mr-3"><a href="index.php"><?=$home?> <i class="ion-ios-arrow-forward"></i></a></span> <span>إضافة تقرير</span></p>
        <h3 class="mb-3 bread">إضافة سيارة</h3>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section contact-section bg-light">
<div class="container">

<?php
include 'db_connection.php';

// ✅ دالة إضافة اللوقو والنص
function addWatermark($sourcePath) {
    $logoPath = 'img/logo.png';
    $fontPath = 'arial.ttf';
    $text = 'www.jobsagent.org';

    $image = imagecreatefromstring(file_get_contents($sourcePath));
    if (!$image) return false;

    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    $logo = imagecreatefrompng($logoPath);
    $logoWidth = imagesx($logo);
    $logoHeight = imagesy($logo);

    $logoX = $imageWidth - $logoWidth - 20;
    $logoY = $imageHeight - $logoHeight - 20;

    imagecopy($image, $logo, $logoX, $logoY, 0, 0, $logoWidth, $logoHeight);

    $fontSize = 14;
    $textColor = imagecolorallocatealpha($image, 255, 255, 255, 80);
    $textX = 20;
    $textY = $imageHeight - 30;

    imagettftext($image, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $text);
    imagejpeg($image, $sourcePath, 90);

    imagedestroy($image);
    imagedestroy($logo);
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url1 = $url2 = $url3 = "";

    function handleImageUpload($inputName, &$urlVar) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]["size"] > 0) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . date("YmdHis") . rand() . basename($_FILES[$inputName]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uploadOk = 1;

            $check = getimagesize($_FILES[$inputName]["tmp_name"]);
            if (!$check) {
                echo "❌ الملف ليس صورة.<br>";
                return;
            }

            if ($_FILES[$inputName]["size"] > 2000000) {
                echo "❌ حجم الصورة كبير جدًا.<br>";
                return;
            }

            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                echo "❌ الصيغة غير مدعومة.<br>";
                return;
            }

            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
                echo "✅ تم رفع الصورة بنجاح <br>";
                addWatermark($targetFile);
                $urlVar = "/" . $targetFile;
            } else {
                echo "❌ فشل في رفع الصورة.<br>";
            }
        }
    }

    handleImageUpload("image", $url1);
    handleImageUpload("image2", $url2);
    handleImageUpload("image3", $url3);

    // بيانات النموذج
    $vin = $_POST['vin'];
    $plate_number = $_POST['plate_number'];
    $color = $_POST['color'];
    $status = $_POST['status'];
    $model = $_POST['model'];
    $description = $_POST['description'];
    $state = $_POST['state'];
    $locality = $_POST['locality'];
    $reporter_phone = $_POST['reporter_phone'];
    $reporter_name = $_POST['reporter_name'];
    $location = $_POST['location'];
    $datee = date("Y-m-d");
    $manufactor = $_POST['manufactor'];

    $car_sql = "INSERT INTO cars (vin, plate_number, color, status, model, description, state, locality, reporter_phone, reporter_name, image_url1, image_url2, image_url3, p_date, manufactor, location) 
                VALUES ('$vin', '$plate_number', '$color', '$status', '$model', '$description', '$state', '$locality', '$reporter_phone', '$reporter_name', '$url1', '$url2', '$url3', '$datee', '$manufactor', '$location')";

    if ($conn->query($car_sql) === TRUE) {
        $car_id = $conn->insert_id;

        $report_sql = "INSERT INTO reports (car_id, reporter_phone, reporter_name, location) 
                       VALUES ('$car_id', '$reporter_phone', '$reporter_name', '$location')";

        if ($conn->query($report_sql) === TRUE) {
            echo "<label class='bg-info text-white p-3 w-100 text-center mt-3 mb-3'>✅ تم تسجيل البلاغ بنجاح!</label>";

            // نشر على فيسبوك
            include 'fb/fb_config.php';
            $access_token = include 'fb/fb_token_manager.php';

            $pages_url = "https://graph.facebook.com/me/accounts?access_token=" . $access_token;
            $pages_response = file_get_contents($pages_url);
            $pages_data = json_decode($pages_response, true);

            if (!empty($pages_data['data'])) {
                $page = $pages_data['data'][0];
                $page_id = $page['id'];
                $page_token = $page['access_token'];

                $car_link = "https://www.jobsagent.org/car_information.php?car_id=" . $car_id;
                $message = "🚗 تم إضافة سيارة جديدة على JobsAgent.org\n🔎 التفاصيل:\nالشاسي: $vin | اللوحة: $plate_number | اللون: $color | الماركة: $manufactor | الموديل: $model\n$car_link";

                $post_url = "https://graph.facebook.com/{$page_id}/feed";
                $post_data = [
                    'message' => $message,
                    'access_token' => $page_token
                ];

                $options = [
                    'http' => [
                        'method'  => 'POST',
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'content' => http_build_query($post_data)
                    ]
                ];

                $context = stream_context_create($options);
                $response = file_get_contents($post_url, false, $context);

                echo $response ? "✅ تم النشر على فيسبوك." : "❌ فشل النشر.";
            } else {
                echo "❌ لم يتم العثور على صفحات فيسبوك.";
            }
        } else {
            echo "❌ خطأ في جدول البلاغات: " . $conn->error;
        }
    } else {
        echo "❌ خطأ في جدول السيارات: " . $conn->error;
    }

    $conn->close();
}
?>

</div>
</section>

<?php include("footer.php"); ?>

<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
  <svg class="circular" width="48px" height="48px">
    <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
    <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
  </svg>
</div>

<?php include("scripts.php"); ?>
</body>
</html>

<!DOCTYPE html>
<?php  include("texts.php");  ?>
<html lang="<?=$language_ch?>">
<head>
<?php include("texts.php"); ?>
<title><?=$site_name_c?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php include("meta.php");?>
</head>
<body dir="<?=$direction?>">

<?php include("menu.php")?>

<!-- END nav -->

<div class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
<div class="overlay"></div>
<div class="container">
<div class="row no-gutters slider-text align-items-end justify-content-start">
<div class="col-md-12  text-center mb-5">
<p class="breadcrumbs mb-0"><span class="mr-3"><a href="index.php"><?=$home?> <i class="ion-ios-arrow-forward"></i></a></span> <span>حول</span></p>
<h1 class="mb-3 bread">حول</h1>
</div>
</div>
</div>
</div>

<section class="ftco-section contact-section bg-light">
<div class="container">


<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// استرجاع جميع البلاغات
$sql = "SELECT reports.*, cars.* FROM reports JOIN cars ON reports.car_id = cars.id";
$result = $conn->query($sql);

echo "<h1>لوحة تحكم المشرف</h1>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "رقم البلاغ: " . $row['report_id'] . "<br>";
        echo "رقم الهيكل: " . $row['vin'] . "<br>";
        echo "رقم اللوحة: " . $row['plate_number'] . "<br>";
        echo "لون السيارة: " . $row['color'] . "<br>";
        echo "الوصف: " . $row['description'] . "<br>";
        echo "اسم المبلغ: " . ($row['reporter_name'] ?: "غير متوفر") . "<br>";
        echo "رقم الهاتف: " . ($row['reporter_phone'] ?: "غير متوفر") . "<br>";
        echo "الموقع: " . $row['location'] . "<br>";
        echo "<a href='https://www.google.com/maps?q=".$row['location'] ."'>معاينة على الخريطة</a><br><hr>'";
    }
} else {
    echo "لا توجد بلاغات.";
}

$conn->close();
?>


</div></section>





<?php include("footer.php");?> 

<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
<?php include("scripts.php");?>


</body>
</html>









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
<p class="breadcrumbs mb-0"><span class="mr-3"><a href="index.php"><?=$home?> <i class="ion-ios-arrow-forward"></i></a></span> <span>الدخول</span></p>
<h2 class="mb-3 bread">الدخول</h2>
</div>
</div>
</div>
</div>

<section class="ftco-section contact-section bg-light">
<div class="container">
<?php
include 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
   // echo $password;

    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($password=$admin['password']) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            header("Location: admin_dashboard.php");
        } else {
            echo "كلمة المرور غير صحيحة.";
           // echo $admin['password'];
        }
    } else {
        echo "اسم المستخدم غير موجود.";
    }
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
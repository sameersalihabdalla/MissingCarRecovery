<?php
include 'db_connection.php';

// استعلام لجلب أحدث السيارات حسب الولايات
?>



<!DOCTYPE html>
<?php  include("texts.php");  ?>
<html lang="<?=$language_ch?>">
<head>
<?php include("texts.php"); ?>

<title><?=$site_name_c?> | منصة جوبز ايجنت للسيارات المفقودة</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta property="og:title" content="<?=$site_name_c?> | منصة جوبز ايجنت للسيارات المفقودة">



<meta name="keywords" content="شفشفة العربات ، مشفشف ، سرقة السيارات ،سيارت مسروق ، الخرطوم ، السودان ، الدعامه ، الجزيرة ، النيل الأبيض">
<meta name="description" content="منصة سودانية لتسهيل الوصول للعربات المفقودة في السودان">
<meta property="og:type" content="Article"> 
<meta property="og:url" content="http://www.jobsagent.com<?=$_SERVER['REQUEST_URI'] ?>">
<meta property="og:image" content="img/ms-icon-310x310.png">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@SmeerSalih">
<meta property="twitter:image" content="img/ms-icon-310x310.png">
<meta property="og:description" content="منصة سودانية لتسهيل الوصول للعربات المفقودة في السودان" />
<meta property="og:title" content="منصة جوبز ايجنت" />
<meta property="twitter:title" content="منصة جوبز ايجنت"/>
<meta property="twitter:description" content="منصة جوبز ايجنت للعثور على السيارات" />
<meta name="author" content="jobsagent.org- Sameer Salih Abdalla">





<?php include("meta.php");?>
</head>
<body dir="<?=$direction?>">

<?php include("menu.php")?>

<!-- END nav -->




<section class=" m-0"  style="background-color: #4d4a45;" >
 <div class="text-center  mt-2"
  style="background-color: #4d4a45;">  <img src="img/ms-icon-310x310.png"  class="text-center img-fluid">
</div>

<div class="container text-center ">
  
    <h2 class="text-center mb-4 " style="color:white;">ابحث برقم الشاسي أو اللوحة</h2>

    <form method="GET" action="search_form.php"  class="row g-3 mb-5">
      <div class="col-md-5">
        <label for="vin" class="form-label" style="color:white;">رقم الشاسي (VIN)</label>
        <input type="text" name="vin" id="vin" class="form-control" value="" placeholder="أدخل رقم الشاسي">
      </div>

      <div class="col-md-5">
        <label for="plate" class="form-label" style="color:white;">رقم اللوحة</label>
        <input type="text" name="plate" id="plate" class="form-control " value="" placeholder="أدخل رقم اللوحة">
      </div>ع

      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn  w-100 btn header-link hover-pulse mt-3 " style="border:solid #ccc 1px; "> <i class="ion-ios-search"></i> بحث</button>
      </div>
    </form>



<div class="mt-5 mb-5 text-center">
<h2 class="text-white"> هذه الخدمات مجانية 100%  </h2>
</div>
</div>












</div>



<style>
 

  .image-box {
    width: 30%;
    aspect-ratio: 4 / 3;
    background-color: #f1f1f1;
    border: 2px dashed #fdab44;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    position: relative;
    font-size: 16px;
    color: #999;
  }

  .image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .image-box.no-image::before {
    content: "لا توجد صورة";
    color: #999;
    text-align: center;
    padding: 10px;
  }


    .card {
      background-color: white;
      border: 2px solid var(--primary);
      border-radius: 12px;
      max-width: 700px;
      margin: auto;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      color: var(--gray-dark);
    }

    .card h2 {
      color: var(--danger);
      margin-bottom: 20px;
    }

    .item {
      margin: 8px 0;
      font-size: 18px;
    }

    .item span {
      font-weight: bold;
      color: var(--primary);
    }

    .images {
      display: flex;
      gap: 10px;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .images img {
      width: 30%;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
      border: 2px solid var(--primary);
    }

    .images img:hover {
      transform: scale(1.05);
    }

    /* Lightbox Styles */
    .lightbox {
      display: none;
      position: fixed;
      z-index: 999;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.8);
      justify-content: center;
      align-items: center;
    }

    .lightbox img {
      max-width: 90%;
      max-height: 80%;
    }
  </style>



<script>
  function openLightbox(src) {
    document.getElementById("lightbox-img").src = src;
    document.querySelector(".lightbox").style.display = "flex";
  }
</script>


</section>
<style>
  .btn-action {
    padding: 6px 12px;
    font-size: 0.875rem;
    border-radius: 8px;
    transition: all 0.2s ease-in-out;
  }

  .btn-action:hover {
    opacity: 0.9;
    transform: translateY(-1px);
  }

  .btn-share {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease-in-out;
  }

  .btn-share:hover {
    transform: scale(1.1);
    opacity: 0.9;
  }
</style>

<section class=" m-0 " >
<div class="container text-center ">
  

<div id="installBanner" class="text-center my-4" style="display: none;">
  <p class="lead mb-3">📲 احصل على تجربة أسرع وأسهل مع تطبيق JobsAgent!</p>
  <button onclick="installPWA()" class="btn btn-success btn-lg shadow-sm px-4 py-2">
    <i class="bi bi-download me-2"></i> تثبيت التطبيق الآن
  </button>
</div>

<!-- ✅ زر التثبيت داخل بانر -->
<div id="installBanner" class="text-center my-4" style="display: none;">
  <button onclick="installPWA()" class="btn btn-success btn-lg shadow-sm px-4 py-2">
    <i class="bi bi-download me-2"></i> تثبيت تطبيق JobsAgent
  </button>
</div>

<?php

$sql = "SELECT COUNT(id) AS mycount FROM cars";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// Output data of each row
while($row = $result->fetch_assoc()) {
echo'<h3 class="text-center">عدد السيارات التي تم العثور عليها حاليا : <strong class="number text-danger"><b>19537</b></strong></h3><br><hr>';
}
} else {
echo "0 results";
}

?>
</div>


<!-- قائمة عرض السيارات حسب الولايات -->

<div class="row m-0">
  <div class="container">

  <?php include("ads.php");?>

<h1 class="m-3 p-3 text-center">احدث السيارات المضافة</h1>


  </div>

<?php
$cars_by_state_sql = "SELECT * FROM cars ORDER BY id DESC LIMIT 8";
$cars_by_state_result = $conn->query($cars_by_state_sql);

if ($cars_by_state_result->num_rows > 0) {
    echo '<div class="row g-3 m-0 ">';
    

    while ($row = $cars_by_state_result->fetch_assoc()) {
        echo '<div class="col-auto col-sm-6 col-lg-3 p-1">';
        echo '<div class="card h-100  border-0  " style="background-color: #fdfdfd;">';

        echo '<div class="card-body text-end ">';
        echo '<h5 class="card-title text-danger mb-3">🚨 تم العثور على عربة مسروقة</h5>';

        echo '<ul class="list-unstyled small">';
        echo '<li>📄 <strong>البلاغ:</strong> ' . $row["id"] . '</li>';
        echo '<li>🔧 <strong>الشاسي:</strong> ' . $row["vin"] . '</li>';
        echo '<li>🪪 <strong>اللوحة:</strong> ' . $row["plate_number"] . '</li>';
        echo '<li>🎨 <strong>اللون:</strong> ' . $row["color"] . '</li>';
        echo '<li>🏭 <strong>الموديل:</strong> ' . $row["model"] . '</li>';
        echo '<li>📍 <strong>الولاية:</strong> ' . $row["state"] . '</li>';
        echo '<li>🏘️ <strong>المحلية:</strong> ' . $row["locality"] . '</li>';
        echo '<li>🗓️ <strong>النشر:</strong> ' . $row["p_date"] . '</li>';
        echo '</ul>';

        // أزرار الإجراءات
        echo '<div class="d-flex flex-wrap justify-content-center gap-2 mt-3">';
        

        echo '<a href="car_information.php?car_id=' . $row["id"] . '" class="btn btn-action text-white m-1" style="background-color: #de7f09;">📄 التفاصيل</a>';
        echo '</div>';

        // أزرار المشاركة
        echo '<div class="d-flex justify-content-center flex-wrap gap-2  mt-3">';
        $share_url = 'http://www.jobsagent.org/car_information.php?car_id=' . $row["id"];
        $vin = $row['vin'];

        $platforms = [
            'twitter' => '#1DA1F2',
            'facebook' => '#3b5998',
            'linkedin' => '#0077b5',
            'whatsapp' => '#25D366',
            'telegram' => '#0088cc'
        ];

        foreach ($platforms as $platform => $color) {
            echo '<button class="btn btn-share text-white m-1" style="background-color:' . $color . ';" data-sharer="' . $platform . '" data-title="' . $vin . '" data-hashtags="' . $vin . '" data-url="' . $share_url . '">';
            echo '<i class="icon-' . $platform . '"></i>';
            echo '</button>';
        }

        echo '</div>'; // end share buttons
        echo '</div>'; // end card-body
        echo '</div>'; // end card
        echo '</div>'; // end col
    }

    echo '</div>'; // end row
} else {
    echo "<p class='text-center'>🚫 لا توجد سيارات مسجلة حتى الآن.</p>";
}
?>

<!-- HTML ثابت في نهاية الصفحة -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
  <img id="lightbox-img" src="" alt="صورة مكبرة">
</div>

</div>
</div></div>
</div></div></section>





<?php include("footer.php");?> 

<!-- loader -->

<div id="loader-wrapper">
  <div class="loader-logo">
    <img src="img/loader.png" alt="شعار الموقع" />
  </div>
</div>


<style>


  /* تغليف كامل للشاشة */
/* الخلفية الكاملة للتحميل */
#loader-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 99%;
  height: 99%;
  background: #ffffff; /* أو أي لون يناسب هويتك */
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* الشعار النابض */
.loader-logo img {
  width: 100px;
  height: auto;
  animation: pulse 1.5s ease-in-out infinite;
}

/* تعريف حركة النبض */
@keyframes pulse {
  0%   { transform: scale(1); opacity: 1; }
  50%  { transform: scale(1.15); opacity: 0.85; }
  100% { transform: scale(1); opacity: 1; }
}






</style>



<?php include("scripts.php");?>


</body>

<!-- ✅ HTML: زر التثبيت والشعار البصري -->


<!-- ✅ إشعار بصري -->
<div id="toast" style="
  display: none;
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #28a745;
  color: white;
  padding: 12px 20px;
  border-radius: 6px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  font-size: 15px;
  z-index: 9999;
  transition: opacity 0.3s ease;
"></div>

<script>
  let deferredPrompt = null;

  // ✅ تسجيل Service Worker
  if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("service-worker.js")
      .then(() => console.log("✅ Service Worker تم تسجيله بنجاح"))
      .catch((error) => console.error("❌ فشل تسجيل Service Worker:", error));
  }

  // ✅ التحقق مما إذا كان التطبيق مثبتًا
  function isAppInstalled() {
    return window.matchMedia('(display-mode: standalone)').matches ||
           window.navigator.standalone === true;
  }

  // ✅ عرض إشعار بصري
  function showToast(message, color = "#28a745") {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.style.backgroundColor = color;
    toast.style.display = "block";
    setTimeout(() => {
      toast.style.display = "none";
    }, 3000);
  }

  // ✅ إظهار زر التثبيت فقط إذا لم يكن التطبيق مثبتًا
  window.addEventListener("load", () => {
    if (!isAppInstalled()) {
      console.log("ℹ️ التطبيق غير مثبت بعد");
    } else {
      console.log("✅ التطبيق مثبت بالفعل");
      const banner = document.getElementById("installBanner");
      if (banner) banner.style.display = "none";
    }
  });

  // ✅ التقاط حدث beforeinstallprompt
  window.addEventListener("beforeinstallprompt", (event) => {
    event.preventDefault();
    deferredPrompt = event;

    const banner = document.getElementById("installBanner");
    if (banner && !isAppInstalled()) {
      banner.style.display = "block";
    }
  });

  // ✅ تنفيذ التثبيت عند الضغط على الزر
  function installPWA() {
    if (isAppInstalled()) {
      showToast("✅ التطبيق مثبت بالفعل على جهازك.");
      return;
    }

    if (!deferredPrompt) {
      const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
      if (isSafari) {
        showToast("📱 لتثبيت التطبيق على Safari، اضغط على زر المشاركة ثم اختر 'إضافة إلى الشاشة الرئيسية'.", "#ffc107");
      } else {
        showToast("⚠️ التثبيت غير مدعوم على هذا المتصفح. جرّب Google Chrome أو Microsoft Edge.", "#dc3545");
      }
      return;
    }

    deferredPrompt.prompt();

    deferredPrompt.userChoice.then((choiceResult) => {
      if (choiceResult.outcome === "accepted") {
        showToast("✅ تم قبول التثبيت");
      } else {
        showToast("❌ تم رفض التثبيت", "#dc3545");
      }
      deferredPrompt = null;
    });
  }

  // ✅ إخفاء البانر بعد التثبيت
  window.addEventListener("appinstalled", () => {
    const banner = document.getElementById("installBanner");
    if (banner) banner.style.display = "none";
    showToast("🎉 تم تثبيت التطبيق بنجاح!");
  });
</script>



<script>
  window.addEventListener("load", function () {
    const loader = document.getElementById("loader-wrapper");
    if (loader) {
      loader.style.transition = "opacity 0.6s ease";
      loader.style.opacity = "0";
      setTimeout(() => loader.style.display = "none", 600);
    }
  });
</script>




</html>












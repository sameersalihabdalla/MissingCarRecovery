<?php
include("texts.php");
include("db_connection.php");

$language_ch = $language_ch ?? 'ar';
$direction = $direction ?? 'rtl';

// استقبال البيانات مع التأكد من تعريفها
$vin = isset($_GET['vin']) ? trim($_GET['vin']) : '';
$plate = isset($_GET['plate']) ? trim($_GET['plate']) : '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// بناء الشروط
$conditions = ["visable = 1"];
$params = [];
$types = "";

if (!empty($vin)) {
    $conditions[] = "vin LIKE ?";
    $params[] = "%$vin%";
    $types .= "s";
}
if (!empty($plate)) {
    $conditions[] = "plate_number LIKE ?";
    $params[] = "%$plate%";
    $types .= "s";
}

$where = implode(" AND ", $conditions);

// حساب عدد النتائج
$count_sql = "SELECT COUNT(*) FROM cars WHERE $where";
$count_stmt = $conn->prepare($count_sql);
if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$count_stmt->bind_result($total_results);
$count_stmt->fetch();
$count_stmt->close();
$total_pages = ceil($total_results / $limit);

// استعلام النتائج
$sql = "SELECT * FROM cars WHERE $where ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$types .= "ii";
$params[] = $limit;
$params[] = $offset;
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="<?=$language_ch?>">
<head>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>بحث عن سيارة - <?=$site_name_c?></title>
  <?php include("meta.php"); ?>
  
</head>
<body dir="<?=$direction?>">

<?php include("menu.php"); ?>

<div class="hero-wrap hero-wrap-2" style="background-color: #4d4a45;" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-center text-center">
      <div class="col-md-12 mb-5">
        <p class="breadcrumbs mb-0">
          <span class="me-3"><a href="index.php"><?=$home?> <i class="ion-ios-arrow-forward"></i></a></span>
          <span>بحث عن سيارة</span>
        </p>
            <h3 class="text-center  bread">ابحث برقم الشاسي أو اللوحة</h3>

      </div>
    </div>
  </div>
</div>

<section class="ftco-section bg-light">
  <div class="container px-3">

    <form method="GET" class="row g-3 mb-4 justify-content-center">
      <div class="col-12 col-md-6 col-sm-12">
        <label for="vin" class="form-label">رقم الشاسي (VIN)</label>
        <input type="text" name="vin" id="vin" class="form-control w-100" value="<?=htmlspecialchars($vin)?>" placeholder="أدخل رقم الشاسي">
      </div>

      <div class="col-12 col-md-6">
        <label for="plate" class="form-label">رقم اللوحة</label>
        <input type="text" name="plate" id="plate" class="form-control w-100" value="<?=htmlspecialchars($plate)?>" placeholder="أدخل رقم اللوحة">
      </div>

      <div class="col-12 col-  d-grid align-items-end">
        
        
        <button type="submit" class="btn  w-100 btn header-link hover-pulse mt-3 " style="border:solid #ccc 1px; "> <i class="ion-ios-search"></i> بحث</button>
      
      </div>
    </form>
<hr >
    <h3 class="text-center mb-4">نتائج البحث</h3>

    <?php if ($result && $result->num_rows > 0): ?>
      <div class="row">
        <?php while ($car = $result->fetch_assoc()): ?>
          <div class="col-md-6 col-sm-12 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($car['vin']) ?>     ////////    <?= htmlspecialchars($car['plate_number']) ?></h5>
                <p class="card-text">
                  <strong>الشاسي:</strong> <?= htmlspecialchars($car['vin']) ?><br>
                  <strong>اللوحة:</strong> <?= htmlspecialchars($car['plate_number']) ?><br>
                  <strong>اللون:</strong> <?= htmlspecialchars($car['color']) ?><br>
                </p>
                <a href="car_information.php?car_id=<?= $car['id'] ?>" class="btn btn-outline-primary btn-sm">التفاصيل</a>

                


<?php
// توليد نص المشاركة بناءً على بيانات السيارة
$vin = htmlspecialchars($car['vin']);
$plate = htmlspecialchars($car['plate_number']);
$brand = htmlspecialchars($car['manufactor']);
$car_link = "https://www.jobsagent.org/car_information.php?car_id=" . $car['id'];

$share_text = "📢 ساعد في نشر هذه السيارة — ربما تصل لصاحبها!\n"
            . "🚗 تم العثور على سيارة {$brand} "
            . (!empty($plate) ? "برقم اللوحة: {$plate} " : "")
            . (!empty($vin) ? "ورقم الشاسي: {$vin} " : "")
            . "عبر منصة JobsAgent.org.\n"
            . "🔎 التفاصيل: {$car_link}";
?>


<hr class="mt-2 m-0 p-0">
<p class="m-0 p-0">شارك هذه السيارة :</p>
<div class="mt-2 d-flex flex-wrap gap-2 justify-content-start small text-">
  <button class="btn btn-sm btn-outline-primary px-2 py-1"
          data-sharer="facebook"
          data-url="<?= $car_link ?>"
          data-quote="<?= $share_text ?>">
    <i class="icon-facebook"></i> 
  </button>

  <button class="btn btn-sm btn-outline-success mr-1 px-2 py-1"
          data-sharer="whatsapp"
          data-url="<?= $car_link ?>"
          data-title="<?= $share_text ?>">
    <i class="icon-whatsapp"></i> 
  </button>

  <button class="btn btn-sm btn-outline-info mr-1  px-2 py-1"
          data-sharer="telegram"
          data-url="<?= $car_link ?>"
          data-title="<?= $share_text ?>">
    <i class="icon-telegram"></i> 
  </button>

  <button class="btn btn-sm btn-outline-secondary mr-1  px-2 py-1"
          data-sharer="twitter"
          data-url="<?= $car_link ?>"
          data-title="<?= $share_text ?>">
    <i class="icon-twitter"></i> 
  </button>

  <button class="btn btn-sm btn-outline-danger mr-1  px-2 py-1"
          data-sharer="linkedin"
          data-url="<?= $car_link ?>"
          data-title="<?= $share_text ?>">
    <i class="icon-linkedin"></i> 
  </button>

  <button class="btn btn-sm btn-outline-dark mr-1  px-2 py-1"
          data-sharer="email"
          data-url="<?= $car_link ?>"
          data-title="<?= $share_text ?>"
          data-subject="بلاغ عن سيارة"
          data-to="">
    <i class="icon-envelope"></i>  
  </button>
</div>


                
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <nav class="mt-4">
        <ul class="pagination justify-content-center flex-wrap">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
              <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                <?= $i ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>

      <?php include("ads.php");?>

    <?php else: ?>
      <div class="alert alert-warning text-center">لا توجد نتائج مطابقة.</div>
    <?php endif; ?>
  </div>
</section>

<?php include("footer.php"); ?>
<?php include("scripts.php"); ?>
</body>
</html>

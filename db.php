<?php
include("texts.php");
include("db_connection.php");
$language_ch = $language_ch ?? 'ar';
$direction = $direction ?? 'rtl';

$vin = $_GET['vin'] ?? '';
$plate = $_GET['plate'] ?? '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

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
  <title>بحث عن سيارة - <?=$site_name_c?></title>
  <?php include("meta.php"); ?>
</head>
<body dir="<?=$direction?>">

<?php include("menu.php"); ?>

<div class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-start">
      <div class="col-md-12 text-center mb-5">
        <p class="breadcrumbs mb-0">
          <span class="mr-3"><a href="index.php"><?=$home?> <i class="ion-ios-arrow-forward"></i></a></span>
          <span>بحث عن سيارة</span>
        </p>
        <h2 class="mb-3 bread">بحث عن سيارة</h2>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section bg-light">
  <div class="container">
    <h2 class="text-center mb-4">ابحث برقم الهيكل أو اللوحة</h2>

    <form method="GET" class="row g-3 mb-5">
      <div class="col-md-5">
        <label for="vin" class="form-label">رقم الهيكل (VIN)</label>
        <input type="text" name="vin" id="vin" class="form-control" value="<?=htmlspecialchars($vin)?>" placeholder="أدخل رقم الهيكل">
      </div>

      <div class="col-md-5">
        <label for="plate" class="form-label">رقم اللوحة</label>
        <input type="text" name="plate" id="plate" class="form-control" value="<?=htmlspecialchars($plate)?>" placeholder="أدخل رقم اللوحة">
      </div>

      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">بحث</button>
      </div>
    </form>

    <h3 class="text-center mb-4">نتائج البحث</h3>

    <?php if ($result && $result->num_rows > 0): ?>
      <div class="row">
        <?php while ($car = $result->fetch_assoc()): ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($car['manufactor']) ?> - <?= htmlspecialchars($car['model']) ?></h5>
                <p class="card-text">
                  <strong>الهيكل:</strong> <?= htmlspecialchars($car['vin']) ?><br>
                  <strong>اللوحة:</strong> <?= htmlspecialchars($car['plate_number']) ?><br>
                  <strong>اللون:</strong> <?= htmlspecialchars($car['color']) ?><br>
                  <strong>المنطقة:</strong> <?= htmlspecialchars($car['state']) ?> - <?= htmlspecialchars($car['locality']) ?>
                </p>
                <?php if ($car['post_link']): ?>
                  <a href="<?= htmlspecialchars($car['post_link']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">رابط المنشور</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <!-- روابط الصفحات -->
      <nav class="mt-4">
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
              <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                <?= $i ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>

    <?php else: ?>
      <div class="alert alert-warning text-center">لا توجد نتائج مطابقة.</div>
    <?php endif; ?>
  </div>
</section>

<?php include("footer.php"); ?>
<?php include("scripts.php"); ?>
</body>
</html>

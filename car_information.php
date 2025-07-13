<?php
include("db_connection.php");
include("texts.php");

$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;
$sql = "SELECT * FROM cars WHERE id = $car_id";
$result = $conn->query($sql);
$row = $result && $result->num_rows > 0 ? $result->fetch_assoc() : null;

$seo_url = "https://www.jobsagent.org" . $_SERVER['REQUEST_URI'];
$seo_title = $row ? "{$row['manufactor']} | {$row['vin']} | {$row['plate_number']}" : "تفاصيل سيارة";
$seo_description = $row ? "بلاغ عن سيارة {$row['manufactor']} موديل {$row['model']}، اللون {$row['color']}، رقم الشاسي {$row['vin']}." : "تفاصيل سيارة مفقودة أو معثور عليها.";
$seo_image = !empty($row['image_url1']) ? 'https://www.jobsagent.org' . $row['image_url1'] : "https://www.jobsagent.org/img/ms-icon-310x310.png";

// استخراج أبعاد الصورة
$image_size = @getimagesize($seo_image);
$og_width = $image_size[0] ?? 1200;
$og_height = $image_size[1] ?? 630;
?>

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="<?= htmlspecialchars($seo_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($seo_description) ?>">
<meta property="og:image" content="<?= htmlspecialchars($seo_image) ?>">
<meta property="og:image:width" content="<?= $og_width ?>">
<meta property="og:image:height" content="<?= $og_height ?>">
<meta property="og:url" content="<?= htmlspecialchars($seo_url) ?>">
<meta property="og:type" content="article">
<meta property="og:site_name" content="JobsAgent.org">
<meta property="og:locale" content="ar_AR">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($seo_title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($seo_description) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($seo_image) ?>">
<meta name="twitter:site" content="@JobsAgent">
<meta property="article:section" content="بلاغات السيارات">
<meta property="article:tag" content="سيارات مفقودة, تم العثور عليها, بلاغات">
<title><?= htmlspecialchars($seo_title) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 


  <?php include("meta.php"); ?>
  <style>
    th { background-color: #f8f9fa; width: 30%; }
    img { max-height: 300px; object-fit: cover; }
    .card-body table td, .card-body table th { vertical-align: middle !important; }
  </style>
</head>
<body dir="<?= $direction ?>">

<?php include("menu.php"); ?>

<div class="hero-wrap hero-wrap-2" style="background-color:#4d4a45;">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-start">
      <div class="col-md-12 text-center mb-5">
        <h2 class="mb-3 bread">تفاصيل السيارة</h2>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section contact-section bg-light">
  <div class="container">
    <?php if ($row): ?>
      <div class="card shadow-sm mb-4">
        <div class="card-header text-white" style="background-color: #4d4a45;">
          <h5 class="mb-0 text-white">🚗 بلاغ رقم: <?= htmlspecialchars($row['id']) ?></h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered text-center small">
            <tbody>
              <tr><th>رقم اللوحة</th><td><?= htmlspecialchars($row['plate_number'] ?: '-') ?></td></tr>
              <tr><th>رقم الشاسي</th><td><?= htmlspecialchars($row['vin'] ?: '-') ?></td></tr>
              <tr><th>اللون</th><td><?= htmlspecialchars($row['color'] ?: '-') ?></td></tr>
              <tr><th>الموديل</th><td><?= htmlspecialchars($row['model'] ?: '-') ?></td></tr>
              <tr><th>الشركة المصنعة</th><td><?= htmlspecialchars($row['manufactor'] ?: '-') ?></td></tr>
              <tr><th>الولاية</th><td><?= htmlspecialchars($row['state'] ?: '-') ?></td></tr>
              <tr><th>المحلية</th><td><?= htmlspecialchars($row['locality'] ?: '-') ?></td></tr>
              <tr id="reporter_name_row" style="display: none;"><th>اسم المبلّغ</th><td><?= htmlspecialchars($row['reporter_name'] ?: '-') ?></td></tr>
              <tr id="reporter_phone_row" style="display: none;"><th>رقم الهاتف</th><td><?= htmlspecialchars($row['reporter_phone'] ?: '-') ?></td></tr>
              <tr><th>تاريخ النشر</th><td><?= htmlspecialchars($row['p_date'] ?: '-') ?></td></tr>
              <tr id="description_row" style="display: none;"><th>الوصف</th><td><?= nl2br(htmlspecialchars($row['description'] ?: '-')) ?></td></tr>
            </tbody>
          </table>

          <div class="row justify-content-center mb-3">
            <?php foreach (['image_url1', 'image_url2', 'image_url3'] as $img_key): ?>
              <?php if (!empty($row[$img_key])): ?>
                <div class="col-md-4 col-sm-12 text-center mb-2">
                  <img src="<?= htmlspecialchars($row[$img_key]) ?>" alt="صورة للمركبة" class="img-fluid rounded shadow-sm">
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>

          <div class="text-center" id="contact_buttons" style="display: none;">
            <?php
              $message = "أنا صاحب السيارة بالبلاغ رقم " . $row["id"];
              $phone = "249999249900";

              if (!empty($row['reporter_phone']) && $row['reporter_phone'] !== "-") {
                echo '<a href="tel:' . $row['reporter_phone'] . '" class="btn btn-success btn-sm m-1">📞 اتصال</a>';
              }

              if (!empty($row['location'])) {
                echo '<a href="https://wa.me/' . $phone . '?text=' . urlencode($message) . '" class="btn btn-danger btn-sm m-1">📍 تحديد الموقع</a>';
              } elseif (!empty($row['post_link']) && strpos($row['post_link'], 'facebook.com') !== false) {
                echo '<a href="' . htmlspecialchars($row['post_link']) . '" class="btn btn-info btn-sm m-1">🔗 الحساب</a>';
              }
            ?>
          </div>

          <div class="text-center mt-3">
            <button class="btn btn-outline-primary btn-sm icon-facebook m-1" data-sharer="facebook" data-url="<?= $seo_url ?>"></button>
            <button class="btn btn-outline-success btn-sm icon-whatsapp m-1" data-sharer="whatsapp" data-url="<?= $seo_url ?>"></button>
            <button class="btn btn-outline-info btn-sm icon-telegram m-1" data-sharer="telegram" data-url="<?= $seo_url ?>"></button>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">
        <h5>🚫 لم يتم العثور على بيانات السيارة</h5>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Modal: اتفاقية الاستخدام -->
<div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark p-2">
        <h5 class="modal-title" id="disclaimerLabel">📢 اتفاقية الاستخدام وإخلاء المسؤولية</h5>
      </div>
      <div class="modal-body text-center px-4">
        <p class="mb-3">
          نود أن نوضح أن جميع خدمات منصة <strong>JobsAgent.org</strong> مجانية بالكامل، ولا نقوم بطلب أو تحصيل أي رسوم مالية من المستخدمين تحت أي ظرف.
        </p>
        <p class="mb-3">
          في حال قام الشخص الذي أبلغ عن السيارة بطلب مقابل مادي، فإن ذلك يتم بمبادرة شخصية منه ولا يمثل المنصة بأي شكل من الأشكال.
        </p>
        <p class="mb-3">
          باستخدامك لهذه الخدمة، فإنك تقر بموافقتك الكاملة على هذه الشروط وتُخلي مسؤولية JobsAgent.org من أي تعامل مالي يتم خارج نطاق المنصة.
        </p>
      </div>
     <div class="modal-footer d-flex flex-column flex-md-row justify-content-center align-items-center w-100 px-3">
  <button type="button" class="btn btn-outline-danger w-100 mb-2 mb-md-0 me-md-2" onclick="rejectDisclaimer()">
    <span class="me-1">❌</span> لا أوافق
  </button>
  <button type="button" class="btn btn-primary w-100" onclick="acceptDisclaimer()">
    <span class="me-1">✅</span> أوافق على الشروط
  </button>
</div>

    </div>
  </div>
</div>


<?php include("footer.php"); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  let disclaimerModal;

  window.addEventListener('DOMContentLoaded', () => {
    const modalElement = document.getElementById('disclaimerModal');
    disclaimerModal = new bootstrap.Modal(modalElement, {
      backdrop: 'static',
      keyboard: false
    });
    disclaimerModal.show();
  });

  function acceptDisclaimer() {
    document.getElementById('reporter_name_row').style.display = '';
    document.getElementById('reporter_phone_row').style.display = '';
    document.getElementById('description_row').style.display = '';
    document.getElementById('contact_buttons').style.display = 'block';
    disclaimerModal.hide();
  }

  function rejectDisclaimer() {
    if (confirm("هل أنت متأكد أنك لا توافق على الشروط؟ سيتم إعادتك إلى الصفحة الرئيسية.")) {
      window.location.href = 'index.php';
    }
  }
</script>

<?php include("scripts.php"); ?>
</body>
</html>

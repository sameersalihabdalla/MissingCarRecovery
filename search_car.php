<!DOCTYPE html>
<?php include("texts.php"); ?>
<html lang="<?= $language_ch ?>">
<head>
  <meta charset="utf-8">
  <title><?= $site_name_c ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include("meta.php"); ?>
  <style>
    body {
     
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 12px;
      transition: transform 0.2s ease-in-out;
    }
    .card:hover {
      transform: scale(1.02);
    }
    .form-control {
      border-radius: 0.5rem;
    }
    ul.pagination {
      flex-wrap: wrap;
      overflow-x: auto;
      max-width: 100%;
      padding: 0;
      margin: 0 auto;
      justify-content: center;
    }
    ul.pagination li {
      white-space: nowrap;
    }
  </style>
</head>
<body dir="<?= $direction ?>">

<?php include("menu.php"); ?>

<div class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text align-items-end justify-content-center">
      <div class="col-md-12 text-center mb-5">
        <p class="breadcrumbs mb-0">
          <span class="mr-3"><a href="index.php"><?= $home ?> <i class="ion-ios-arrow-forward"></i></a></span>
          <span>البحث</span>
        </p>
        <h3 class="mb-3 bread">نتائج البحث</h3>
      </div>
    </div>
  </div>
</div>

<section class="contact-section bg-white py-5">
  <div class="container">

    <!-- نموذج البحث -->
    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-12 offset-md-1">
        <input type="text" name="query" class="form-control text-center" placeholder="رقم الشاسي أو رقم اللوحة" value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary px-5 mt-3">🔍 بحث</button>
      </div>
    </form>

    <div class="row">
      
      <?php
      include 'db_connection.php';

      $limit = 20;
      $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
      $offset = ($page - 1) * $limit;

      $query = isset($_GET['query']) ? trim($conn->real_escape_string($_GET['query'])) : '';

      // استعلام العداد
      if (!empty($query)) {
        $count_sql = "
          SELECT COUNT(*) as total 
          FROM cars 
          WHERE MATCH(vin, plate_number) AGAINST('$query' IN NATURAL LANGUAGE MODE)
             OR vin LIKE '%$query%' 
             OR plate_number LIKE '%$query%'";
      } else {
        $count_sql = "SELECT COUNT(*) as total FROM cars";
      }

      $count_result = $conn->query($count_sql);
      $total_rows = $count_result ? $count_result->fetch_assoc()['total'] : 0;
      $total_pages = ceil($total_rows / $limit);

      // الاستعلام الرئيسي
      if (!empty($query)) {
        $sql = "
          SELECT *,
            IF(MATCH(vin, plate_number) AGAINST('$query' IN NATURAL LANGUAGE MODE), 1, 0) AS relevance
          FROM cars
          WHERE MATCH(vin, plate_number) AGAINST('$query' IN NATURAL LANGUAGE MODE)
             OR vin LIKE '%$query%' 
             OR plate_number LIKE '%$query%'
          ORDER BY relevance DESC, p_date DESC
          LIMIT $limit OFFSET $offset";
      } else {
        $sql = "SELECT * FROM cars ORDER BY p_date DESC LIMIT $limit OFFSET $offset";
      }

      $result = $conn->query($sql);

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title text-primary">🚗 بلاغ رقم: <?= $row["id"] ?></h5>
            <p class="card-text"><strong>رقم الشاسي:</strong> <?= $row["vin"] ?></p>
            <p class="card-text"><strong>رقم اللوحة:</strong> <?= $row["plate_number"] ?></p>
            <p class="card-text"><strong>تاريخ النشر:</strong> <?= $row["p_date"] ?></p>
          </div>
          <div class="card-footer text-center">
            <a href="car_information.php?car_id=<?= $row["id"] ?>" class="btn btn-outline-dark w-100">عرض التفاصيل</a>
          </div>
        </div>
      </div>
      <?php
        }
      } else {
        echo '<div class="col-12 text-center"><div class="alert alert-warning"><h5>😕 لم يتم العثور على نتائج.</h5><p>حاول كتابة رقم مختلف أو جزء أطول منه.</p></div></div>';
      }

      // روابط التصفح
      if ($total_pages > 1) {
        echo '<div class="col-12"><nav><ul class="pagination justify-content-center">';
        for ($i = 1; $i <= $total_pages; $i++) {
          $active = $i == $page ? 'active' : '';
          $query_string = http_build_query(array_merge($_GET, ['page' => $i]));
          echo "<li class='page-item $active'><a class='page-link' href='?{$query_string}'>$i</a></li>";
        }
        echo '</ul></nav></div>';
      }

      $conn->close();
      ?>
    </div>
  </div>
</section>

<?php include("footer.php"); ?>

<div id="ftco-loader" class="show fullscreen">
  <svg class="circular" width="48px" height="48px">
    <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
    <circle class="path" cx="24" cy="24" r="22" fill="none" stroke="#F96D00" stroke-width="4" stroke-miterlimit="10"/>
  </svg>
</div>

<?php include("scripts.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


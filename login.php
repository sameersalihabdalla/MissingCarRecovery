<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تسجيل الدخول عبر Facebook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      height: 100vh;
      align-items: center;
      justify-content: center;
      direction: rtl;
    }
    .login-box {
      text-align: center;
      padding: 30px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h3 class="mb-4">تسجيل الدخول عبر Facebook</h3>
    <a href="https://www.facebook.com/v23.0/dialog/oauth?client_id=1180575963872646&redirect_uri=https://www.jobsagent.org/callback.php&scope=pages_show_list,pages_manage_posts,pages_read_engagement&response_type=code"
       class="btn btn-primary btn-lg">
      <i class="bi bi-facebook me-2"></i> تسجيل الدخول
    </a>
  </div>

  <!-- Bootstrap Icons (اختياري) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

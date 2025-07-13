<?php
include 'db_connection.php';
include 'fb/fb_config.php';
$access_token = include 'fb/fb_token_manager.php';

// جلب أول سيارة غير منشورة
$sql = "SELECT * FROM cars WHERE shared_on_facebook IS NULL OR shared_on_facebook = 0 ORDER BY id ASC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $car = $result->fetch_assoc();

    $car_id = $car['id'];
    $vin = $car['vin'];
    $plate_number = $car['plate_number'];
    $color = $car['color'];
    $model = $car['model'];
    $manufactor = $car['manufactor'];

    $car_link = "https://www.jobsagent.org/car_information.php?car_id=" . $car_id;
    $message = "🚗 تم نشر سيارة جديدة على JobsAgent.org\n🔎 التفاصيل:\nالشاسي: $vin | اللوحة: $plate_number | اللون: $color | الماركة: $manufactor | الموديل: $model\n📎 $car_link";

    // جلب صفحة فيسبوك
    $pages_url = "https://graph.facebook.com/me/accounts?access_token=" . $access_token;
    $pages_response = file_get_contents($pages_url);
    $pages_data = json_decode($pages_response, true);

    if (!empty($pages_data['data'])) {
        $page = $pages_data['data'][0];
        $page_id = $page['id'];
        $page_token = $page['access_token'];

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

        if ($response) {
            echo "✅ تم نشر السيارة رقم $car_id على فيسبوك.\n";
            $conn->query("UPDATE cars SET shared_on_facebook = 1 WHERE id = $car_id");
        } else {
            echo "❌ فشل في النشر على فيسبوك.\n";
        }
    } else {
        echo "❌ لم يتم العثور على صفحات فيسبوك.\n";
    }
} else {
    echo "✅ لا توجد سيارات جديدة للنشر.\n";
}

$conn->close();
?>


<script>
  setTimeout(function() {
    window.location.reload();
  }, 5000); // 5000 ميلي ثانية = 5 ثواني
</script>

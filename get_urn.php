<?php
// Access Token الذي حصلت عليه
$accessToken = 'AQUdobOSgZ9RAtDRDmnSYAtkAPaVM1A0Zk_0U8gH_STWhgs41DknHQh92Gbr8FOgh2qQbo9tlyaOSd1ge9fKjMTTnZK5maDQrUNr_vipKRwjN0f7XiaDShmoAeXLhz8_DTY5HBiTT8tJO03-vrx1ud35S4P0RWlU20WTwLMT6f-eqol0MjkVkNaJLKPjEja8D-7VM5YXPBUNtnevnGdfG6sNogjX4nc-1r3hOP5IcMBYBrrUeqhaE6YMlqMWyYecNyFyifd1n30pMs7VP9TK81AJOOyGoDB-5td3QHjp9vGoQ4SHFiE9ysEUpg8DDrFxdsR7sUaU7tWn_7MLP8PmjUHgmZ9spg';


// 🧾 الخطوة 1: الحصول على معرف المستخدم (person ID)
$meUrl = 'https://api.linkedin.com/v2/me';

$ch = curl_init($meUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$meResponse = curl_exec($ch);
curl_close($ch);

$meData = json_decode($meResponse, true);

// ✅ التحقق من وجود المعرف
if (!isset($meData['id'])) {
    die("❌ فشل في جلب معرف المستخدم. تحقق من صلاحية رمز الوصول.");
}

$personId = $meData['id'];
$author = "urn:li:person:$personId";

// 📝 الخطوة 2: إعداد بيانات المنشور
$postUrl = 'https://api.linkedin.com/v2/ugcPosts';

$postData = [
    'author' => $author,
    'lifecycleState' => 'PUBLISHED',
    'specificContent' => [
        'com.linkedin.ugc.ShareContent' => [
            'shareCommentary' => [
                'text' => '🚗 منشور تجريبي من JobsAgent.org باستخدام LinkedIn API!'
            ],
            'shareMediaCategory' => 'NONE'
        ]
    ],
    'visibility' => [
        'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
    ]
];

// 🚀 الخطوة 3: إرسال المنشور
$ch = curl_init($postUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken",
    "Content-Type: application/json",
    "X-Restli-Protocol-Version: 2.0.0"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// 📋 عرض النتيجة
echo "<h3>🔄 حالة الطلب: HTTP $httpCode</h3>";
echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";
?>

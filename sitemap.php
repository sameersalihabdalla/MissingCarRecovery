<?php include("texts.php");
$actual_link = $my_url;
require_once('db_connection.php');
$sitemapText = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$sql = "SELECT * FROM cars order by id desc";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
$sitemapText = $sitemapText.' <url>
                 <loc>'.$actual_link."/car_information.php?car_id=".$row['id'].'</loc>
                 <lastmod>'.date(DATE_ATOM,time()).'</lastmod>
                 <priority>1.0</priority>
               </url>';
   }
}


$sitemapText = $sitemapText.' <url>
                 <loc>'.$actual_link.'/index.php</loc>
                 <lastmod>'.date(DATE_ATOM,time()).'</lastmod>
                 <priority>1.0</priority>
               </url>';

$sitemapText = $sitemapText.'</urlset>';

echo $sitemapText;
$sitemap = fopen("sitemap.xml", "w") or die("Unable to open file!");
fwrite($sitemap, $sitemapText);
fclose($sitemap);
?>
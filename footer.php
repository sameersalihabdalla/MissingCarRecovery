<footer class="">
<p class="text-center">
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | www.jobsagent.org </p>

<?php
$ip = $_SERVER['REMOTE_ADDR'];
$file = 'visitors.txt';
$visited = file($file, FILE_IGNORE_NEW_LINES);

if (!in_array($ip, $visited)) {
    file_put_contents($file, $ip . PHP_EOL, FILE_APPEND);
}
$count = count($visited);

echo '<p class="text-center">' .$count.'</p>';

?>
<p class="text-center"><a href="sitemap.xml">Sitemap</a> | <a href="links.php">links</a> | <a href="link_out.php">Links 2</a></p><br><br>











<style>
      

        .counter-box {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .counter-box h1 {
            color: #007bff;
            margin: 0;
            font-size: 36px;
        }

        .counter-box p {
            font-size: 18px;
            color: #555;
            margin-top: 10px;
        }
    </style>







<div>
<hr>
<!-- تذييل الصفحة -->
<!-- تذييل احترافي مع زر واتساب -->
<!-- تذييل أنيق في سطر واحد -->
<div style="background-color: #4d4a45;" class="d-flex justify-content-between align-items-center text-white small p-2 fixed-bottom">
  <span>
    <a href="mailto:sameerssaom@gmail.com" class="text-white text-decoration-none">
       تصميم وبرمجة: سمير صالح عبدالله -  السودان
    </a>
  </span>
  <a href="https://wa.me/249999249900" target="_blank" class="btn btn-success btn-sm ms-2 text-white">
    <i class="ion-logo-whatsapp"></i> 
  </a>
</div>




</div>



</footer>


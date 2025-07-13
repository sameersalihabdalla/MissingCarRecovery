<!DOCTYPE html>
<?php  include("texts.php");  ?>
<html lang="<?=$language_ch?>">
<head>
<?php include("texts.php"); ?>
<title><?=$site_name_c?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php include("meta.php");?>
</head>
<body dir="<?=$direction?>">

<?php include("menu.php")?>

<!-- END nav -->

<div class="hero-wrap hero-wrap-2" style="background-color:#4d4a45;" data-stellar-background-ratio="0.5">
<div class="overlay"></div>
<div class="container">
<div class="row no-gutters slider-text align-items-end justify-content-start">
<div class="col-md-12  text-center mb-5">
<h3 class="mb-3 bread">بلاغ عثور على سيارة</h2>
</div>
</div>
</div>
</div>

<section class="ftco-section contact-section bg-light" dir="rtl">
<div class="container">
<div class="row ">

<div class="container py-5 " dir="rtl">
 

<div class="alert alert-danger alert-dismissible fade show alert-animated-title" role="alert">
  <h5 class="alert-heading">🚨 تحذير مهم!</h5>
  <p>هذه الصفحة تقوم بأخذ احدثيات الموقع الجغرافي الخاص بك تلقائيا </p>
</div>
       <h4 class="text-primary text-center mt-3 mb-3"> توقف بجانب السيارة فقط وقم بتعبئة الحقول أدناه   ثم أضغط على إرسال بلاغ     </h4><hr>
        <div class="container">
        <form   action="add_report.php" enctype="multipart/form-data"  method="POST" class="mt-4">


  <div class="container mt-3 ">

<!-- تضمين CSS الخاص بـ Cropper.js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>
        <label class="mt-2"> صورة رقم 1 - اختياري</label>

<!-- حقول اختيار الصور -->
<input type="file" class="imageInput form-control small" name="image" data-index="1" accept="image/*">
        <label class="mt-2"> صورة رقم 2 - اختياري</label>

<input type="file" class="imageInput form-control small" name="image2" data-index="2" accept="image/*">
        <label class="mt-2"> صورة رقم 3 - اختياري</label>

<input type="file" class="imageInput form-control small" name="image3"  data-index="3" accept="image/*">

<!-- حاويات الصور -->
<div id="containers">
  <div id="container1" class="image-box" style="margin-top: 15px;">
    <img id="preview1" style="max-width: 100%; display: none;">
    <button class="rotateBtn" data-index="1" style="display: none;">↻ تدوير</button>
    <button class="cropBtn" data-index="1" style="display: none;">✂️ قص</button>
  </div>
  <div id="container2" class="image-box" style="margin-top: 15px;">
    <img id="preview2" style="max-width: 100%; display: none;">
    <button class="rotateBtn" data-index="2" style="display: none;">↻ تدوير</button>
    <button class="cropBtn" data-index="2" style="display: none;">✂️ قص</button>
  </div>
  <div id="container3" class="image-box" style="margin-top: 15px;">
    <img id="preview3" style="max-width: 100%; display: none;">
    <button class="rotateBtn" data-index="3" style="display: none;">↻ تدوير</button>
    <button class="cropBtn" data-index="3" style="display: none;">✂️ قص</button>
  </div>
</div>

<!-- تضمين JavaScript و Cropper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
  const croppers = {};

  document.querySelectorAll('.imageInput').forEach(input => {
    input.addEventListener('change', function (e) {
      const index = this.dataset.index;
      const file = e.target.files[0];
      const img = document.getElementById('preview' + index);
      const rotateBtn = document.querySelector(`.rotateBtn[data-index="${index}"]`);
      const cropBtn = document.querySelector(`.cropBtn[data-index="${index}"]`);

      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (event) {
          img.src = event.target.result;
          img.style.display = 'block';
          rotateBtn.style.display = 'inline-block';
          cropBtn.style.display = 'inline-block';

          if (croppers[index]) croppers[index].destroy();
          croppers[index] = new Cropper(img, {
            aspectRatio: NaN,
            viewMode: 1,
            responsive: true,
            autoCropArea: 1,
          });
        };
        reader.readAsDataURL(file);
      }
    });
  });

  document.querySelectorAll('.rotateBtn').forEach(btn => {
    btn.addEventListener('click', function () {
      const index = this.dataset.index;
      if (croppers[index]) {
        croppers[index].rotate(90);
      }
    });
  });

  document.querySelectorAll('.cropBtn').forEach(btn => {
    btn.addEventListener('click', function () {
      const index = this.dataset.index;
      const img = document.getElementById('preview' + index);
      if (croppers[index]) {
        const canvas = croppers[index].getCroppedCanvas({
          maxWidth: 800,
          maxHeight: 800
        });
        img.src = canvas.toDataURL();
        croppers[index].destroy();
        delete croppers[index];
        this.style.display = 'none';
        document.querySelector(`.rotateBtn[data-index="${index}"]`).style.display = 'none';
      }
    });
  });
</script>

  </div><div class="row">
    
            <div class="col-auto col-md-3">
                <label class="form-label  mt-2">رقم الشاسي  - VIN:</label>
                <input type="text" name="vin" class="form-control" placeholder="KMXYZN1783723 / 83472 /4342" required>
            </div>
            <div class="col-auto col-md-4">
                <label class="form-label mt-2">رقم اللوحة:</label>
                <input type="text" name="plate_number" class="form-control" placeholder="على سبيل المثال خ3\ 123457" >
            </div>
            <div class="col-auto col-md-2">
                <label class="form-label mt-2">لون المركبة:</label>
                <select  name="color" placeholder="أحمر , أخضر , ابيض , ..... الخ" class="form-control  p-2">
                    <option  class="form-control">أبيض</option>
                    <option  class="form-control">احمر</option>
                    <option  class="form-control">أزرق</option>
                    <option  class="form-control">سلفر</option>
                    <option  class="form-control">بني</option>
                    <option  class="form-control">سماوي</option>
                    <option  class="form-control">فضي</option>
                    <option  class="form-control">برتقالي</option>
                    <option  class="form-control">فيراني</option>
                    <option  class="form-control">لؤلؤي</option>
                    <option  class="form-control">أسود</option>
                    <option  class="form-control">عنابي</option>
                    <option  class="form-control">حرجلي</option>
                    <option  class="form-control">آخر</option>
                    
</select>
           

  </div>

           <div class="col-auto col-md-3">
                <label class="form-label mt-2">  الفئة</label>
                <select  name="manufactor" class="form-control  p-2">
                    <option  class="form-control">غير معروفة</option>
                    <option  class="form-control">تويوتا</option>
                    <option  class="form-control">هيونداي</option>
                    <option  class="form-control">كيا</option>
                    <option  class="form-control">داو \ دايو</option>
                    <option  class="form-control">ميتسوبيشي</option>
                    <option  class="form-control">نيسان</option>
                    <option  class="form-control">مازدا</option>
                    <option  class="form-control">بيدفورد</option>
                    <option  class="form-control">كاماز</option>
                    <option  class="form-control">بايك</option>
                    <option  class="form-control">فورد</option>
                    <option  class="form-control">حافلة صينية</option>
                    <option  class="form-control">قلاب</option>
                    <option  class="form-control">شاحنة</option>
                    <option  class="form-control">لوري</option>
                    <option  class="form-control">اسكانيا</option>
                    <option  class="form-control">رينو</option>
                    <option  class="form-control">داف</option>
                    <option  class="form-control">سوزوكي</option>
                    <option  class="form-control">مارشال</option>
                    <option  class="form-control">ماركات أخرى</option>
                    
                    
                    
                    
                    
                    
</select>
 </div>
            </div>
            <div class="row">

            <div class=" col-auto col-md-2">
                <label class="form-label mt-2">الحالة</label>
                <select name="status" class="form-control p-2">
                                        <option  class="form-control">ممتازة</option>
                    <option  class="form-control">جيدة</option>
                    <option  class="form-control">تلف جزئي</option>
                    <option  class="form-control">تلف كبير</option>
                    <option  class="form-control">حريق محدود</option>
                    <option  class="form-control">حريق كامل</option>
                   <option  class="form-control">حطام</option>


</select>

            </div>
            <div class="col-auto col-md-2">
                <label class="form-label mt-2">الموديل:</label>
                <select name="model" class="form-control p-2" >
                <option  class="form-control">1970</option>
<option  class="form-control">1971</option>
<option  class="form-control">1972</option>
<option  class="form-control">1973</option>
<option  class="form-control">1974</option>
<option  class="form-control">1975</option>
<option  class="form-control">1976</option>
<option  class="form-control">1977</option>
<option  class="form-control">1978</option>
<option  class="form-control">1979</option>
<option  class="form-control">1980</option>
<option  class="form-control">1981</option>
<option  class="form-control">1982</option>
<option  class="form-control">1983</option>
<option  class="form-control">1984</option>
<option  class="form-control">1985</option>
<option  class="form-control">1986</option>
<option  class="form-control">1987</option>
<option  class="form-control">1988</option>
<option  class="form-control">1989</option>
<option  class="form-control">1990</option>
<option  class="form-control">1991</option>
<option  class="form-control">1992</option>
<option  class="form-control">1993</option>
<option  class="form-control">1994</option>
<option  class="form-control">1995</option>
<option  class="form-control">1996</option>
<option  class="form-control">1997</option>
<option  class="form-control">1998</option>
<option  class="form-control">1999</option>
<option  class="form-control">2000</option>
<option  class="form-control">2001</option>
<option  class="form-control">2002</option>
<option  class="form-control">2003</option>
<option  class="form-control">2004</option>
<option  class="form-control">2005</option>
<option  class="form-control">2006</option>
<option  class="form-control">2007</option>
<option  class="form-control">2008</option>
<option  class="form-control">2009</option>
<option  class="form-control">2010</option>
<option  class="form-control">2011</option>
<option  class="form-control">2012</option>
<option  class="form-control">2013</option>
<option  class="form-control">2014</option>
<option  class="form-control">2015</option>
<option  class="form-control">2016</option>
<option  class="form-control">2017</option>
<option  class="form-control">2018</option>
<option  class="form-control">2019</option>
<option  class="form-control">2020</option>
<option  class="form-control">2021</option>
<option  class="form-control">2022</option>
<option  class="form-control">2023</option>
<option  class="form-control">2024</option>
<option  class="form-control">موديل مجهول</option>
</select>
            </div>
            <div class="col-auto col-md-6">
                <label class="form-label mt-2">الوصف الكامل:</label>
                <textarea name="description" placeholder="هذا الوصف أختياري اذا كنت ترغب به" class="form-control"></textarea>
            </div>
            <div class="col-auto col-md-2">
                <label class="form-label mt-2">الولاية:</label>
                <select name="state" class="form-control p2" required>
                    <option  class="form-control">الخرطوم</option>
                    <option  class="form-control">الجزيرة</option>
<option  class="form-control">البحر الأحمر</option>
<option  class="form-control">نهر النيل</option>
<option  class="form-control">الشمالية</option>
<option  class="form-control">كسلا</option>
<option  class="form-control">القضارف</option>
<option  class="form-control">النيل ألأزرق</option>
<option  class="form-control">النيل الأبيض</option>
<option  class="form-control">شمال كردفان</option>
<option  class="form-control">جنوب كردفان</option>
<option  class="form-control">شرق دارفور</option>
<option  class="form-control">غرب دارفور</option>
<option  class="form-control">جنوب دارفور</option>
<option  class="form-control">شمال دارفور</option>


</select>
</div>
                    
            </div>
            <div class="row">
              <div class="col-auto col-md-3">
                <label class="form-label mt-2">المحلية:</label>
                <input type="text" name="locality" class="form-control" required>
            </div>
            <div class="col-auto col-md-3">
                <label class="form-label mt-2">رقم هاتف المبلغ :</label>
                <input type="text" name="reporter_phone" class="form-control" required>
            </div>
            <div class="col-auto col-md-3">
                <label class="form-label mt-2">اسم الشخص المبلغ  :</label>
                <input type="text" name="reporter_name" class="form-control" required>
            </div>
            <div class="col-auto col-md-12">
              <hr>
                <p class=" text-center mt-3 mb-3 p-3">يتم تحميل الموقع الجغرافي تلقائيا عند وقوفك بجانب السيارة المسروقة</p>
                <input type="text" name="location" id="location"  hidden class="form-control" readonly>
            </div>

          
            </div>
            
            <button type="submit" class="btn btn-primary mt-5 mb-5 w-100">إرسال البلاغ</button>
        </form>
</div>
    </div>

    <!-- JavaScript لتحديد الموقع تلقائيًا -->
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('location').value =
                        position.coords.latitude + ", " + position.coords.longitude;
                });
            } else {
                alert("ميزة تحديد الموقع غير مدعومة.");
            }
        }
        getLocation();
    </script>
<div class="col-9 col-md-12 col-lg-9 col-sm-12 p-5">


</div></div></div></section>





<?php include("footer.php");?> 

<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
<?php include("scripts.php");?>


</body>
</html>

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

</div>
</div>

<section class="ftco-section contact-section bg-light py-0" dir="rtl">
<div class="container">
<div class="row pt-0 ">

<div class="container py-5  " dir="rtl">
        <div class="container">
          <div class="col-md-12  text-center ">
<h2 class="mb-3 bread mt-1">بلاغ عثور على سيارة</h2>
</div>
</div>
          <div class="alert alert-warning border-2 border-start border-dark shadow-sm p-4 mt-4" role="alert" style="font-size: 1.1rem; line-height: 1.8;">
  <div class="d-flex align-items-center mb-2">
    <span class="fs-4 me-2">🚨</span>
    <strong class="fs-5">تنبيه هام!</strong>
  </div>
  <p class="mb-1">
    إذا كنت قد عثرت على <strong>سيارة مشبوهة أو متروكة</strong> ولم تتمكن من الوصول إلى صاحبها،
    نرجو منك تسجيل بياناتها في النظام.
  </p>
  <p class="mb-1">
    هذا يساعدنا في <strong>ربط البلاغات</strong> ومساعدة المالك الحقيقي في استعادتها بأسرع وقت ممكن.
  </p>
  <p class="mb-0 text-dark">
    كل ما تحتاجه هو <strong>رقم الشاسي أو اللوحة</strong>، ويمكنك إرفاق صورة إن وُجدت. و الحقول في الأسفل
  </p>
</div>

        <form   action="add_report_fp.php" enctype="multipart/form-data"  method="POST" class="mt-4">

        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>
        <label class="mt-2"> صورة رقم 1 - اختياري</label>

<!-- حقول اختيار الصور -->
<input type="file" class="imageInput form-control small" name="image" data-index="1" accept="image/*">
      
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






  <div class="container mt-3 ">

        <label class="mt-2"  hidden> رابط صورة رقم 2 - اختياري</label>
                <input type="url" name="url2" class="form-control small"  hidden >

  </div>
  <div class="container mt-3 ">

        <label class="mt-2"  hidden>  رابط صورة رقم 3 - اختياري</label>
                <input type="url" name="url3" class="form-control small"   hidden>

  </div>

            <div class="col-auto">
                <label class="form-label  mt-2">رقم الهيكل - الشاسي - الشاسيه - VIN:</label>
                <input type="text" name="vin" id="vin" class="form-control" placeholder="أدخل رقم الشاسي" required oninput="checkVin(this.value)">
<small id="vinResult" class="form-text mt-1"></small>

            </div>
            <div class="col-auto">
                <label class="form-label mt-2">رقم اللوحة:</label>
<input type="text" name="plate_number" id="plate_number" class="form-control" placeholder="على سبيل المثال خ3\ 123457" oninput="checkPlate(this.value)">
<small id="plateResult" class="form-text mt-1"></small>

            </div>

            <div class="col-12 text-center mt-4">
  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleDetails()" id="toggleDetailsBtn">
    المزيد من التفاصيل
  </button>
</div>


            <div class="col-auto">
                <label class="form-label mt-2" >لون المركبة:</label>
                <select  name="color" placeholder="أحمر , أخضر , ابيض , ..... الخ" class="form-control  p-2"  >
                    
                    <option  class="form-control">-</option>
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
                    <option  class="form-control">ذهبي</option>
                    <option  class="form-control">حرجلي</option>
                    <option  class="form-control">أخضر</option>
                    <option  class="form-control">أصفر</option>
                    
                    <option  class="form-control">آخر</option>
                    
                    
</select>
            </div>

           <div class="col-auto">
                <label class="form-label mt-2" >   الفئة</label>
                <select  name="manufactor" class="form-control  p-2" >
                    
                    <option  class="form-control">-</option>
                    
                    <option  class="form-control">غير معروفة</option>
                    <!-- 🇯🇵 ماركات يابانية -->
<option class="form-control">تويوتا</option>
<option class="form-control">لكزس</option>
<option class="form-control">نيسان</option>
<option class="form-control">إنفينيتي</option>
<option class="form-control">هوندا</option>
<option class="form-control">أكورا</option>
<option class="form-control">مازدا</option>
<option class="form-control">سوزوكي</option>
<option class="form-control">ميتسوبيشي</option>
<option class="form-control">سوبارو</option>
<option class="form-control">دايهاتسو</option>
<option class="form-control">إيسوزو</option>

<!-- 🇰🇷 ماركات كورية -->
<option class="form-control">هيونداي</option>
<option class="form-control">كيا</option>
<option class="form-control">جينيسيس</option>
<option class="form-control">سانغ يونغ</option>
<option class="form-control">دايو</option>

<!-- 🇨🇳 ماركات صينية -->
<option class="form-control">جيلي</option>
<option class="form-control">شيري</option>
<option class="form-control">BYD</option>
<option class="form-control">هافال</option>
<option class="form-control">شانجان</option>
<option class="form-control">فاو</option>
<option class="form-control">جاك</option>
<option class="form-control">MG (صينية الآن)</option>
<option class="form-control">دونغ فينغ</option>
<option class="form-control">سايك</option>

<!-- 🇺🇸 ماركات أمريكية مشهورة -->
<option class="form-control">فورد</option>
<option class="form-control">شيفروليه</option>
<option class="form-control">جي إم سي</option>
<option class="form-control">كاديلاك</option>
<option class="form-control">دودج</option>
<option class="form-control">رام</option>
<option class="form-control">جيب</option>
<option class="form-control">تسلا</option>
<option class="form-control">لينكولن</option>
<option class="form-control">بويك</option>
<option class="form-control">كرايسلر</option>

<!-- 🇪🇺 ماركات أوروبية مشهورة -->
<option class="form-control">مرسيدس بنز</option>
<option class="form-control">بي إم دبليو</option>
<option class="form-control">أودي</option>
<option class="form-control">فولكس فاجن</option>
<option class="form-control">بورشه</option>
<option class="form-control">أوبل</option>
<option class="form-control">رينو</option>
<option class="form-control">بيجو</option>
<option class="form-control">ستروين</option>
<option class="form-control">فيات</option>
<option class="form-control">سكودا</option>
<option class="form-control">سيات</option>
<option class="form-control">لاند روفر</option>
<option class="form-control">جاجوار</option>
<option class="form-control">فولفو</option>
<option class="form-control">ألفا روميو</option>
<option class="form-control">داتشيا</option>

  <option class="form-control">-</option>
  <option class="form-control">سيدان</option>
  <option class="form-control">هاتشباك</option>
  <option class="form-control">كوبيه</option>
  <option class="form-control">كروس أوفر</option>
  <option class="form-control">SUV (دفع رباعي)</option>
  <option class="form-control">بيك أب</option>
  <option class="form-control">بوكس</option>
  <option class="form-control">هايس</option>
  <option class="form-control">بص</option>
  <option class="form-control">حافلة صغيرة</option>
  <option class="form-control">حافلة كبيرة</option>
  <option class="form-control">شاحنة خفيفة</option>
  <option class="form-control">شاحنة ثقيلة</option>
  <option class="form-control">قلاب</option>
  <option class="form-control">رافعة</option>
  <option class="form-control">تريلا</option>
  <option class="form-control">صهريج</option>
  <option class="form-control">ونش</option>
  <option class="form-control">ميني فان</option>
  <option class="form-control">فان</option>
  <option class="form-control">مركبة إسعاف</option>
  <option class="form-control">مركبة شرطة</option>
  <option class="form-control">دراجة نارية</option>
  <option class="form-control">توك توك</option>
  <option class="form-control">عربة نقل</option>
  <option class="form-control">مقطورة</option>
  <option class="form-control">مركبة زراعية</option>
  <option class="form-control">مركبة إنشائية</option>
  <option class="form-control">أخرى</option>
</select>

                    
                    
                    
                    
                    
</select>
            </div>

            <div class=" col-auto">
                <label class="form-label mt-2" hidden>الحالة</label>
                <select name="status" class="form-control p-2" hidden>
                    <option>-</option>
                                        <option  class="form-control">ممتازة</option>
                    <option  class="form-control">جيدة</option>
                    <option  class="form-control">تلف جزئي</option>
                    <option  class="form-control">تلف كبير</option>
                    <option  class="form-control">حريق محدود</option>
                    <option  class="form-control">حريق كامل</option>
                   <option  class="form-control">حطام</option>


</select>
            </div>
            <div class="col-auto">
                <label class="form-label mt-2" >الموديل:</label>
                <select name="model" class="form-control p-2"  >
                <option  class="form-control">0000</option>

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
<option  class="form-control">19xx</option>
<option  class="form-control">20xx</option>
<option  class="form-control">202x</option>

</select>
            </div>
            <div class="col-auto">
                <label class="form-label mt-2">الوصف الكامل:</label>
                <textarea name="description" rows="5" placeholder="هذا الوصف أختياري اذا كنت ترغب به" class="form-control"></textarea>
            </div>
            <div class="col-auto">
                <label class="form-label mt-2" hidden>الولاية:</label>
                <select name="state" class="form-control p2" required hidden>
                    <option  class="form-control">-</option>
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
            <div class="col-auto">
                <label class="form-label mt-2" hidden>المحلية:</label>
                <input type="text" name="locality" class="form-control" value="-" required hidden>
            </div>
            <div class="col-auto">
                <label class="form-label mt-2">رقم هاتف المبلغ (اختياري):</label>
                <input type="text" name="reporter_phone" class="form-control" required>
            </div>
            <div class="col-auto">
                <label class="form-label mt-2">اسم الشخص المبلغ  (اختياري):</label>
                <input type="text" name="reporter_name" class="form-control">
            </div>
            <div class="col-auto">
                <input type="url" name="post_link"   placeholder="https://www.facebook.com/" class="form-control" value="http://www.jobsagent.org" hidden>
            </div>

          
            <button type="submit" class="btn btn-primary mt-5 mb-5 w-100">إرسال البلاغ</button>
        </form>
</div>
    </div>


<div class="col-9 col-md-12 col-lg-9 col-sm-12 p-5">


</div></div></div></section>





<?php include("footer.php");?> 

<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
<?php include("scripts.php");?>


<script>
function checkVin(vin) {
  const resultBox = document.getElementById('vinResult');
  if (vin.length < 3) {
    resultBox.innerHTML = '';
    return;
  }

  fetch('check_vin.php?vin=' + encodeURIComponent(vin))
    .then(response => response.text())
    .then(data => {
      resultBox.innerHTML = data;
    })
    .catch(() => {
      resultBox.innerHTML = '<span class="text-muted small">⚠️ خطأ في الاتصال بالخادم</span>';
    });
}
</script>


<script>
function checkVin(vin) {
  const resultBox = document.getElementById('vinResult');
  if (vin.length < 3) {
    resultBox.innerHTML = '';
    return;
  }

  fetch('check_vin.php?vin=' + encodeURIComponent(vin))
    .then(response => response.text())
    .then(data => {
      resultBox.innerHTML = data;
    })
    .catch(() => {
      resultBox.innerHTML = '<span class="text-muted small">⚠️ خطأ في الاتصال بالخادم</span>';
    });
}

function checkPlate(plate) {
  const resultBox = document.getElementById('plateResult');
  if (plate.length < 3) {
    resultBox.innerHTML = '';
    return;
  }

  fetch('check_plate.php?plate=' + encodeURIComponent(plate))
    .then(response => response.text())
    .then(data => {
      resultBox.innerHTML = data;
    })
    .catch(() => {
      resultBox.innerHTML = '<span class="text-muted small">⚠️ خطأ في الاتصال بالخادم</span>';
    });
}
</script>



<script>
function toggleDetails() {
  const fields = ['state', 'locality', 'status'];
  let anyVisible = false;

  fields.forEach(name => {
    const input = document.querySelector(`[name="${name}"]`);
    const label = input?.previousElementSibling;

    if (input && input.hasAttribute('hidden')) {
      input.removeAttribute('hidden');
      if (label) label.removeAttribute('hidden');
    } else if (input) {
      input.setAttribute('hidden', true);
      if (label) label.setAttribute('hidden', true);
      anyVisible = true;
    }
  });

  const btn = document.getElementById('toggleDetailsBtn');
  btn.innerText = anyVisible ? 'المزيد من التفاصيل' : 'إخفاء التفاصيل';
}
</script>

</body>
</html>

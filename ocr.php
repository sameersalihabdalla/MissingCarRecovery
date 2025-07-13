<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تحليل بيانات السيارة</title>
  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.0.2/dist/tesseract.min.js"></script>
  <style>
    body { font-family: Arial; direction: rtl; text-align: center; padding: 20px; }
    img { max-width: 400px; margin-top: 10px; }
    pre { background: #f0f0f0; padding: 10px; text-align: left; direction: ltr; }
  </style>
</head>
<body>
  <h2>🚘 استخراج بيانات السيارة من الصورة</h2>
  <input type="file" id="imageInput" accept="image/*">
  <p id="status">📷 الرجاء رفع صورة</p>
  <img id="preview" style="display: none;">
  <pre id="output"></pre>

  <script>
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('preview');
    const output = document.getElementById('output');
    const status = document.getElementById('status');

    imageInput.addEventListener('change', () => {
      const file = imageInput.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = () => {
        preview.src = reader.result;
        preview.style.display = 'block';
        status.textContent = '🧠 جاري تحليل الصورة...';

        Tesseract.recognize(reader.result, 'ara+eng', {
          logger: m => console.log(m)
        }).then(({ data: { text } }) => {
          status.textContent = '✅ تم استخراج النص:';
          output.textContent = text;

          // تحليل البيانات
          const plate = text.match(/[A-Z]{1,3}[\s-]?\d{1,4}/i);
          const vin = text.match(/\b[A-HJ-NPR-Z0-9]{17}\b/);
          const brand = /(Toyota|Nissan|Hyundai|Kia|Ford|BMW|Mercedes|Suzuki|Chevrolet)/i.exec(text);
          const color = /(أبيض|أسود|أحمر|أزرق|فضي|رمادي|أخضر|ذهبي|برتقالي)/.exec(text);

          output.textContent += '\n\n📋 البيانات المستخرجة:\n';
          output.textContent += `رقم اللوحة: ${plate ? plate[0] : 'غير متوفر'}\n`;
          output.textContent += `رقم الشاسيه: ${vin ? vin[0] : 'غير متوفر'}\n`;
          output.textContent += `الماركة: ${brand ? brand[0] : 'غير متوفر'}\n`;
          output.textContent += `اللون: ${color ? color[0] : 'غير متوفر'}\n`;
        }).catch(err => {
          status.textContent = '❌ حدث خطأ أثناء التحليل';
          output.textContent = err.message;
        });
      };
      reader.readAsDataURL(file);
    });
  </script>
</body>
</html>

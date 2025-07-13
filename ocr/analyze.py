import sys
import cv2
import easyocr

def preprocess_image(image_path):
    image = cv2.imread(image_path)
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    blur = cv2.GaussianBlur(gray, (3, 3), 0)
    thresh = cv2.adaptiveThreshold(
        blur, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C,
        cv2.THRESH_BINARY, 11, 2
    )
    processed_path = "processed.jpg"
    cv2.imwrite(processed_path, thresh)
    return processed_path

# استلام مسار الصورة من PHP
original_path = sys.argv[1]
processed_path = preprocess_image(original_path)

# تحليل الصورة
reader = easyocr.Reader(['en', 'ar'])
results = reader.readtext(processed_path)

# عرض النتائج المفيدة فقط
for _, text, confidence in results:
    if confidence > 0.5 and any(c.isalnum() for c in text):
        print(f"النص: {text} | الدقة: {confidence:.2f}")

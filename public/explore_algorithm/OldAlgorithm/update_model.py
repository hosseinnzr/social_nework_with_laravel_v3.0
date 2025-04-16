import tensorflow as tf
from tensorflow.keras.applications import ResNet50
from tensorflow.keras.applications.resnet50 import preprocess_input
from tensorflow.keras.preprocessing import image
import numpy as np
import os
import pickle
import csv
from sklearn.metrics.pairwise import cosine_similarity

# مسیرها
image_path = r"C:\Users\nazari\Documents\GitHub\social_nework_with_laravel_v2.0\public\post-picture"
features_file = r"C:\Users\nazari\Documents\GitHub\social_nework_with_laravel_v2.0\public\explore_algorithm\files\features.pkl"
csv_file = r"C:\Users\nazari\Documents\GitHub\social_nework_with_laravel_v2.0\public\explore_algorithm\files\sorted_images.csv"

if not os.path.exists(image_path):
    raise FileNotFoundError(f"Error: The directory '{image_path}' does not exist.")

# مرحله 1: لود مدل
model = ResNet50(weights='imagenet', include_top=False, pooling='avg')
print("1.pass")

# تابع پیش‌پردازش تصویر
def preprocess_image(img_path):
    img = image.load_img(img_path, target_size=(224, 224))
    img_array = image.img_to_array(img)
    return preprocess_input(img_array)

# مرحله 2: بارگذاری ویژگی‌ها (در صورت وجود)
features_dict = {}
if os.path.exists(features_file):
    with open(features_file, 'rb') as f:
        features_dict = pickle.load(f)
print("2.pass")

# مرحله 3: دریافت لیست تصاویر
image_files = [f for f in os.listdir(image_path) if f.lower().endswith(('.png', '.jpg', '.jpeg', '.webp'))]
print("3.pass")

# مرحله 4: استخراج ویژگی تصاویر جدید
batch_size = 16
new_images = [img for img in image_files if img not in features_dict]
num_batches = (len(new_images) + batch_size - 1) // batch_size

for i in range(num_batches):
    batch_files = new_images[i * batch_size:(i + 1) * batch_size]
    batch_paths = [os.path.join(image_path, img) for img in batch_files]
    batch_images = np.array([preprocess_image(p) for p in batch_paths])
    batch_features = model.predict(batch_images, verbose=0)

    for j, img in enumerate(batch_files):
        features_dict[img] = batch_features[j]
print("4.pass")

# مرحله 5: ذخیره ویژگی‌ها
with open(features_file, 'wb') as f:
    pickle.dump(features_dict, f)
print("5.pass")

# مرحله 6: مرتب‌سازی تصاویر بر اساس شباهت
ordered_images = []
if os.path.exists(csv_file):
    with open(csv_file, mode='r', encoding='utf-8') as file:
        ordered_images = [row[0] for row in csv.reader(file)]

remaining_images = set(image_files) - set(ordered_images)

while remaining_images:
    current_img = ordered_images[-1] if ordered_images else next(iter(remaining_images))
    current_features = features_dict.get(current_img)

    max_similarity = -1
    next_img = None

    for img in remaining_images:
        other_features = features_dict.get(img)
        if other_features is not None:
            similarity = cosine_similarity([current_features], [other_features])[0][0]
            if similarity > max_similarity:
                max_similarity = similarity
                next_img = img

    if next_img is None:
        break

    ordered_images.append(next_img)
    remaining_images.remove(next_img)
print("6.pass")

# مرحله 7: ذخیره در فایل CSV
with open(csv_file, mode='w', newline='', encoding='utf-8') as file:
    writer = csv.writer(file)
    for img in ordered_images:
        writer.writerow([img])
print("7.pass")

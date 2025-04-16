import csv
import sys
import os

# مسیر فایل CSV مرتب‌شده
csv_file = r"C:\Users\nazari\Documents\GitHub\social_nework_with_laravel_v2.0\public\explore_algorithm\files\sorted_images.csv"

def get_neighbors(image_name, num_neighbors=7):
    # بررسی وجود فایل CSV
    if not os.path.exists(csv_file):
        print(f"فایل CSV یافت نشد: {csv_file}")
        return []

    # خواندن لیست تصاویر مرتب‌شده
    with open(csv_file, mode='r', encoding='utf-8') as file:
        reader = csv.reader(file)
        ordered_images = [row[0] for row in reader if row]

    if image_name not in ordered_images:
        # print(f"تصویر '{image_name}' در فایل وجود ندارد.")
        return []

    index = ordered_images.index(image_name)
    start = max(0, index - num_neighbors)
    end = min(len(ordered_images), index + num_neighbors + 1)

    neighbors = ordered_images[start:end]

    # print(f"\nتصاویر نزدیک به '{image_name}':\n")
    for img in neighbors:
        print(img)

    return neighbors

# دریافت نام عکس از خط فرمان
if __name__ == "__main__":
    if len(sys.argv) != 2:
        # print("نحوه استفاده:\npython find_image.py نام_فایل_عکس.jpg")
        sys.exit(1)

    image_name = sys.argv[1]
    get_neighbors(image_name.strip())

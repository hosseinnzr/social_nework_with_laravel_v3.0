import os
import sys
import numpy as np
import faiss
from PIL import Image
import torch
from torchvision import models, transforms

import warnings
warnings.filterwarnings("ignore")


# Load the ResNet50 model (excluding the final fc layer)
model = models.resnet50(pretrained=True)
model = torch.nn.Sequential(*list(model.children())[:-1])
model.eval()

# Image preprocessing for model input
transform = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
    transforms.Normalize(mean=[0.485, 0.456, 0.406],
                         std=[0.229, 0.224, 0.225])
])

INDEX_FILE = "explore_algorithm/image_index.index"
NAMES_FILE = "explore_algorithm/image_names.npy"
FEATURES_FOLDER = "explore_algorithm/features"

def extract_feature_vector(image_path):
    """Extract feature vector from image using ResNet50"""
    image = Image.open(image_path).convert('RGB')
    img_tensor = transform(image).unsqueeze(0)
    with torch.no_grad():
        features = model(img_tensor).squeeze().numpy()
    return features / np.linalg.norm(features)

def load_or_create_index():
    """Load existing FAISS index or create a new one"""
    if os.path.exists(INDEX_FILE):
        print("Loading existing FAISS index...")
        index = faiss.read_index(INDEX_FILE)
    else:
        print("Creating new FAISS index...")
        index = faiss.IndexFlatL2(2048)
    return index

def load_or_create_names():
    """Load image names or return an empty list"""
    if os.path.exists(NAMES_FILE):
        return list(np.load(NAMES_FILE))
    return []

def save_index_and_names(index, names):
    faiss.write_index(index, INDEX_FILE)
    np.save(NAMES_FILE, np.array(names))
    print("Index and names saved.")

def main():
    if len(sys.argv) != 2:
        print("Please provide the relative path to the image:")
        print("Example: python create_or_update_faiss.py images/123.png")
        return

    image_path = "post-picture/" + sys.argv[1]
    image_name_with_extension = os.path.basename(image_path)
    image_name = os.path.splitext(image_name_with_extension)[0]

    if not os.path.exists(image_path):
        print(f"File not found: {image_path}")
        return

    # Extract feature
    features = extract_feature_vector(image_path).astype('float32')
    feature_path = os.path.join(FEATURES_FOLDER, image_name_with_extension + ".npy") 

    os.makedirs(FEATURES_FOLDER, exist_ok=True)
    np.save(feature_path, features)
    print(f"Feature saved: {feature_path}")

    # Load or create index and name list
    index = load_or_create_index()
    names = load_or_create_names()

    # Check if image is already indexed
    if image_name in names:
        print(f"Image '{image_name}' is already indexed. Operation skipped.")
        return

    # Add to index and names
    index.add(np.expand_dims(features, axis=0))
    names.append(image_name)

    # Save
    save_index_and_names(index, names)

if __name__ == "__main__":
    main()

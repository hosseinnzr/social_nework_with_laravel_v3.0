import os
import sys
import numpy as np
import faiss

# Index and image names file names
INDEX_FILE = "explore_algorithm/image_index.index"
NAMES_FILE = "explore_algorithm/image_names.npy"

def find_similar_images_faiss(query_vector_path, top_k=10):
    similar_images = []

    try:
        # Load FAISS index
        if not os.path.exists(INDEX_FILE):
            print(f"FAISS index file not found: {INDEX_FILE}")
            return similar_images
        index = faiss.read_index(INDEX_FILE)

        # Load image names
        if not os.path.exists(NAMES_FILE):
            print(f"Image names file not found: {NAMES_FILE}")
            return similar_images
        image_names = np.load(NAMES_FILE)

        # Load query feature vector
        if not os.path.exists(query_vector_path):
            print(f"Feature vector file not found: {query_vector_path}")
            return similar_images
        query_vector = np.load(query_vector_path).astype('float32').reshape(1, -1)

        # Search for top K similar images
        distances, indices = index.search(query_vector, top_k)

        for idx in indices[0]:
            if 0 <= idx < len(image_names):
                image_name = str(os.path.splitext(image_names[idx])[0])

                similar_images.append(image_name)

    except Exception as e:
        print(f"Error during similarity search: {e}")

    return similar_images

def main():
    if len(sys.argv) != 2:
        print("Please enter the image name:")
        print("Example: python find_similar_faiss.py 12323423.png")
        return

    query_image = sys.argv[1]
    feature_path = os.path.join("explore_algorithm/features", query_image + ".npy")

    top_k_images = find_similar_images_faiss(feature_path)

    if top_k_images:
        print(top_k_images)
    else:
        print("No similar images found. Showing default or fallback images.")
        if os.path.exists(NAMES_FILE):
            try:
                all_names = np.load(NAMES_FILE)
                fallback = [os.path.splitext(name)[0] for name in all_names[:10]]
                print(fallback)
            except Exception as e:
                print(f"Failed to load fallback images: {e}")

if __name__ == "__main__":
    main()

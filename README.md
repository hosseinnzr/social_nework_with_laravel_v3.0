
# 🌐 Social Network with Laravel

A fully-featured, scalable, and user-centric social network platform built with **Laravel** and **MySQL**, offering real-time messaging, smart content exploration, and a separate admin control panel.  
Designed with modern architecture, responsive UI, and a modular system that ensures security, performance, and extensibility.

---

## 🧭 Project Overview

This project aims to develop a complete web-based social networking system with interactive features, advanced user experience, and high performance.  
It integrates **Laravel**, **MySQL**, and **WebSocket** technologies to deliver a real-time, secure, and dynamic environment for users to connect, share, and interact.

![home](https://github.com/user-attachments/assets/2ab150c6-fd2f-4756-ae2a-5d7029d8382a)

---

## 🚀 Key Features

- 🧑‍🤝‍🧑 User accounts with public/private privacy settings  
- 🖼️ Post creation (text, image, and video)  
- 💬 Real-time chat using **WebSocket**  
- 📸 Stories display with slideshow animation  
- ❤️ Likes, comments, and post saving  
- 🔍 Live user search & intelligent Explore system  
- ⚙️ Admin panel for managing users, reports, and posts  
- 🔔 Notifications and activity tracking  
- 🧰 Profile editing (photo, email, password, birthday)  
- 🧼 Content management (edit/delete posts)  
- 🔒 Account removal & security settings

![profile](https://github.com/user-attachments/assets/0bef00ce-df23-4f7c-9ad4-88e8728a1e59)

---

## 🧠 Smart Explore System (AI-Based)

The **Explore** module is powered by **Python** and a **deep learning model (ResNet50)**.  
When a user likes a post, the system analyzes its image, extracts visual features, and uses **FAISS** to find and suggest the most similar posts from other users.

- Image vectorization via `create_vector_single.py`  
- Similarity search via `find_similar.py`  
- Enables personalized content recommendations for each user


<img width="1556" height="863" alt="Screenshot 2025-05-15 215556" src="https://github.com/user-attachments/assets/d5ed79a3-d252-4eac-af57-313c1256c2e8" />

---

## 💬 Real-time Messaging System

Built using **WebSocket** technology, this feature allows users to exchange live text messages, emojis, images, and videos without page reload.  
It supports:
- One-to-one and multi-user conversations  
- Real-time updates and notifications  
- Modern UI for chat management  

<img width="1433" height="858" alt="Screenshot 2025-05-14 144523" src="https://github.com/user-attachments/assets/04c5fad0-1d41-48d5-8c67-79b6a363a771" />

---

## 🧩 System Architecture

The project follows the **MVC (Model-View-Controller)** pattern in Laravel, using **Blade** for templating and clean separation of logic.  
It also includes a **dedicated admin panel** that connects directly to the database for monitoring user activity, posts, chats, and reports.

**Database:** MySQL  
**Core Tables:**  
`users`, `posts`, `comments`, `messages`, `notifications`, `story`, `follow`, `follow_request`, `like_post`, `like_comment`, `save_post`, `report`

---

## 🛠️ Technologies Used

- **Laravel Framework**  
- **MySQL Database**  
- **WebSocket** for real-time messaging  
- **Bootstrap** for responsive UI  
- **Python + ResNet50 + FAISS** for intelligent image recommendation  
- **Composer** for PHP package management  
- **Intervention/Image** for image processing  
- **SimpleSoftwareIO/Simple-QrCode** for QR generation  

---

## ⚙️ Installation & Setup

### For Clean Route Cache
```bash
php artisan route:cache
php artisan route:clear
```

### for use crop img
composer require intervention/image
install gd in windows and enable extention in xammp
composer require simplesoftwareio/simple-qrcode "~4"

updaet value upload_max_filesize and post_max_size size in php.ini
php artisan storage:link

## social_nework_with_laravel
To run this Laravel app, you need to have the following software installed on your machine:
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)


### Installation
1. Extract file.

2. Change into the project directory:
    ```bash
    cd social_nework_with_laravel_v3.0
    ```

3. Install PHP dependencies:
    ```bash
    composer update
    composer install
    ```
4. Create a copy of the .env.example file and rename it to .env. Update the database and other configurations as needed.
    ```bash
    for use Gmail set :
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=example@gmail.com
    MAIL_PASSWORD=abcdabcdabcdabcd
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="example@gmail.com"
    ```

6. Generate an application key:
    ```bash
    php artisan key:generate
    ```
7. Migrate the database:
    ```bash
    php artisan migrate
    ```
8. Serve the application:
    ```bash
    php artisan serve
    ```
9. run php websocket server:
    ```bash
    cd .\public\chat\
    php .\server.php
    ```
10. Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser to view the app.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

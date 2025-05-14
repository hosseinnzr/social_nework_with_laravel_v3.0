## for route cache
php artisan route:cache
php artisan route:clear

## for use crop img
php artisan serve --host=0.0.0.0 --port=8000    

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
    cd social_nework_with_laravel
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
10. Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser to view the app.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

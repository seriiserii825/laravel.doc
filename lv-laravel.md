sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
php artisan serve

php artisan view:clear
php artisan cache:clear 
php artisan config:clear

php -S localhost:8080 -t public
composer require --dev barryvdh/laravel-ide-helper 2.8
composer require doctrine/dbal:2.3

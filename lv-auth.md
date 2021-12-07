# install laravel/ui
composer require laravel/ui:^2.4

#create controllers and views in resources
php artisan ui vue --auth

#to create database, but before need to create it and set in .env
php artisan migrate

#install
composer require laravel/sanctum

#publish configuration
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

#migrate
##can't create storage/logs
php artisan cache:clear
composer dump-autoload

##migrate
php artisan migrate

#Kernel api
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],

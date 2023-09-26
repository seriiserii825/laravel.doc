## install

composer require laravel/sanctum

## publish configuration

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

## migrate

### can't create storage/logs

php artisan cache:clear
composer dump-autoload

### migrate

php artisan migrate

#Kernel api
'api' => [
\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
'throttle:api',
\Illuminate\Routing\Middleware\SubstituteBindings::class,
],

## create new user with tinker

```
User::create([
'name' => 'user',
'email' => 'user@mail.ru',
'password' => Hash::make('serii1981')
])
```

## connect cookies in postman

```

{{url}}/sanctum/csrf-cookie
add global variable and set them
pm.environment.set("XSRF-TOKEN", pm.cookies.get("XSRF-TOKEN"));
```

## sanctum.php

```
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost,localhost:3000,localhost:8088,127.0.0.1,127.0.0.1:8000,::1',
    Sanctum::currentApplicationUrlWithPort()
))),
```

## postman

```
headers
Referrer localhost:8088
```

### artisan

```
php artisan ui bootstrap
php artisan ui vue
yarn
yarn dev
yarn add vue-router
```

### web.php

```

Route::get('{page}', [App\Http\Controllers\HomeController::class, 'index'])->where('page', '.*')->name('home');
```

### HomeController 
```

```

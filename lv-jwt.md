## Install and set up JWT

Now that our database is set up, we’ll install and set up the Laravel JWT authentication package. We’ll be using `php-open-source-saver/jwt-auth` a fork of `tymondesign/jwt-auth`, because `tymondesign/jwt-auth` appears to have been abandoned and isn’t compatible with Laravel 9.

### Install the newest version of the package using this command:

``` php
composer require php\-open\-source\-saver/jwt\-auth
```

Next, we need to make the package configurations public. Copy the JWT configuration file from the vendor to `confi/jwt.php` with this command:

``` php
php artisan vendor:publish \--provider\="PHPOpenSourceSaver\\JWTAuth\\Providers\\LaravelServiceProvider"
```

Now, we need to generate a secret key to handle the token encryption. To do so, run this command:

``` php

php artisan jwt:secret
```

This will update our `.env` file with something like this:

``` php

JWT_SECRET\=xxxxxxxx
```

This is the key that will be used to sign our tokens.

### Configure AuthGuard

Inside the `config/auth.php` file, we’ll need to make a few changes to configure Laravel to use the JWT AuthGuard to power the application authentication.

First, we’ll make the following changes to the file:

``` php
'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],


    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
                'driver' => 'jwt',
                'provider' => 'users',
        ],

    ],
```

In this code, we’re telling the API `guard` to use the JWT `driver` and to make the API `guard` the default.

Now, we can use Laravel’s inbuilt authentication mechanism, with `jwt-auth` handling the heavy lifting!

### Modify the `User` model

In order to implement the `PHPOpenSourceSaverJWTAuthContractsJWTSubject` contract on our `User` model, we’ll use two methods: `getJWTCustomClaims()` and `getJWTIdentifier()`.

Replace the code in the `app/Models/User.php` file, with the following:

``` php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}

```

That’s it for our model setup!

## Create the AuthController

Now, we’ll create a controller to handle the core logic of the authentication process.

First, we’ll run this command to generate the controller:

``` php

php artisan make:controller AuthController
```

Then, we’ll replace the controller’s content with the following code snippet:

``` php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }}
```

### Test the application

Before we move to Postman and start testing the API endpoints, we need to start our Laravel application.

Run the below command to start the Laravel application:

``` php
php artisan serve
```

### routes api
``` php
<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(TodoController::class)->group(function () {
    Route::get('todos', 'index');
    Route::post('todo', 'store');
    Route::get('todo/{id}', 'show');
    Route::put('todo/{id}', 'update');
    Route::delete('todo/{id}', 'destroy');
}); 
```

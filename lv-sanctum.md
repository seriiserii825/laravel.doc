Authentication is a fundamental aspect of building any web application, as it ensures that only authorized users can access sensitive data and perform actions within the application. Laravel, one of the most popular PHP web frameworks, offers several built-in authentication mechanisms. In the modern era of web development, token-based authentication has become increasingly popular as it is more secure and scalable than traditional cookie-based authentication. Laravel Sanctum is a package that provides a simple and secure way to implement token-based authentication in Laravel applications.

In this article, we will explore the Laravel Sanctum package and how it can be used to implement a simple token-based authentication system. We will cover the steps required to set up Laravel Sanctum, create the API endpoints for authentication, and issue and revoke user tokens. By the end of this article, we will have implemented a token-based authentication system that can be used in APIs and SPAs(Single Page Applications).

## [](https://dev.to/thatcoolguy/token-based-authentication-in-laravel-9-using-laravel-sanctum-3b61#prerequisites)Prerequisites

To follow along with this article, we’ll need:

- Basic knowledge of PHP and Laravel.
- Understanding of HTTP clients like Postman.

## [](https://dev.to/thatcoolguy/token-based-authentication-in-laravel-9-using-laravel-sanctum-3b61#getting-started)**Getting Started**

Let’s start by creating a new project. We can do that by running the command below.

```
laravel new laravel_sanctum_app
```

Enter fullscreen mode Exit fullscreen mode

Alternatively, we can run this command instead.

```
composer create-project laravel/laravel laravel_sanctum_app
```

Enter fullscreen mode Exit fullscreen mode

Both commands will do the same and create a new Laravel project `laravel_sanctum_app` in the specified directory.

Next, start our server to check if our project is running correctly.

For Windows users, execute the following command in the terminal:

```
cd laravel_sanctum_app
php artisan serve
```

Enter fullscreen mode Exit fullscreen mode

For Mac users, use this instead:

```
cd laravel_sanctum_app
valet park
```

Enter fullscreen mode Exit fullscreen mode

Laravel Valet is a development environment for macOS that always configures Mac to run Nginx in the background. For a comprehensive guide on setting up Laravel Valet, click [here](https://laravel.com/docs/9.x/valet#serving-sites).

If everything works correctly, the output below will be displayed.

[![Laravel Welcome Page](https://res.cloudinary.com/practicaldev/image/fetch/s--zk_cAgPC--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_800/https://paper-attachments.dropboxusercontent.com/s_0EA10AAD9BB62E5B1DD6F5BCA5F88367321C0A4EEE18A26D6741671C955CB740_1676495880949_laravel8.png)](https://res.cloudinary.com/practicaldev/image/fetch/s--zk_cAgPC--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_800/https://paper-attachments.dropboxusercontent.com/s_0EA10AAD9BB62E5B1DD6F5BCA5F88367321C0A4EEE18A26D6741671C955CB740_1676495880949_laravel8.png)

## [](https://dev.to/thatcoolguy/token-based-authentication-in-laravel-9-using-laravel-sanctum-3b61#installation-and-setup)Installation and Setup

Laravel Sanctum now comes pre-installed with Laravel since version 7, whereas in earlier versions, it had to be installed separately.

Next, we’ll need to set up our database, and for the sake of this tutorial, we’ll use the SQLite database. We can do that by navigating to the **.env** file in the project's root directory.

```
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Enter fullscreen mode Exit fullscreen mode

Remove the crossed lines and make changes to the first line.

Next, we run our database migration.

```
php artisan migrate 
```

Enter fullscreen mode Exit fullscreen mode

Note: when this command run, a table called `personal_access_tokens` is created in the database. This table stores the token for each user.

## [](https://dev.to/thatcoolguy/token-based-authentication-in-laravel-9-using-laravel-sanctum-3b61#building-the-api)Building the API

The API will consist of 3 endpoints. The first endpoint, "register", will create a new user. The second endpoint, "login", will allow users to log in, and the last endpoint, "logout", will allow users to log out of the system.

First, we need to create the controller that will house these endpoints. We can do that by running the following command.

```
php artisan make:controller AuthController
```

Enter fullscreen mode Exit fullscreen mode

This command will create a file named **AuthController** in the **App\\Http\\Controllers** directory.

Now open the **routes/api.php** file to create the routes that will be used in our application.  

```

    use App\Http\Controllers\AuthController;

    Route::post('/register', [AuthController::class, 'register']);
    Route::login('/login', [AuthController::class, 'login']);
    Route::logout('/logout', [AuthController::class, 'logout']);
```

Enter fullscreen mode Exit fullscreen mode

Open the **AuthController** and paste the following code snippet.  

```
      public function register(Request $request)
    {
          $validatedData = $request->validate([
              'name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users',
              'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }

```

Enter fullscreen mode Exit fullscreen mode

In the code snippet above, we validate the request to ensure that all required variables are present and are of the required type. Then we persist the data into our user table by calling the **Eloquent create** method on an instance of our database. Then finally, a JSON response that shows the name and email is returned. We’re not creating a token here; the token will be created at the login point.

Now implement the login functionality.  

```
     public function login(Request $request){
                $user = User::where('email',  $request->email)->first();
                  if (! $user || ! Hash::check($request->password, $user->password)) 
              {
                    return response()->json([
                        'message' => ['Username or password incorrect'],
                    ]);
                }

                $user->tokens()->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'User logged in successfully',
                    'name' => $user->name,
                    'token' => $user->createToken('auth_token')->plainTextToken,
                ]);
    }
```

Enter fullscreen mode Exit fullscreen mode

Here we’re checking if the supplied email matches the user’s email in the database. An error is thrown if there’s no match or a different password is entered. Then because we do not want to create a new token for a user while the old token is still in the database, the old token is deleted, and a JSON response containing the new token is returned to the user.

Now finally, let’s create the endpoint responsible for logging out users.  

```
    public function logout(Request $request){
          $request->user()->currentAccessToken()->delete();
                  return response()->json(
                      [
                          'status' => 'success',
                          'message' => 'User logged out successfully'
                      ]);
    }
```

Enter fullscreen mode Exit fullscreen mode

The above code snippet deletes the token for the currently authenticated user and logs out the user.

Let's make a slight change to the **routes/api.php** file.  

```
    Route::post('/register', [AuthController::class, 'register']);
    Route::login('/login', [AuthController::class, 'login']);
    //new
    Route::logout('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
```

Enter fullscreen mode Exit fullscreen mode

We use Sanctum middleware to ensure that only authenticated users can access the logout endpoint. This means the user needs to be logged in and have a valid token before logging out.

## [](https://dev.to/thatcoolguy/token-based-authentication-in-laravel-9-using-laravel-sanctum-3b61#testing-the-api)Testing the API

To test our API, we can utilize any HTTP client that we prefer. However, in this article, Postman will be used to demonstrate the process.

**Register a new user**

To register a new user, a POST request should be made to the **'/api/register'** endpoint with the parameters "**name**," "**email**," and "**password**."

When running the server locally with the **php artisan serve** command, the URL to send the request to would be [http://127.0.0.1:8000/api/register](http://127.0.0.1:8000/api/register). In the case of Laravel Valet with the **valet** **park** command, the URL would be [http://laravel\_sanctum\_app.test/api/register](http://laravel_sanctum_app.test/api/register).

[![Screenshot of the Register API Endpoint](https://res.cloudinary.com/practicaldev/image/fetch/s--c6_z5HSf--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_800/https://paper-attachments.dropboxusercontent.com/s_0EA10AAD9BB62E5B1DD6F5BCA5F88367321C0A4EEE18A26D6741671C955CB740_1676500972800_Screen%2BShot%2B2023-02-15%2Bat%2B11.42.01%2BPM.png)](https://res.cloudinary.com/practicaldev/image/fetch/s--c6_z5HSf--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_800/https://paper-attachments.dropboxusercontent.com/s_0EA10AAD9BB62E5B1DD6F5BCA5F88367321C0A4EEE18A26D6741671C955CB740_1676500972800_Screen%2BShot%2B2023-02-15%2Bat%2B11.42.01%2BPM.png)

**Login the user**

To log a user in, send a **POST** request to the **‘/api/login’** endpoint with the parameters **email** and **password.**

[![Screenshot of the Login API Endpoint](https://res.cloudinary.com/practicaldev/image/fetch/s--BqYQ2zPk--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_800/https://paper-attachments.dropboxusercontent.com/s_0EA10AAD9BB62E5B1DD6F5BCA5F88367321C0A4EEE18A26D6741671C955CB740_1676500985487_Screen%2BShot%2B2023-02-15%2Bat%2B11.42.27%2BPM.png)](https://res.cloudinary.com/practicaldev/image/fetch/s--BqYQ2zPk--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_800/https://paper-attachments.dropboxusercontent.com/s_0EA10AAD9BB62E5B1DD6F5BCA5F88367321C0A4EEE18A26D6741671C955CB740_1676500985487_Screen%2BShot%2B2023-02-15%2Bat%2B11.42.27%2BPM.png)

**Logout**

To log out the user, copy the token from the login response and paste it into the "Bearer token" field located in the Authorization tab.

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

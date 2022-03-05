# install laravel/ui
composer require laravel/ui:^2.4

#create controllers, views and routes
php artisan ui vue --auth

#to create database, but before need to create it and set in .env
php artisan migrate

#install sanctum
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

#Kernel
''api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],

#for postman add json
Accept: application/json

#add cors resources/js/bootstrap.js
axios.defaults.withCredentials = true;

#login
axios.get("/sanctum/csrf-cookie").then((response) => {
  axios
    .post("/login", this.form)
    .then((res) => {
      this.$notify({
        type: "success",
        message: "Success logged in",
      });
      this.$router.push({ name: "admin.index" });
    })
    .catch((error) => {
      this.$notify({
        type: "error",
        message: error.response.data.message,
      });
      this.errors = error.response.data.errors;
    });
});

#logout
logout() {
  axios.post("/logout").then((res) => {
    this.$notify({
      type: "success",
      message: "Success logout",
    });
    this.$router.push({name: "login"});
  });
},

#api routes
Route::group(["middleware" => "auth:sanctum"], function () {
    Route::get("/admin", [AdminController::class, "index"]);
});

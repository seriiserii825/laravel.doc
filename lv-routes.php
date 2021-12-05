<?php 
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [\App\Http\Controllers\UserController::class, 'loginForm'])->name('user.login');
Route::get('/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('user.logout');
Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
Route::get('/projects/{slug}', [ProjectController::class, 'single'])->name('project.single');
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('project.update');
Route::delete('/projects/{id}', [ProjectController::class, 'delete'])->name('project.delete');
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login'])->name('user.auth');

Route::group(['prefix' => 'admin', "middleware" => "admin"], function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');
    Route::resource('/projects', '\App\Http\Controllers\Admin\ProjectController');
    Route::resource('/columns', '\App\Http\Controllers\Admin\ColumnController');
    Route::resource('/cards', '\App\Http\Controllers\Admin\CardController');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [\App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/register', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store');
});

//Route::fallback(function () {
//    return redirect()->route('home');
//});

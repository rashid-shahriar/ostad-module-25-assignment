<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleOneController;
use App\Http\Controllers\ExampleTwoController;
use App\Http\Controllers\User\RentalController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/example-one', [ExampleOneController::class, 'index'])->name('example-one')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//manage user role
Route::middleware(['auth', 'AdminMiddleware:admin'])->group(function () {
    Route::get('/example-two', [ExampleTwoController::class, 'index'])->name('example-two')->middleware('AdminMiddleware:admin');
});

//manage auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//rental route for user
Route::get('/user/rental', [RentalController::class, 'index'])->name('user.rental.index')->middleware('auth');
Route::get('/user/rental/create', [RentalController::class, 'create'])->name('user.rental.create')->middleware('auth');
Route::get('/user/rental/{id}', [RentalController::class, 'show'])->name('user.rental.show')->middleware('auth');
Route::get('/user/rental/{id}/edit', [RentalController::class, 'edit'])->name('user.rental.edit')->middleware('auth');
Route::get('/user/rental/show/{id}', [RentalController::class, 'show'])->name('user.rental.show')->middleware('auth');


Route::post('/user/rental/store', [RentalController::class, 'store'])->name('user.rental.store')->middleware('auth');
Route::delete('/user/rental/{id}', [RentalController::class, 'destroy'])->name('user.rental.destroy')->middleware('auth');


//rental route for admin
Route::middleware('AdminMiddleware:admin')->prefix('admin')->group(function () {
    // Resource routes (index, create, store, show, edit, update, destroy)
    Route::get('/rental', [AdminRentalController::class, 'index'])->name('admin.rental.index');
    Route::get('/rental/create', [AdminRentalController::class, 'create'])->name('admin.rental.create');
    Route::get('/rental/{id}', [AdminRentalController::class, 'show'])->name('admin.rental.show');
    Route::get('/rental/{id}/edit', [AdminRentalController::class, 'edit'])->name('admin.rental.edit');


    Route::post('/rental/store', [AdminRentalController::class, 'store'])->name('admin.rental.store');
    Route::post('/rental/{id}', [AdminRentalController::class, 'update'])->name('admin.rental.update');
    Route::delete('/rental/{id}', [AdminRentalController::class, 'destroy'])->name('admin.rental.destroy');

    // Custom route for updating the status of a rental
    Route::post('/rental/{id}/status', [AdminRentalController::class, 'updateStatus'])->name('admin.rental.updateStatus');
});

//test manage cars without auth

Route::middleware('AdminMiddleware:admin')->prefix('admin')->group(function () {
    //manage cars
    Route::get('/cars', [CarController::class, 'index'])->name('admin.cars.index');
    Route::get('/cars/create', [CarController::class, 'create'])->name('admin.cars.create');
    Route::get('/cars/{car}', [CarController::class, 'show'])->name('admin.cars.show');
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('admin.cars.edit');
    Route::post('/cars', [CarController::class, 'store'])->name('admin.cars.store');
    Route::post('/cars/{car}', [CarController::class, 'update'])->name('admin.cars.update');
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('admin.cars.destroy');
});





require __DIR__ . '/auth.php';

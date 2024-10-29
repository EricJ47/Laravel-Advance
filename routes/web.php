<?php

use App\DataTables\UsersDataTable;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Laravel\Facades\Image;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (UsersDataTable $dataTable) {
    return $dataTable->render('dashboard', ['dataTable' => $dataTable]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/image', function () {
    $image = ImageManager::imagick()->read('badass.jpg');

    // $image->blur(50);
    $image->greyscale();

    // $image->crop(2000,600);
    // $image->flip();
    // $image->resize(300, 200);
    $image->save('badass4.jpg'); 
    // return $image->response(); this no longer works on intervention v3
    
});

// Route::post('/upload', function (Request $request) {
//     $image = Image::read($request->file('image'));
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

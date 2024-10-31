<?php

use App\DataTables\UsersDataTable;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Laravel\Facades\Image;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::get('shop', [CartController::class, 'shop'])->name('shop');

Route::get('cart', [CartController::class,'cart'])->name('cart');
Route::get('add-to-cart/{id}', [CartController::class,'addToCart'])->name('add-to-cart');
Route::get('qty-increment/{rowId}', [CartController::class, 'qtyIncrement'])->name('qty-increment');
Route::get('qty-decrement/{rowId}', [CartController::class, 'qtyDecrement'])->name('qty-decrement');
Route::get('remove-product/{rowId}', [CartController::class, 'removeProduct'])->name('remove-product');


Route::get('create-role', function () {

    // $role = Role::create(['name' => 'Publisher']);
    // $permission = Permission::create(['name' => 'edit articles']);

    // return $permission;

    // return auth()->user();

    // $user = User::find(1);
    $user = User::find(1);
    // $user->assignRole('writer');
    // $user->givePermissionTo('edit articles');
    // $user->getPermissionNames();
    // $user->getRoleNames();
    // $user->can('delete articles');
    $checkPermission = $user->can('edit articles');

    if ($checkPermission) {
        return 'User can edit articles or have edit articles permission';
    }else{
        return 'User cannot edit articles';
    }

    // return $checkPermission;
});


Route::get('posts', function(){
    
    // auth()->user()->assignRole('writer');
    $posts = Post::all();
    return view('post.post', compact('posts'));
});

Route::get('/auth/redirect', function () {
   return Socialite::driver('github')->redirect();

})->name('github.login');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    $user = User::firstOrCreate([
        'email' => $user->email,
        
        
    ],
    [
        'name' => $user->name,
        'password' => bcrypt(Str::random(8)),
        
        ]

);

    Auth::login($user, true);
    return redirect('/dashboard');
    // dd($user);

});
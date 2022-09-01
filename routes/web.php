<?php

use App\Models\Pizza;
use Laravel\Jetstream\Rules\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserCheckMiddleware;
use App\Http\Middleware\AdminCheckMiddleware;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PizzaController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CategoryController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin#profile');
            } else if (Auth::user()->role == 'user') {
                return redirect()->route('user#index');
            }
        }
    })->name('dashboard');
});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>AdminCheckMiddleware::class], function () {

    Route::get('profile', [AdminController::class, 'profile'])->name('admin#profile');
    Route::post('update/{id}',[AdminController::class,'updateProfile'])->name('admin#updateProfile');
    Route::get('changePasswordPage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
    Route::post('changePassword/{id}',[AdminController::class,'changePassword'])->name('admin#changePassword');
    Route::get('userList',[AdminController::class,'userList'])->name('admin#userList');
    Route::get('userList/search',[AdminController::class,'userSearch'])->name('admin#userSearch');
    Route::get('userList/delete/{id}',[AdminController::class,'deleteUserList'])->name('admin#deleteUserList');
    Route::get('adminList/search',[AdminController::class,'adminSearch'])->name('admin#adminSearch');
    Route::get('adminList', [AdminController::class,'adminList'])->name('admin#adminList');
    Route::get('adminList/edit/{id}',[AdminController::class,'adminListEdit'])->name('admin#editAdminList');
    Route::get('adminList/delete/{id}',[AdminController::class,'deleteUserList'])->name('admin#deleteAdminList');
    Route::get('adminList/download',[AdminController::class,'adminListDownload'])->name('admin#adminListDownload');
    Route::post('adminList/update/{id}',[AdminController::class,'updateAdminAccount'])->name('admin#updateAdminAccount');
    Route::get('userList/download',[AdminController::class,'userListDownload'])->name('admin#userListDownload');

    Route::get('category', [CategoryController::class, 'category'])->name('admin#category');
    Route::get('addCategory', [CategoryController::class, 'addCategory'])->name('admin#addCategory');
    Route::post('createCategory', [CategoryController::class, 'createCategory'])->name('admin#createCategory');
    Route::get('deleteCategory/{id}', [CategoryController::class, 'deleteCategory'])->name('admin#deleteCategory');
    Route::get('editCategory/{id}', [CategoryController::class, 'editCategory'])->name('admin#editCategory');
    Route::post('updateCategory', [CategoryController::class, 'updateCategory'])->name('admin#updateCategory');
    Route::get('category/search', [CategoryController::class, 'searchCategory'])->name('admin#searchCategory');
    Route::get('categoryItem/{id}',[CategoryController::class,'categoryItem'])->name('admin#categoryItem');
    Route::get('category/download',[CategoryController::class,'categoryDownload'])->name('admin#categoryDownload');

    Route::get('pizza', [PizzaController::class, 'pizza'])->name('admin#pizza'); //list
    Route::get('createPizza', [PizzaController::class, 'createPizza'])->name('admin#createPizza');
    Route::post('createPizza', [PizzaController::class, 'insertPizza'])->name('admin#insertPizza');
    Route::get('deletePizza/{id}', [PizzaController::class, 'deletePizza'])->name('admin#deletePizza');
    Route::get('infoPizza/{id}', [PizzaController::class, 'infoPizza'])->name('admin#infoPizza');
    Route::get('editPizza/{id}', [PizzaController::class, 'editPizza'])->name('admin#editPizza');
    Route::post('updatePizza/{id}',[PizzaController::class,'updatePizza'])->name('admin#updatePizza');
    Route::get('pizza/search',[PizzaController::class,'searchPizza'])->name('admin#searchPizza');
    Route::get('pizza/download',[PizzaController::class,'pizzaDownload'])->name('admin#downloadPizza');

    Route::get('contact/list',[ContactController::class,'contactList'])->name('admin#contactList');
    Route::get('contactSearch',[ContactController::class,'contactSearch'])->name('admin#contactSearch');
    Route::get('contact/download',[ContactController::class,'contactDownload'])->name('admin#downloadContact');

    Route::get('order',[OrderController::class,'orderList'])->name('admin#orderList');
    Route::get('order/search',[OrderController::class,'orderSearch'])->name('admin#orderSearch');
    Route::get('order/download',[OrderController::class,'orderDownload'])->name('admin#downloadOrder');


});

Route::group(['prefix' => 'user','middleware'=>UserCheckMiddleware::class], function () {
    Route::get('/', [UserController::class, 'index'])->name('user#index');
    Route::post('createContact',[ContactController::class,'createContact'])->name('user#createContact');
    Route::get('pizza/details/{id}',[UserController::class,'pizzaDetails'])->name('user#pizzaDetails');
    Route::get('category/pizzas/{id}',[UserController::class,'categoryLink'])->name('user#categoryLink');
    Route::get('pizzaSearch', [UserController::class, 'pizzaSearch'])->name('user#pizzaSearch');
    Route::get('price/Search',[UserController::class,'priceSearch'])->name('user#priceSearch');
    Route::get('order',[UserController::class,'order'])->name('user#order');
    Route::post('order',[UserController::class,'placeOrder'])->name('user#placeOrder');
});

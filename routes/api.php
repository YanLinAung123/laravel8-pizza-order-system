<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PizzaController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CategoryController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user',function(Request $request){
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);

Route::get('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');


Route::group(['prefix'=>'admin/category','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
    // Route::get('list',[ApiController::class,'categoryList']);
    // Route::post('create',[ApiController::class,'createCategory']);
    // Route::get('details/{id}',[ApiController::class,'detailsCategory']);
    // Route::post('update',[ApiController::class,'updateCategory']);
    Route::get('/list', [CategoryController::class, 'category']);
    Route::post('/create', [CategoryController::class, 'createCategory']);
    Route::get('/delete/{id}', [CategoryController::class, 'deleteCategory']);
    Route::get('/edit/{id}', [CategoryController::class, 'editCategory']);
    Route::post('/update/{id}', [CategoryController::class, 'updateCategory']);
    Route::get('/search', [CategoryController::class, 'searchCategory']);
    Route::get('categoryItem/{id}',[CategoryController::class,'categoryItem']);
    Route::get('/download',[CategoryController::class,'categoryDownload']);

});

Route::group(['prefix'=>'admin/contact','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
    Route::get('/list',[ContactController::class,'contactList'])->name('admin#contactList');
    Route::get('/search',[ContactController::class,'contactSearch'])->name('admin#contactSearch');
    Route::get('/download',[ContactController::class,'contactDownload'])->name('admin#downloadContact');

});

Route::group(['prefix'=>'admin/pizza','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
    Route::get('/list', [PizzaController::class, 'pizza']);
    Route::post('/create', [PizzaController::class, 'insertPizza']);
    Route::get('/delete/{id}', [PizzaController::class, 'deletePizza']);
    Route::get('info/{id}', [PizzaController::class, 'infoPizza']);
    Route::get('edit/{id}', [PizzaController::class, 'editPizza']);
    Route::post('update/{id}',[PizzaController::class,'updatePizza']);
    Route::get('search',[PizzaController::class,'searchPizza']);
    Route::get('/download',[PizzaController::class,'pizzaDownload']);

});

Route::group(['prefix'=>'admin/order','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
    Route::get('/list',[OrderController::class,'orderList']);
    Route::get('/search',[OrderController::class,'orderSearch']);
    Route::get('/download',[OrderController::class,'orderDownload']);

});

Route::group(['prefix'=>'admin/','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
    Route::get('profile', [AdminController::class, 'profile']);
    Route::post('update/{id}',[AdminController::class,'updateProfile']);
    Route::post('changePassword/{id}',[AdminController::class,'changePassword']);
    Route::get('userList',[AdminController::class,'userList']);
    Route::get('userList/search',[AdminController::class,'userSearch']);
    Route::get('userList/delete/{id}',[AdminController::class,'deleteUserList']);
    Route::get('adminList/search',[AdminController::class,'adminSearch']);
    Route::get('adminList', [AdminController::class,'adminList']);
    Route::get('adminList/edit/{id}',[AdminController::class,'adminListEdit']);
    Route::get('adminList/delete/{id}',[AdminController::class,'deleteUserList']);
    Route::get('adminList/download',[AdminController::class,'adminListDownload']);
    Route::post('adminList/update/{id}',[AdminController::class,'updateAdminAccount']);
    Route::get('userList/download',[AdminController::class,'userListDownload']);


});

Route::group(['prefix'=>'user/','namespace'=>'API','middleware'=>'auth:sanctum',UserCheckMiddleware::class],function(){
    Route::get('/index', [UserController::class, 'index']);
    Route::post('createContact',[ContactController::class,'createContact']);
    Route::get('pizza/details/{id}',[UserController::class,'pizzaDetails']);
    Route::get('category/pizzas/{id}',[UserController::class,'categoryLink']);
    Route::get('pizzaSearch', [UserController::class, 'pizzaSearch']);
    Route::get('price/search',[UserController::class,'priceSearch']);



});




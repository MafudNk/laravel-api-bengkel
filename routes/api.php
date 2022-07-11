<?php

use App\Entities\TPenerimaanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\MMobilsController;
use App\Http\Controllers\MSparepartsController;
use App\Http\Controllers\MSuppliersController;
use App\Http\Controllers\TPenerimaanBarangsController;
use App\Http\Controllers\TPerbaikansController;

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
/**Route for login API */


//get token
Route::post('token', [AuthController::class, 'auth']);

Route::post('/customer_post/{id}', [CustomersController::class, 'update_post']);
Route::post('/user_post/{id}', [UserController::class, 'update_post']);
/**Midlleware for Auth Routes */
Route::middleware('auth:api','VerifyApi')->group(function(){
    Route::resources([
        
        'user' => UserController::class,
        'customer' => CustomersController::class,
        'mobil' => MMobilsController::class,
        'sparepart' => MSparepartsController::class,
        'perbaikan' => TPerbaikansController::class,
        'penerimaan_barang' => TPenerimaanBarangsController::class,
        'supplier' => MSuppliersController::class,
        'user' => UserController::class,
    ]);
    Route::get('/validate-token', function () {
        return ['data' => 'Token is valid'];
    })->middleware('auth:api');
    // Route::get('/customer', [CustomersController::class,'index'])->middleware('api.admin');
    Route::post('logout', [AuthController::class, 'logout']);
    
});


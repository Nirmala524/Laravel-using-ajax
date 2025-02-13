<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('blog.index');
// });

Route::get('/',[BlogController::class,'index']);
Route::get('/getdata',[BlogController::class,'getdata']);
Route::Post('/storedata',[BlogController::class,'store']);
Route::get('/editdata/{id}',[BlogController::class,'edit']);
Route::post('/update',[BlogController::class,'update']);
Route::get('/deletedata/{id}',[BlogController::class,'destory']);



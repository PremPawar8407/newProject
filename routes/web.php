<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/
Route::get(' ', function () {
	
    return view('welcome');
});/*
Route::view('/welcome','welcome');
Route::view('/form','inserfrom');
 //controller use in route sntx
 use  App\Http\Controllers\WCcontroller;
 Route::post('/see',[WCcontroller::class,'show']);
 Route::view('/profile',"profile");


*/

 Route::view('/log',"loginform");
 
 use App\Http\Controllers\logincontroller;

 //Route::get('/login',[logincontroller::class,'display']);

 use App\Http\Controllers\pagicontroller;

Route::get('page',[pagicontroller::class,'show']);
 Route::view('/some',"new");








Route::get('/CRUD_show','App\Http\Controllers\CRUDcontroller@display');
Route::view('main',"display");
Route::get('/delete/{id}','App\Http\Controllers\CRUDcontroller@delete');
Route::view('/insert',"from");
Route::post('edit','App\Http\Controllers\CRUDcontroller@insert');
Route::get('update/{id}','App\Http\Controllers\CRUDcontroller@update');
Route::POST('update/update_form/{id}','App\Http\Controllers\CRUDcontroller@edit');





Route::get('ins','App\Http\Controllers\insrcontro@insert');

Route::get('log','App\Http\Controllers\login@checkCredential');

Route::view('sign_in',"sign_in");



<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\firstapicontroller;
Route::post('/first',[firstapicontroller::class,"first"]);



use App\Http\Controllers\deletecontroller;
Route::get('/delete',[deletecontroller::class,"delete"]);
Route::view('/upload',"uploadfile");
use App\Http\Controllers\fileuploadController;
Route::post('/file',[fileuploadController::class,"img"]);

use App\Http\Controllers\agrigatontroller;
Route::get('data',[agrigatontroller::class,"mathfun"]);


use App\Http\Controllers\accessorController;
Route::get('accessor',[accessorController::class,"showdata"]);

use App\Http\Controllers\mutatorcontroller;
Route::post('mutator',[mutatorcontroller::class,"data"]);

Route::view('search',"Search");
use App\Http\Controllers\searchController;
Route::get('ss',[searchController::class,"searchvalue"]);
Route::view('dataview',"datas");

Route::get('users/fetch_users', 'App\Http\Controllers\searchController@getAllUsers');


Route::get('displayall', 'App\Http\Controllers\fetchAllcontro@fetchAll');


use App\Http\Controllers\fetchdbcontroller;
Route::get('display',[fetchdbcontroller::class,"fetchasc"]);






Route::get('fetch_data/{id}/{name}', 'App\Http\Controllers\fetchdbcontroller@fetchasc');
//Route::get('print', 'App\Http\Controllers\fetchdbcontroller@fetchasc');
Route::get('swa_parameter', 'App\Http\Controllers\parametercontroller@parameter');



Route::post('user', 'App\Http\Controllers\postcontroller@post');

Route::delete('deleteswagg','App\Http\Controllers\dlswaggercontroller@deleteswag');


Route::PUT('/update','App\Http\Controllers\updatecontroller@update');

Route::post('teacher_table', 'App\Http\Controllers\teachercontroller@teacherfun');


Route::post('student_table', 'App\Http\Controllers\studentcontroller@stundentfun');

Route::get('join', 'App\Http\Controllers\joincontroller@join');

Route::post('class', 'App\Http\Controllers\calsscontroller@twevelth');


Route::get('orderby', 'App\Http\Controllers\classorderby@clasassdec');

Route::get('searchapi', 'App\Http\Controllers\serachapi@searchvalue');

Route::post('prem','App\Http\Controllers\procontroller@fun_name');



Route::get('fetch_class','App\Http\Controllers\fetchclasscontro@fetch_class');


Route::delete('delete_class','App\Http\Controllers\deleteclasscontro@deleteclass');

Route::post('feeinsert','App\Http\Controllers\feeinsertcontro@feefun');

Route::get('newjoin','App\Http\Controllers\NEWcontroller@newjoin');

Route::view('from',"inserfrom");
Route::get('see','App\Http\Controllers\WCcontroller@show');


Route::post('dockerfirst','App\Http\Controllers\dockerfirstcontroller@show');

Route::delete('dockerdelete','App\Http\Controllers\dockerdeletecontroller@delete_docker');

Route::get('showEmployeeData','App\Http\Controllers\fetchEmployee@displayemployee');

Route::post('employee/add','App\Http\Controllers\fetchEmployee@insertemployee');

Route::post('insertData','App\Http\Controllers\sigup@insertData');

Route::post('login','App\Http\Controllers\logincontroller@accountLogin');

Route::get('responePractice','App\Http\Controllers\studentcontroller@responePractice');

Route::get('validtoken','App\Http\Controllers\logincontroller@validToken');

Route::post('addFolder','App\Http\Controllers\folderController@insertFolder');

Route::get('folderList','App\Http\Controllers\folderController@fetchFolder');

Route::get('listAllFolder
	','App\Http\Controllers\folderController@fetchFolderType');


Route::get('listAllFolderUserId','App\Http\Controllers\folderController@listAllFolder');

Route::post('update_folder','App\Http\Controllers\folderController@updateFolder');

Route::post('addGroup', 'App\Http\Controllers\groupController@addGroup');

Route::post('deleteGroup', 'App\Http\Controllers\groupController@deleteGroup');

Route::post('updateGroup', 'App\Http\Controllers\groupController@updateGroup');

Route::get('listAll', 'App\Http\Controllers\groupController@fetchAllGroup');

Route::get('details', 'App\Http\Controllers\groupController@groupDetails');

Route::post('addContact', 'App\Http\Controllers\contactController@addContact');

Route::post('updateContact', 'App\Http\Controllers\contactController@updateContact');

Route::get('contactListAll', 'App\Http\Controllers\contactController@contactListAll');

Route::post('addCategory', 'App\Http\Controllers\categoryController@addCategory');

Route::post('updateCategory', 'App\Http\Controllers\categoryController@updateCategory');

Route::get('category/listAll', 'App\Http\Controllers\categoryController@categoryListAll');

Route::get('category/list_all_by_user', 'App\Http\Controllers\categoryController@listAllByUser');

Route::post('template/add', 'App\Http\Controllers\templateController@addTemplate');
Route::post('template/update', 'App\Http\Controllers\templateController@updateTemplate');

Route::get('downloadusr', 'App\Http\Controllers\downloadUsrController@export');
Route::get('template_list_all_by_userID', 'App\Http\Controllers\templateController@listAllByUerID');

Route::get('templateListAll', 'App\Http\Controllers\templateController@templateListAll');

Route::get('template_listDripMessages', 'App\Http\Controllers\templateController@listDripMessages');

Route::post('create', 'App\Http\Controllers\mongoDbController@crateRegistration');

Route::get('read', 'App\Http\Controllers\mongoDbController@readData');

Route::put('updateData', 'App\Http\Controllers\mongoDbController@updateData');

Route::delete('deleteData', 'App\Http\Controllers\mongoDbController@deleteData');


















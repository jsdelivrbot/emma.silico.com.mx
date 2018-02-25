<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//
/*
Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    var_dump($query->sql);
    var_dump($query->bindings);
    var_dump($query->time);
});*/


Route::get('/', 'HomeController@index');
// Route::get('/', 'CatsController@index');

Route::get('/cats', 'CatsController@index');

Route::get('/admin', 'AdministrationController@index');
Route::get('/reports', 'ReportsController@index');
Route::get('/boards', 'AdministrationController@indexBoards')->name('boards');
// Route::get('/uploadUsers/{exam}', 'AdministrationController@users_upload')->name('uploadUsers');
Route::get('/uploadUsers/{board}', 'AdministrationController@users_upload')->where('id', '[0-9]+')->name('uploadUsers');
Route::get('/home', 'HomeController@index');
/*Monitor exams*/
Route::get('/monitorExams/{board}', 'AdministrationController@monitorExams')->name('monitorExams');
Route::get('/monitor/{exam}', 'AdministrationController@monitor')->name('monitor');
Route::get('monitor/student/{exam}/{user}', 'AdministrationController@monitorStudent')->name('monitorStudent');
//List and admin users routes
Route::get('admin/board/usersList/{board}', 'AdministrationController@listBoardUsers')->name('userslist');
Route::get('admin/users/passwords/{exam}', 'AdministrationController@createUsersPdf')->name('passwordsPdf');
//Reports routes
Route::get('reports/{exam}', 'ReportsController@users')->name('reportUsers');
Route::get('reports/board/{board}', 'ReportsController@aviable')->name('aviableReports');
Route::get('reports/analysis/{exam}', 'ReportsController@itemAnalysis')->name('iteman');
Route::get('reports/key/{exam}', 'ReportsController@keyDump')->name('key');
Route::get('reports/single/{user}/{exam}', 'ReportsController@singleStudent')->name('singleReport');
Route::get('reports/template/{board}', 'ReportsController@template')->name('template');
//Slots routes
Route::resource('slots', 'SlotsController');


Route::get('/user', 'ExamController@user_dashboard');
Route::post('/exams/start', 'ExamController@start');
//Route::get('exams/generalIndex', 'ExamController@generalIndex')->name('generalIndex')->middleware('checkExam');//Commented to temporarily disable the middleware
Route::get('exams/generalIndex', 'ExamController@generalIndex')->name('generalIndex');
//Route::get('exams/slot/{slot}', 'ExamController@answerSlot')->name('exams.slot')->middleware('checkExam');
Route::get('exams/slot/{slot}', 'ExamController@answerSlot')->name('exams.slot');
//Route::post('/answers/store', 'AnswersController@store')->middleware('checkExam');
Route::post('/answers/store', 'AnswersController@store');
Route::post('/exams/finish', 'ExamController@finish')->name('exams.finish');

//Exam creation Route
Route::get('exam/upload', 'UploadController@exam_prepare');
Route::post('exam/upload', 'UploadController@exam_csv');
Route::post('exam/upload/images', 'UploadController@examImages');
Route::post('exam/uploadimage', 'UploadControllerTest@image');
//<image upload test>
// Route::post('/uploadImage', 'UploadController@image');
//</image upload test>


Route::get('/cats/{cat}', 'CatsController@show')->where('id', '[0-9]+');
Route::post('/cats/{cat}/quotes', 'QuotesController@store');
Route::resource('quotes', 'QuotesController');
Route::get('/quotes/{quote}/delete', 'QuotesController@destroy');

Route::resource('exams', 'ExamController');
Route::post('/exams/users', 'ExamController@users_exam');
Route::get('/exams/grade_chart/{exam}', 'ExamController@grade_all_chart');
Route::get('/exams/progress_chart/{exam}', 'ExamController@progress_present_chart');
Route::get('/exams/grade_user/{exam}/{user}', 'ExamController@grade_student');
Route::get('/exams/grade_all/{exam}', 'ExamController@grade_all');
Route::get('/exams/top_students/{exam}/{top}', 'ExamController@top_students');
Route::get('/exams/bottom_students/{exam}/{bottom}', 'ExamController@bottom_students');
//Route::resource('answers', 'AnswersController');
// Route::resource('/answers', 'AnswersController@store');
Route::resource('distractors', 'DistractorsController');

Route::resource('slots', 'SlotsController');
/* Grading */

Route::get('spreadsheet/{exam}', 'ExamController@gradesSpreadshet')->name('gradesSpreadsheet');

Route::resource('locations', 'LocationsController');
Route::resource('users', 'UsersController');
Route::resource('centers', 'CentersController');
Route::resource('vignettes', 'VignettesController');
Route::post('questions/distractors/{question}', 'QuestionController@updateDistractors')->name('questionDistractors');
Route::resource('questions', 'QuestionController');
Route::resource('distractors', 'DistractorsController');

Auth::routes();


Route::post('/uploadUsers', 'UploadController@users_csv')->name('uploadCsvUsers');
Route::post('/uploadUsersPics', 'UploadController@pictures')->name('userPictures');
Route::post('/uploadUserAvatar', 'UploadController@userAvatar')->name('userAvatar');
Route::post('uploadUsersExcel', 'UploadController@usersExcel')->name('uploadUsersExcel');

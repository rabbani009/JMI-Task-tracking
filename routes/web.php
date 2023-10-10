<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControllers\{
    ForgotPasswordController,
    LoginController,
    LogoutController,
    RegisterController,
    ResetPasswordController,

};
use App\Http\Controllers\BackendControllers\{
    
    DashboardController,
    SbuController,
    TaskController,
    AjaxController,
    StageTrackController,
    ReportController,
    SearchController,
    PDFController,
    ReasonController


  


};

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

Route::get('/', [HomeController::class, 'getHome'])->name('home');

Route::group(['namespace' => 'AuthControllers'], function () {
    Route::get('login', [LoginController::class, 'getLogin'])->name('get.login');
    Route::post('login', [LoginController::class, 'postLogin'])->name('post.login');

    Route::get('logout', [LogoutController::class, 'getLogout'])->name('get.logout');
    Route::post('logout', [LogoutController::class, 'postLogout'])->name('post.logout');

    Route::get('register', [RegisterController::class, 'getRegister'])->name('get.register');
    Route::post('register', [RegisterController::class, 'postRegister'])->name('post.register');

    Route::get('forgot-password', [ForgotPasswordController::class, 'getForgotPassword'])->name('get.forgot.password');
    Route::post('forgot-password', [ForgotPasswordController::class, 'postForgotPassword'])->name('post.forgot.password');

    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'getResetPassword'])->name('get.reset.password');
    Route::post('reset-password', [ForgotPasswordController::class, 'postResetPassword'])->name('post.reset.password');
});


Route::group(['prefix' => 'backend', 'middleware' => 'authenticated'], function () {
    Route::get('dashboard', [DashboardController::class, 'getDashboard'])->name('get.dashboard');

    Route::resource('sbu', SbuController::class);
    Route::resource('task', TaskController::class);
    Route::resource('stage', StageTrackController::class);
    Route::resource('report', ReportController::class);

    //Task Finished.........

    Route::post('/tasks/{task}/complete',[TaskController::class,'complete'])->name('tasks.complete');


    Route::post('/update-reason/{task_id}', [ReasonController::class, 'update'])->name('updateReason');



   

    //Search filtered items

     Route::get('/filter-task-wise-data',[SearchController::class,'search']);

     Route::get('/filter-sbu-wise-data',[SearchController::class,'searchsbu']);

     Route::get('/filter-person-wise-data',[SearchController::class,'searchperson']);

     Route::get('/filter-product-wise-data',[SearchController::class,'searchproduct']);


     //PDF routes.........

      Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate-pdf');

    //   Route::get('/generate-allpdf', [PDFController::class, 'generateallPDF'])->name('generate-allpdf');

    Route::get('/generateall-pdf/{task_id}', [PDFController::class, 'generateallPDF'])->name('generateall-pdf');




    // Ajax routes ........

      Route::get('getTaskData/{taskId}',[AjaxController::class,'getTaskData']);

      Route::post('saveTaskTrackData', [AjaxController::class, 'saveTaskTrackData']);




 
    
   

});





















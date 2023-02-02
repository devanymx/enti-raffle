<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\PublicController;
use App\Models\QuestionAnswer;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    return redirect('login');
});

//Errors
Route::get('/forbidden', [PublicController::class, 'defaultTemplate'])->name('forbidden');

//Verify
Route::get('/exam/download/{uuid}',[ExamController::class,'downloadCertificate'])->name('exam.download');

Route::get('/answers-import',[PublicController::class, 'importViewa'])->name('import-view-a');
Route::get('/questions-import',[PublicController::class, 'importViewq'])->name('import-view-q');
Route::get('/users-import',[PublicController::class, 'importViewu'])->name('import-view-u');
Route::post('/a-import',[PublicController::class, 'importa'])->name('import-a');
Route::post('/q-import',[PublicController::class, 'importq'])->name('import-q');
Route::post('/u-import',[PublicController::class, 'importu'])->name('import-u');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard',[AdminController::class,'showDashboard'])->name('dashboard');
    Route::get('/confirm',[AdminController::class,'addConfirmed'])->name('user.register');
    Route::post('/confirm',[AdminController::class,'confirmUser'])->name('user.confirm');


    //Exam
    Route::get('/exam', [ExamController::class,'showExam'])->name('exam.show');
    Route::get('/start', [ExamController::class,'startRaffle'])->name('exam.start');

});

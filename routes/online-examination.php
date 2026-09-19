<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Examination\ExamTypeController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\OnlineExamination\OnlineExamController;
use App\Http\Controllers\OnlineExamination\QuestionBankController;
use App\Http\Controllers\OnlineExamination\QuestionGroupController;


Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:online_examination']], function () {
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
    
                Route::controller(ExamTypeController::class)->prefix('online-exam-type')->group(function () {
                    Route::get('/',                 'index')->name('online-exam-type.index')->middleware('PermissionCheck:online_exam_type_read');
                    Route::get('/create',           'create')->name('online-exam-type.create')->middleware('PermissionCheck:online_exam_type_create');
                    Route::post('/store',           'store')->name('online-exam-type.store')->middleware('PermissionCheck:online_exam_type_create');
                    Route::get('/edit/{id}',        'edit')->name('online-exam-type.edit')->middleware('PermissionCheck:online_exam_type_update');
                    Route::put('/update/{id}',      'update')->name('online-exam-type.update')->middleware('PermissionCheck:online_exam_type_update');
                    Route::delete('/delete/{id}',   'delete')->name('online-exam-type.delete')->middleware('PermissionCheck:online_exam_type_delete');
                });
                Route::controller(QuestionGroupController::class)->prefix('question-group')->group(function () {
                    Route::get('/',                 'index')->name('question-group.index')->middleware('PermissionCheck:question_group_read');
                    Route::get('/create',           'create')->name('question-group.create')->middleware('PermissionCheck:question_group_create');
                    Route::post('/store',           'store')->name('question-group.store')->middleware('PermissionCheck:question_group_create');
                    Route::get('/edit/{id}',        'edit')->name('question-group.edit')->middleware('PermissionCheck:question_group_update');
                    Route::put('/update/{id}',      'update')->name('question-group.update')->middleware('PermissionCheck:question_group_update');
                    Route::delete('/delete/{id}',   'delete')->name('question-group.delete')->middleware('PermissionCheck:question_group_delete');
                    Route::any('/search',           'search')->name('question-group.search')->middleware('PermissionCheck:question_group_read');
                });
                Route::controller(QuestionBankController::class)->prefix('question-bank')->group(function () {
                    Route::get('/',                 'index')->name('question-bank.index')->middleware('PermissionCheck:question_bank_read');
                    Route::get('/create',           'create')->name('question-bank.create')->middleware('PermissionCheck:question_bank_create');
                    Route::post('/store',           'store')->name('question-bank.store')->middleware('PermissionCheck:question_bank_create');
                    Route::get('/edit/{id}',        'edit')->name('question-bank.edit')->middleware('PermissionCheck:question_bank_update');
                    Route::put('/update/{id}',      'update')->name('question-bank.update')->middleware('PermissionCheck:question_bank_update');
                    Route::delete('/delete/{id}',   'delete')->name('question-bank.delete')->middleware('PermissionCheck:question_bank_delete');
                    Route::any('/search',           'search')->name('question-bank.search')->middleware('PermissionCheck:question_bank_read');
                    Route::get('/get-question-group','getQuestionGroup');
                });
                Route::controller(OnlineExamController::class)->prefix('online-exam')->group(function () {
                    Route::get('/',                 'index')->name('online-exam.index')->middleware('PermissionCheck:online_exam_read');
                    Route::get('/create',           'create')->name('online-exam.create')->middleware('PermissionCheck:online_exam_create');
                    Route::post('/store',           'store')->name('online-exam.store')->middleware('PermissionCheck:online_exam_create');
                    Route::get('/edit/{id}',        'edit')->name('online-exam.edit')->middleware('PermissionCheck:online_exam_update');
                    Route::put('/update/{id}',      'update')->name('online-exam.update')->middleware('PermissionCheck:online_exam_update');
                    Route::delete('/delete/{id}',   'delete')->name('online-exam.delete')->middleware('PermissionCheck:online_exam_delete');
                    Route::any('/search',           'search')->name('online-exam.search')->middleware('PermissionCheck:online_exam_read');
                    Route::get('/answer/{id}/{student_id}', 'answer')->name('online-exam.answer')->middleware('PermissionCheck:online_exam_read');
                    Route::post('/mark-submit',     'markSubmit')->name('online-exam.mark-submit')->middleware('PermissionCheck:online_exam_read');
                    Route::get('/question-download/{id}','questionDownload')->name('online-exam.question-download')->middleware('PermissionCheck:online_exam_read');
    
                    Route::get('/get-all-questions',  'getAllQuestions');
                    Route::get('/view-students',      'viewStudents');
                    Route::get('/view-questions',     'viewQuestions');
                });
            });
        });
    });
});



<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SettingAPIController;
use App\Http\Controllers\Api\Student\FeeAPIController;
use App\Http\Controllers\Api\Student\BookAPIController;
use App\Http\Controllers\Api\Student\HomeAPIController;
use App\Http\Controllers\Api\Student\EventAPIController;
use Modules\LiveChat\Http\Controllers\MessageController;
use App\Http\Controllers\Api\Parent\StudentAPIController;
use App\Http\Controllers\Api\Student\ResultAPIController;
use App\Http\Controllers\Api\Student\ProfileAPIController;
use App\Http\Controllers\Api\Student\SubjectAPIController;
use App\Http\Controllers\Api\Teacher\TeacherApiController;
use App\Http\Controllers\Api\Student\ExamTypeAPIController;
use App\Http\Controllers\Api\Student\HomeworkAPIController;
use App\Http\Controllers\Api\Student\AttendanceAPIController;
use App\Http\Controllers\Api\Student\IssuedBookAPIController;
use App\Http\Controllers\Api\Student\OnlineExamAPIController;
use App\Http\Controllers\Api\Student\SchoolInfoAPIController;
use App\Http\Controllers\Api\Teacher\TeacherReportController;
use App\Http\Controllers\Api\Parent\ParentTransportController;
use App\Http\Controllers\Api\Student\ExamRoutineAPIController;
use App\Http\Controllers\Api\Student\StudentInfoAPIController;
use App\Http\Controllers\Api\Teacher\TeacherRoutineController;
use App\Http\Controllers\Api\Student\ClassRoutineAPIController;
use App\Http\Controllers\Api\Parent\ParentLivechatAPIController;
use App\Http\Controllers\Api\Student\StudentTransportController;
use App\Http\Controllers\Api\Teacher\TeacherOnlineExamController;
use App\Http\Controllers\Api\Student\StudentLivechatAPIController;
use App\Http\Controllers\Api\Teacher\TeacherHomeworkApiController;
use App\Http\Controllers\Api\Teacher\TeacherStudentInfoController;
use App\Http\Controllers\Api\Teacher\TeacherLiveClassApiController;
use App\Http\Controllers\Api\Instructor\InstructorLivechatAPIController;
use App\Http\Controllers\Api\Parent\HomeworkAPIController as ParentHomeworkAPIController;


Route::middleware(saasApiMiddleware())->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('update-password', [AuthController::class, 'updatePassword']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::group(['prefix' => 'student'], function () {
            Route::get('profile', [ProfileAPIController::class, 'profile']);
            Route::post('profile', [ProfileAPIController::class, 'update']);
            Route::get('student-info', StudentInfoAPIController::class);
            Route::get('home', HomeAPIController::class);
            Route::get('subjects', SubjectAPIController::class);
            Route::get('class-routines', [ClassRoutineAPIController::class, 'index']);
            Route::get('exam-types', ExamTypeAPIController::class);
            Route::get('exam-routines', ExamRoutineAPIController::class);
            Route::get('fees/payment-gateways', [FeeAPIController::class, 'paymentGateways']);
            Route::get('fee-groups', [FeeAPIController::class, 'feeGroups']);
            Route::get('fees/{fee_group_id}', [FeeAPIController::class, 'fees']);
            Route::get('events', [EventAPIController::class, 'index']);
            Route::get('events/{id}', [EventAPIController::class, 'show']);
            Route::get('dashboard-events', [EventAPIController::class, 'dashboardEvents']);
            Route::get('online-exam-types', [OnlineExamAPIController::class, 'onlineExamTypes']);
            Route::get('online-exams', [OnlineExamAPIController::class, 'index']);
            Route::get('online-exam-questions/{online_exam_id}', [OnlineExamAPIController::class, 'onlineExamQuestions']);
            Route::post('online-exams/{online_exam_id}', [OnlineExamAPIController::class, 'store']);
            Route::get('online-exams/result/{online_exam_id}', [OnlineExamAPIController::class, 'result']);
            Route::get('results', [ResultAPIController::class, 'index']);
            Route::get('attendances', [AttendanceAPIController::class, 'index']);
            Route::get('attendance-progress', [AttendanceAPIController::class, 'attendanceProgress']);
            Route::get('yearly-present-percentage', [AttendanceAPIController::class, 'yearlyPresentPercentage']);
            Route::get('school-info', [SchoolInfoAPIController::class, 'index']);
            Route::get('current-session-teachers', [TeacherAPIController::class, 'currentSessionTeachers']);
            Route::get('teachers/{id}', [TeacherAPIController::class, 'show']);
            Route::get('teachers/assign-subjects/{id}', [TeacherAPIController::class, 'assignSubjects']);
            Route::get('homework', [HomeworkAPIController::class, 'index']);
            Route::post('homework/submit/', [HomeworkAPIController::class, 'submit']);
            Route::get('book-list/', [BookAPIController::class, 'index']);
            Route::get('issued-book-list', [IssuedBookAPIController::class, 'index']);

            Route::middleware('student')->controller(StudentLivechatAPIController::class)->prefix('livechat')->group(function () {
                Route::get('chat-list', 'chatList');
                Route::get('chat-conversions/{id}', 'chatConversions');
                Route::post('send-message', 'sendMessage');
            });

            // Student transport route
            Route::middleware('student')->controller(StudentTransportController::class)->group(function () {
                Route::get('/duty-schedules',    'dutySchedule');
                Route::get('/enrollment-report', 'enrollmentReport');
                Route::get('/live-track',        'liveTrack');
                Route::post('/feedback',         'feedback');
            });
        });


        Route::group(['prefix' => 'parent', 'middleware' => 'guardian'], function () {
            Route::get('students', [StudentAPIController::class, 'index']);
            Route::get('homework', [ParentHomeworkAPIController::class, 'index']);
            Route::get('book-list/', [BookAPIController::class, 'index']);
            Route::get('issued-book-list', [IssuedBookAPIController::class, 'index']);

            Route::prefix('livechat')->controller(ParentLivechatAPIController::class)->group(function(){
                Route::get('chat-list', 'chatList');
                Route::get('chat-conversions/{id}', 'chatConversions');
                Route::post('send-message', 'sendMessage');
            });

            // Parent transport route
            Route::controller(ParentTransportController::class)->group(function () {
                Route::get('/duty-schedules',    'dutySchedule');
                Route::get('/enrollment-report', 'enrollmentReport');
                Route::get('/live-track',        'liveTrack');
                Route::post('/feedback',         'feedback');
            });
        });

        Route::group(['prefix' => 'instructor', 'middleware' => 'instructor'], function () {
            Route::prefix('livechat')->controller(InstructorLivechatAPIController::class)->group(function () {
                Route::get('chat-list', 'chatList');
                Route::get('chat-conversions/{id}', 'chatConversions');
                Route::post('send-message', 'sendMessage');
            });
        });

        Route::prefix('live-chat')->group(function () {
            Route::controller(MessageController::class)->group(function () {
                Route::get('message-read/{id}', 'messageRead');
            });
        });


        Route::group(['prefix' => 'teacher'], function () {
            Route::get('menus', [TeacherApiController::class, 'menus']);
            Route::get('classes', [TeacherApiController::class, 'classes']);
            Route::post('subject-by-class-section', [TeacherApiController::class, 'getSubjectList']);
            Route::get('section_by_class/{id}', [TeacherApiController::class, 'sectionByClassId']);
            Route::post('attendance-search-student', [TeacherApiController::class, 'searchStudent']);
            Route::post('attendance-store', [TeacherApiController::class, 'attendanceStore']);

            Route::get('gmeet-live-class', [TeacherLiveClassApiController::class, 'gmeetLiveClass']);
            Route::post('gmeet-live-class', [TeacherLiveClassApiController::class, 'gmeetLiveClassStore']);

            Route::group(['prefix' => 'homework'], function () {
                Route::get('/list', [TeacherHomeworkApiController::class, 'list']);
                Route::post('store', [TeacherHomeworkApiController::class, 'store']);
                Route::post('update', [TeacherHomeworkApiController::class, 'update']);
                Route::post('delete', [TeacherHomeworkApiController::class, 'delete']);
                Route::get('evaluate-students/{id}', [TeacherHomeworkApiController::class, 'evaluateStudents']);
                Route::post('evaluate-students-mark', [TeacherHomeworkApiController::class, 'evaluateStudentmark']);

            });

            Route::group(['prefix' => 'student'], function () {
                Route::get('/list', [TeacherStudentInfoController::class, 'studentList']);
                Route::get('details/{id}', [TeacherStudentInfoController::class, 'studentDetails']);
            });


            Route::group(['prefix' => 'routine'], function () {
                Route::get('class', [TeacherRoutineController::class, 'classRoutines']);
                Route::get('exam', [TeacherRoutineController::class, 'examRoutines']);
            });


            Route::group(['prefix' => 'online-exam'], function () {
                Route::get('types', [TeacherOnlineExamController::class, 'types']);
                Route::get('list', [TeacherOnlineExamController::class, 'list']);
                Route::get('questions/{id}', [TeacherOnlineExamController::class, 'questions']);
                 Route::get('results/{id}', [TeacherOnlineExamController::class, 'results']);
            });


            Route::group(['prefix' => 'report'], function () {
                Route::get('student-marksheet', [TeacherReportController::class, 'studentMarksheet']);
                Route::get('student-merit-list', [TeacherReportController::class, 'studentMeritList']);
                Route::get('student-progress-card', [TeacherReportController::class, 'studentProgressCard']);
                Route::get('monthly-attendance', [TeacherReportController::class, 'attendanceReport']);

            });



        });


    });
});


Route::get('pushar-settings', [SettingAPIController::class, 'pusherSettings']);

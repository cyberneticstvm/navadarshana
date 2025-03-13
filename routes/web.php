<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentFeedbackController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoRecorded;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');;

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('/dashboard')->controller(UserController::class)->group(function () {
        Route::get('/', 'dashboard')->name('dashboard');
        Route::post('/update/branch', 'updateBranch')->name('user.branch.update');
    });
});

Route::middleware(['web', 'auth', 'branch'])->group(function () {

    Route::prefix('ajax')->controller(AjaxController::class)->group(function () {
        Route::get('/get/ddl', 'getDropDown')->name('get.ddl');
        Route::get('/student/detail/{id}', 'getStudentDetails')->name('get.student.details');
        Route::get('/student/batch/{id}/{action}', 'getStudentDetailsForBatch')->name('get.student.details.for.batch');
        Route::get('/course/syllabus/{id}/{action}', 'getSyllabusDetailsForCourse')->name('get.syllabus.details.for.course');
        Route::get('/syllabus/module/{id}/{action}', 'getModulesForSyllabus')->name('get.modules.for.syllabus');
        Route::get('/module/topic/{id}/{action}', 'getTopicsForModule')->name('get.topics.for.module');
        Route::get('/batch/module/topic/{sid}/{bid}/{fid}', 'getModuleTopicsForSyllabus')->name('get.module.topics.for.syllabus');
        Route::post('/update/batch/topic/status', 'updateBatchTopicStatus')->name('update.batch.topic.status');
    });

    Route::prefix('/dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('/student/comparison', 'studentComparisonChart')->name('student.comparison.chart');
        Route::get('/student/fee/percentage', 'studentFeePerChart')->name('student.fee.per.chart');
        Route::get('/student/cancel', 'studentCancelChart')->name('student.cancel.chart');

        Route::get('/student/fee/collection', 'studentFeeCollectionChart')->name('student.fee.collection.chart');
        Route::get('/finance/ie/', 'ieTotal')->name('finance.ie.chart');
    });

    Route::prefix('/dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('/student', 'studentDashboard')->name('dashboard.student');
        Route::get('/finace', 'financeDashboard')->name('dashboard.finance');
    });

    Route::prefix('/user')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('user.register');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/create', 'store')->name('user.save');
        Route::get('/edit/{id}', 'edit')->name('user.edit');
        Route::post('/edit/{id}', 'update')->name('user.update');
        Route::get('/delete/{id}', 'destroy')->name('user.delete');
    });

    Route::prefix('/role')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('role.register');
        Route::get('/create', 'create')->name('role.create');
        Route::post('/create', 'store')->name('role.save');
        Route::get('/edit/{id}', 'edit')->name('role.edit');
        Route::post('/edit/{id}', 'update')->name('role.update');
        Route::get('/delete/{id}', 'destroy')->name('role.delete');
    });

    Route::prefix('/branch')->controller(BranchController::class)->group(function () {
        Route::get('/', 'index')->name('branch.register');
        Route::get('/create', 'create')->name('branch.create');
        Route::post('/create', 'store')->name('branch.save');
        Route::get('/edit/{id}', 'edit')->name('branch.edit');
        Route::post('/edit/{id}', 'update')->name('branch.update');
        Route::get('/delete/{id}', 'destroy')->name('branch.delete');
    });

    Route::prefix('/student')->controller(StudentController::class)->group(function () {
        Route::get('/', 'index')->name('student.register');
        Route::get('/create', 'create')->name('student.create');
        Route::post('/create', 'store')->name('student.save');
        Route::get('/edit/{id}', 'edit')->name('student.edit');
        Route::post('/edit/{id}', 'update')->name('student.update');
        Route::get('/delete/{id}', 'destroy')->name('student.delete');
    });

    Route::prefix('/course')->controller(CourseController::class)->group(function () {
        Route::get('/', 'index')->name('course.register');
        Route::get('/create', 'create')->name('course.create');
        Route::post('/create', 'store')->name('course.save');
        Route::get('/edit/{id}', 'edit')->name('course.edit');
        Route::post('/edit/{id}', 'update')->name('course.update');
        Route::get('/delete/{id}', 'destroy')->name('course.delete');

        Route::post('/syllabus/save', 'save')->name('course.syllabus.save');
        Route::get('/syllabus/remove/{id}', 'courseSyllabusRemove')->name('course.syllabus.remove');
        Route::get('/syllabus/restore/{id}', 'courseSyllabusRestore')->name('course.syllabus.restore');
    });

    Route::prefix('/syllabus')->controller(SyllabusController::class)->group(function () {
        Route::get('/', 'index')->name('syllabus.register');
        Route::get('/create', 'create')->name('syllabus.create');
        Route::post('/create', 'store')->name('syllabus.save');
        Route::get('/edit/{id}', 'edit')->name('syllabus.edit');
        Route::post('/edit/{id}', 'update')->name('syllabus.update');
        Route::get('/delete/{id}', 'destroy')->name('syllabus.delete');

        Route::post('/module/save', 'save')->name('syllabus.module.save');
        Route::get('/module/remove/{id}', 'syllabusModuleRemove')->name('syllabus.module.remove');
        Route::get('/module/restore/{id}', 'syllabusModuleRestore')->name('syllabus.module.restore');
    });

    Route::prefix('/module')->controller(ModuleController::class)->group(function () {
        Route::get('/', 'index')->name('module.register');
        Route::get('/create', 'create')->name('module.create');
        Route::post('/create', 'store')->name('module.save');
        Route::get('/edit/{id}', 'edit')->name('module.edit');
        Route::post('/edit/{id}', 'update')->name('module.update');
        Route::get('/delete/{id}', 'destroy')->name('module.delete');

        Route::get('/topic/remove/{id}', 'moduleTopicRemove')->name('module.topic.remove');
        Route::get('/topic/restore/{id}', 'moduleTopicRestore')->name('module.topic.restore');
    });

    Route::prefix('/topic')->controller(TopicController::class)->group(function () {
        Route::get('/', 'index')->name('topic.register');
        Route::get('/create', 'create')->name('topic.create');
        Route::post('/create', 'store')->name('topic.save');
        Route::get('/edit/{id}', 'edit')->name('topic.edit');
        Route::post('/edit/{id}', 'update')->name('topic.update');
        Route::get('/delete/{id}', 'destroy')->name('topic.delete');
    });

    Route::prefix('/notes')->controller(NotesController::class)->group(function () {
        Route::get('/', 'index')->name('notes.register');
        Route::get('/create', 'create')->name('notes.create');
        Route::post('/create', 'store')->name('notes.save');
        Route::get('/edit/{id}', 'edit')->name('notes.edit');
        Route::post('/edit/{id}', 'update')->name('notes.update');
        Route::get('/delete/{id}', 'destroy')->name('notes.delete');

        Route::get('/view/{id}', 'show')->name('notes.show');
    });

    Route::prefix('/batch')->controller(BatchController::class)->group(function () {
        Route::get('/', 'index')->name('batch.register');
        Route::get('/create', 'create')->name('batch.create');
        Route::post('/create', 'store')->name('batch.save');
        Route::get('/edit/{id}', 'edit')->name('batch.edit');
        Route::post('/edit/{id}', 'update')->name('batch.update');
        Route::get('/delete/{id}', 'destroy')->name('batch.delete');

        Route::post('/student/save', 'save')->name('batch.student.save');
        Route::get('/student/remove/{id}', 'batchStudentRemove')->name('batch.student.remove');
        Route::get('/student/restore/{id}', 'batchStudentRestore')->name('batch.student.restore');
    });

    Route::prefix('/fee')->controller(FeeController::class)->group(function () {
        Route::get('/', 'index')->name('fee.register');
        Route::get('/create/{category}/{student}', 'create')->name('fee.create');
        Route::post('/create', 'store')->name('fee.save');
        Route::get('/edit/{id}', 'edit')->name('fee.edit');
        Route::post('/edit/{id}', 'update')->name('fee.update');
        Route::get('/delete/{id}', 'destroy')->name('fee.delete');
    });

    Route::prefix('/faculty')->controller(FacultyController::class)->group(function () {
        Route::get('/', 'index')->name('faculty.register');
        Route::get('/create', 'create')->name('faculty.create');
        Route::post('/create', 'store')->name('faculty.save');
        Route::get('/edit/{id}', 'edit')->name('faculty.edit');
        Route::post('/edit/{id}', 'update')->name('faculty.update');
        Route::get('/delete/{id}', 'destroy')->name('faculty.delete');
    });

    Route::prefix('/head')->controller(HeadController::class)->group(function () {
        Route::get('/', 'index')->name('head.register');
        Route::get('/create', 'create')->name('head.create');
        Route::post('/create', 'store')->name('head.save');
        Route::get('/edit/{id}', 'edit')->name('head.edit');
        Route::post('/edit/{id}', 'update')->name('head.update');
        Route::get('/delete/{id}', 'destroy')->name('head.delete');
    });

    Route::prefix('/income')->controller(IncomeController::class)->group(function () {
        Route::get('/', 'index')->name('income.register');
        Route::get('/create', 'create')->name('income.create');
        Route::post('/create', 'store')->name('income.save');
        Route::get('/edit/{id}', 'edit')->name('income.edit');
        Route::post('/edit/{id}', 'update')->name('income.update');
        Route::get('/delete/{id}', 'destroy')->name('income.delete');
    });

    Route::prefix('/expense')->controller(ExpenseController::class)->group(function () {
        Route::get('/', 'index')->name('expense.register');
        Route::get('/create', 'create')->name('expense.create');
        Route::post('/create', 'store')->name('expense.save');
        Route::get('/edit/{id}', 'edit')->name('expense.edit');
        Route::post('/edit/{id}', 'update')->name('expense.update');
        Route::get('/delete/{id}', 'destroy')->name('expense.delete');
    });

    Route::prefix('/schedule/class')->controller(ClassScheduleController::class)->group(function () {
        Route::get('/', 'index')->name('class.schedule.register');
        Route::get('/create', 'create')->name('class.schedule.create');
        Route::post('/create', 'store')->name('class.schedule.save');
        Route::get('/edit/{id}', 'edit')->name('class.schedule.edit');
        Route::post('/edit/{id}', 'update')->name('class.schedule.update');
        Route::get('/delete/{id}', 'destroy')->name('class.schedule.delete');
    });

    Route::prefix('/video/recorded')->controller(VideoRecorded::class)->group(function () {
        Route::get('/', 'index')->name('video.recorded.register');
        Route::get('/create', 'create')->name('video.recorded.create');
        Route::post('/create', 'store')->name('video.recorded.save');
        Route::get('/edit/{id}', 'edit')->name('video.recorded.edit');
        Route::post('/edit/{id}', 'update')->name('video.recorded.update');
        Route::get('/delete/{id}', 'destroy')->name('video.recorded.delete');
    });

    Route::prefix('/student/feedback')->controller(StudentFeedbackController::class)->group(function () {
        Route::get('/', 'index')->name('student.feedback.register');
    });

    Route::prefix('/student')->controller(PdfController::class)->group(function () {
        Route::get('/fee/receipt', 'feeReceipt')->name('student.fee.receipt');
    });

    Route::prefix('/report')->controller(ReportController::class)->group(function () {
        Route::get('/daybook', 'daybook')->name('report.daybook');
        Route::post('/daybook', 'fetchDaybook')->name('report.daybook.fetch');
        Route::get('/student', 'student')->name('report.student');
        Route::post('/student', 'fetchStudent')->name('report.student.fetch');
        Route::get('/fee', 'fee')->name('report.fee');
        Route::post('/fee', 'fetchFee')->name('report.fee.fetch');
        Route::get('/ie', 'ie')->name('report.ie');
        Route::post('/ie', 'fetchIe')->name('report.ie.fetch');
    });
});

require __DIR__ . '/auth.php';

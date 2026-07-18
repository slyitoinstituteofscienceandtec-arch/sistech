<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\FinanceController;

Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/courses', [PublicController::class, 'courses'])->name('public.courses');
Route::get('/about', [PublicController::class, 'about'])->name('public.about');
Route::get('/academic', [PublicController::class, 'academic'])->name('public.academic');
Route::get('/enrollment', [PublicController::class, 'enrollment'])->name('public.enrollment');
Route::post('/enrollment', [PublicController::class, 'storeEnrollment'])->name('public.enrollment.store');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('public.gallery');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');
Route::post('/contact', [PublicController::class, 'submitContact'])->name('public.contact.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:super_admin,principal,registrar,accountant,staff,lecturer,student'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/', [LibraryController::class, 'index'])->name('index');
        Route::get('/create', [LibraryController::class, 'create'])->name('create');
        Route::post('/', [LibraryController::class, 'store'])->name('store');
        Route::get('/borrowings/list', [LibraryController::class, 'borrowings'])->name('borrowings');
        Route::post('/borrowings/{borrowing}/return', [LibraryController::class, 'returnBook'])->name('return');
        Route::get('/{book}/edit', [LibraryController::class, 'edit'])->name('edit');
        Route::put('/{book}', [LibraryController::class, 'update'])->name('update');
        Route::delete('/{book}', [LibraryController::class, 'destroy'])->name('destroy');
        Route::get('/{book}', [LibraryController::class, 'show'])->name('show');
    });
});

Route::middleware(['auth', 'role:super_admin,principal,registrar,accountant,staff,lecturer'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('programmes', ProgrammeController::class);
    Route::resource('courses', CourseController::class);

    Route::prefix('course-registrations')->name('course-registrations.')->group(function () {
        Route::get('/', [CourseRegistrationController::class, 'index'])->name('index');
        Route::post('/', [CourseRegistrationController::class, 'store'])->name('store');
        Route::delete('/{courseRegistration}', [CourseRegistrationController::class, 'destroy'])->name('destroy');
        Route::post('/bulk', [CourseRegistrationController::class, 'bulkStore'])->name('bulk');
        Route::get('/unregistered/{course}', [CourseRegistrationController::class, 'getUnregisteredStudents'])->name('unregistered');
    });

    Route::prefix('academic')->name('academic.')->group(function () {
        Route::get('/years', [AcademicController::class, 'academicYears'])->name('years');
        Route::post('/years', [AcademicController::class, 'storeAcademicYear'])->name('years.store');
        Route::put('/years/{academicYear}', [AcademicController::class, 'updateAcademicYear'])->name('years.update');
        Route::delete('/years/{academicYear}', [AcademicController::class, 'destroyAcademicYear'])->name('years.destroy');
        Route::post('/years/{academicYear}/set-current', [AcademicController::class, 'setCurrentYear'])->name('years.set-current');
        Route::get('/semesters', [AcademicController::class, 'semesters'])->name('semesters');
        Route::post('/semesters', [AcademicController::class, 'storeSemester'])->name('semesters.store');
        Route::put('/semesters/{semester}', [AcademicController::class, 'updateSemester'])->name('semesters.update');
        Route::delete('/semesters/{semester}', [AcademicController::class, 'destroySemester'])->name('semesters.destroy');
    });

    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/create', [AttendanceController::class, 'create'])->name('create');
        Route::post('/record', [AttendanceController::class, 'record'])->name('record');
        Route::get('/students/{courseId}', [AttendanceController::class, 'getStudents'])->name('students');
        Route::get('/student/{student}', [AttendanceController::class, 'studentAttendance'])->name('student');
    });

    Route::prefix('results')->name('results.')->group(function () {
        Route::get('/', [ResultController::class, 'index'])->name('index');
        Route::get('/enter', [ResultController::class, 'enterResults'])->name('enter');
        Route::get('/students/{courseId}', [ResultController::class, 'getStudents'])->name('students');
        Route::post('/store', [ResultController::class, 'storeResults'])->name('store');
        Route::post('/{result}/approve', [ResultController::class, 'approve'])->name('approve');
        Route::post('/publish', [ResultController::class, 'publish'])->name('publish');
        Route::get('/transcript/{student}', [ResultController::class, 'transcript'])->name('transcript');
    });

    Route::prefix('communication')->name('communication.')->group(function () {
        Route::get('/announcements', [CommunicationController::class, 'announcements'])->name('announcements');
        Route::get('/announcements/create', [CommunicationController::class, 'createAnnouncement'])->name('announcements.create');
        Route::post('/announcements', [CommunicationController::class, 'storeAnnouncement'])->name('announcements.store');
        Route::put('/announcements/{announcement}', [CommunicationController::class, 'updateAnnouncement'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [CommunicationController::class, 'destroyAnnouncement'])->name('announcements.destroy');
        Route::get('/notifications', [CommunicationController::class, 'notifications'])->name('notifications');
        Route::post('/notifications/{notification}/read', [CommunicationController::class, 'markRead'])->name('notifications.read');
        Route::post('/notifications/mark-all-read', [CommunicationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    });

    Route::prefix('inbox')->name('inbox.')->group(function () {
        Route::get('/', [InboxController::class, 'index'])->name('index');
        Route::get('/{enquiry}', [InboxController::class, 'show'])->name('show');
        Route::post('/{enquiry}/reply', [InboxController::class, 'reply'])->name('reply');
        Route::delete('/{enquiry}', [InboxController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [ApplicationController::class, 'index'])->name('index');
        Route::get('/{application}', [ApplicationController::class, 'show'])->name('show');
        Route::post('/{application}/approve', [ApplicationController::class, 'approve'])->name('approve');
        Route::post('/{application}/reject', [ApplicationController::class, 'reject'])->name('reject');
    });

    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/create', [GalleryController::class, 'create'])->name('create');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
        Route::get('/{galleryItem}/edit', [GalleryController::class, 'edit'])->name('edit');
        Route::put('/{galleryItem}', [GalleryController::class, 'update'])->name('update');
        Route::delete('/{galleryItem}', [GalleryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/income-statement', [FinanceController::class, 'incomeStatement'])->name('income-statement');
        Route::get('/fee-structure', [FinanceController::class, 'feeStructure'])->name('fee-structure');
        Route::post('/fee-structure', [FinanceController::class, 'storeFeeStructure'])->name('fee-structure.store');
        Route::put('/fee-structure/{feeStructure}', [FinanceController::class, 'updateFeeStructure'])->name('fee-structure.update');
        Route::delete('/fee-structure/{feeStructure}', [FinanceController::class, 'destroyFeeStructure'])->name('fee-structure.destroy');
        Route::post('/record-payment', [FinanceController::class, 'recordPayment'])->name('record-payment');
        Route::post('/store-expense', [FinanceController::class, 'storeExpense'])->name('store-expense');
        Route::get('/receipt/{payment}', [FinanceController::class, 'receipt'])->name('receipt');
        Route::get('/student-invoices/{student}', [FinanceController::class, 'getStudentInvoices'])->name('student-invoices');
        Route::delete('/invoice/{invoice}', [FinanceController::class, 'destroyInvoice'])->name('invoice.destroy');
    });

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::match(['post', 'put'], '/settings', [SettingsController::class, 'update'])->name('settings.update');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\StudentPortalController::class, 'profile'])->name('profile');
    Route::get('/courses', [\App\Http\Controllers\StudentPortalController::class, 'courses'])->name('courses');
    Route::get('/results', [\App\Http\Controllers\StudentPortalController::class, 'results'])->name('results');
    Route::get('/attendance', [\App\Http\Controllers\StudentPortalController::class, 'attendance'])->name('attendance');
    Route::get('/announcements', [\App\Http\Controllers\StudentPortalController::class, 'announcements'])->name('announcements');
    Route::get('/notifications', [\App\Http\Controllers\StudentPortalController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\StudentPortalController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\StudentPortalController::class, 'markAllRead'])->name('notifications.mark-all-read');
});

Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\LecturerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [\App\Http\Controllers\LecturerPortalController::class, 'courses'])->name('courses');
    Route::get('/attendance', [\App\Http\Controllers\LecturerPortalController::class, 'attendance'])->name('attendance');
    Route::get('/attendance/students/{courseId}', [\App\Http\Controllers\LecturerPortalController::class, 'attendanceStudents'])->name('attendance.students');
    Route::post('/attendance/record', [\App\Http\Controllers\LecturerPortalController::class, 'recordAttendance'])->name('attendance.record');
    Route::get('/results', [\App\Http\Controllers\LecturerPortalController::class, 'results'])->name('results');
    Route::get('/results/students/{courseId}', [\App\Http\Controllers\LecturerPortalController::class, 'resultsStudents'])->name('results.students');
    Route::post('/results/store', [\App\Http\Controllers\LecturerPortalController::class, 'storeResults'])->name('results.store');
    Route::get('/profile', [\App\Http\Controllers\LecturerPortalController::class, 'profile'])->name('profile');
    Route::get('/announcements', [\App\Http\Controllers\LecturerPortalController::class, 'announcements'])->name('announcements');
    Route::get('/notifications', [\App\Http\Controllers\LecturerPortalController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\LecturerPortalController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\LecturerPortalController::class, 'markAllRead'])->name('notifications.mark-all-read');
});



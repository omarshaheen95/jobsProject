<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\JobOfferController;
use App\Http\Controllers\Manager\UserController;
use App\Http\Controllers\Manager\SettingController;


Route::get('subDegreesByDegree/{id}', 'Front\MainController@subDegreesByDegree')->name('subDegreesByDegree');


Route::group(['namespace' => 'Manager'], function () {
    Route::get('/home', [SettingController::class, 'home'])->name('home');

    //Settings
    Route::get('settings', 'SettingController@viewSettings')->name('settings.show');
    Route::post('settings', 'SettingController@settings')->name('settings.update');
    Route::get('profile', 'ManagerController@view_profile')->name('profile.show');
    Route::post('profile', 'ManagerController@profile')->name('profile.update');
    Route::get('password', 'ManagerController@view_password')->name('password.show');
    Route::post('password', 'ManagerController@password')->name('password.update');



    //Route Resources
    Route::resources([
        'governorate' => 'GovernorateController',
        'degree' => 'DegreeController',
        'sub_degree' => 'SubDegreeController',
        'disability' => 'DisabilityController',
//        'ministry' => 'MinistryController',
        'university' => 'UniversityController',
        'appreciation' => 'AppreciationController',
        'country' => 'CountryController',
        'language' => 'LanguageController',
        'position' => 'PositionController',
        'external-link' => 'ExternalLinkController',
        'news' => 'NewsController',
        'user' => 'UserController',
        'manager' => 'ManagerController',
        'role' => 'RoleController',
        'job_offer' => 'JobOfferController',
        'qualification' => 'QualificationController',
        'question' => 'QuestionController',
        'grade' => 'Lottery\GradeController',
        'applicant' => 'Lottery\ApplicantController',
        'ministry' => 'Lottery\LotteryMinistryController',
        'department' => 'Lottery\LotteryDepartmentController',
    ]);


    Route::delete('delete_option/{id}', 'QuestionController@deleteOption')->name('question.delete_option');


    Route::get('job-offers-users/{id}', [JobOfferController::class, 'usersJobOffers'])->name('job_offer.users');
    Route::get('job-offers-users/{id}/status', [JobOfferController::class, 'userJobOfferStatus'])->name('job_offer.status');
    Route::get('job-offers-users/{id}/test', [JobOfferController::class, 'userJobOfferTest'])->name('job_offer.test');
    Route::post('job-offers-users/{id}/status', [JobOfferController::class, 'updateUserJobOfferStatus'])->name('job_offer.update_status');
    Route::delete('job-offers-users/{id}', [JobOfferController::class, 'deleteUserJobOffer'])->name('job_offer.deleteUsers');
    Route::get('user-excel-export', [UserController::class, 'exportUserExcel'])->name('exportUserExcel');
    Route::get('user-qualifications/{id}', [UserController::class, 'userQualifications'])->name('userQualifications');
    Route::get('user-skills/{id}', [UserController::class, 'userSkills'])->name('userSkills');
    Route::get('user-courses/{id}', [UserController::class, 'userCourses'])->name('userCourses');
    Route::get('user-experiences/{id}', [UserController::class, 'userExperiences'])->name('userExperiences');
    Route::get('user-languages/{id}', [UserController::class, 'userLanguages'])->name('userLanguages');
    Route::get('user-disabilities/{id}', [UserController::class, 'userDisabilities'])->name('userDisabilities');
    Route::get('user-job-offers/{id}', [UserController::class, 'userJobOffers'])->name('userJobOffers');
    Route::get('user-interviews/{id}', [UserController::class, 'userInterviews'])->name('userInterviews');

    Route::get('user-job-offer-excel-export/{id}', [JobOfferController::class, 'exportUserJobOfferExcel'])->name('exportUserJobOfferExcel');
    Route::get('job-offer-excel-export', [JobOfferController::class, 'exportJobOfferExcel'])->name('exportJobOfferExcel');


    //Page
    Route::get('page', 'PageController@index')->name('page.index');
    Route::get('page/{id}', 'PageController@edit')->name('page.edit');
    Route::patch('page/{id}', 'PageController@update')->name('page.update');
    //Contact Us
    Route::get('contact_us', 'ContactUsController@index')->name('contact_us.index');
    Route::get('contact_us/{id}/show', 'ContactUsController@show')->name('contact_us.show');
    Route::delete('contact_us/{id}', 'ContactUsController@destroy')->name('contact_us.destroy');

    Route::get('collegeByUniversity/{id}', 'SettingController@collegeByUniversity')->name('collegeByUniversity');
    Route::get('departmentByGrade/{id}', 'SettingController@departmentByGrade')->name('departmentByGrade');
    Route::get('generalDepartmentByGrade/{id}', 'SettingController@generalDepartmentByGrade')->name('generalDepartmentByGrade');
    Route::get('ministriesByDepartment', 'SettingController@ministriesByDepartment')->name('ministriesByDepartment');



    //governor
    Route::get('governor-grades', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'governorGrades'])->name('grade.governor');
    Route::get('governor-grades-approve', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'governorGradesApprove'])->name('grade.governor.approve');
    Route::get('governor-lottery', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradesGovernorLottery'])->name('grade.governor.lottery');

    //discrimination
    Route::get('discrimination-grades', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradesDiscrimination'])->name('grade.discrimination');
    Route::get('discrimination-lottery', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradesDiscriminationLottery'])->name('grade.discrimination.lottery');

    //top
    Route::get('top-grades', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradesTop'])->name('grade.top');
    Route::get('top-lottery', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradesTopLottery'])->name('grade.top.lottery');

    //general
    Route::get('general-grades', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradesGeneral'])->name('grade.general');
    Route::get('general-lottery', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradesGeneralLottery'])->name('grade.general.lottery');


    Route::post('grade-import', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradeImport'])->name('grade.import');
    Route::get('grade-export', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradeExport'])->name('grade.export');
    Route::get('grade-discrimination-export', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradeDiscriminationExport'])->name('grade.discrimination.export');
    Route::get('grade-top-export', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradeTopExport'])->name('grade.top.export');
    Route::get('grade-general-export', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradeGeneralExport'])->name('grade.general.export');
    Route::get('grade-governor-export', [\App\Http\Controllers\Manager\Lottery\GradeController::class, 'gradeGovernorExport'])->name('grade.governor.export');

    Route::post('applicant-import', [\App\Http\Controllers\Manager\Lottery\ApplicantController::class, 'applicantImport'])->name('applicant.import');
    Route::get('applicant-export', [\App\Http\Controllers\Manager\Lottery\ApplicantController::class, 'applicantExport'])->name('applicant.export');


    //Lottery
    Route::get('lottery', [\App\Http\Controllers\Manager\Lottery\LotteryController::class, 'index'])->name('lottery.index');
    Route::post('lottery/update-ministry-applicants', [\App\Http\Controllers\Manager\Lottery\LotteryController::class, 'updateMinistryApplicants'])->name('lottery.update-ministry-applicants');
    Route::post('lottery/update-discrimination-ministry', [\App\Http\Controllers\Manager\Lottery\LotteryController::class, 'updateDiscriminationMinistry'])->name('lottery.update-discrimination-ministry');
    Route::post('lottery/update-top-ministry', [\App\Http\Controllers\Manager\Lottery\LotteryController::class, 'updateTopMinistry'])->name('lottery.update-top-ministry');
    Route::post('lottery/update-governor', [\App\Http\Controllers\Manager\Lottery\LotteryController::class, 'updateGovernor'])->name('lottery.update-governor');
    Route::get('history-lottery', [\App\Http\Controllers\Manager\Lottery\LotteryController::class, 'lotteriesHistory'])->name('lottery.history');
    Route::delete('lottery-delete/{id}', [\App\Http\Controllers\Manager\Lottery\LotteryController::class, 'lotteryDelete'])->name('lottery.delete');
    Route::get('lottery-export', [\App\Http\Controllers\Manager\Lottery\LotteryController::class, 'lotteryExport'])->name('lottery.export');




});

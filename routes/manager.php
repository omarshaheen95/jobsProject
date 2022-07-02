<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\JobOfferController;
use App\Http\Controllers\Manager\UserController;

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('manager')->user();

    //dd($users);

    return view('manager.home');
})->name('home');

Route::get('subDegreesByDegree/{id}', 'Front\MainController@subDegreesByDegree')->name('subDegreesByDegree');


Route::group(['namespace' => 'Manager'], function () {
    Route::get('/home', function () {
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('manager')->user();

        //dd($users);

        return view('manager.home');
    })->name('home');
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
        'ministry' => 'MinistryController',
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
    ]);

    Route::get('job-offers-users/{id}', [JobOfferController::class, 'usersJobOffers'])->name('job_offer.users');
    Route::get('job-offers-users/{id}/status', [JobOfferController::class, 'userJobOfferStatus'])->name('job_offer.status');
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

});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('manager')->user();

    //dd($users);

    return view('manager.home');
})->name('home');

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
        'news' => 'NewsController',
        'user' => 'UserController',
        'manager' => 'ManagerController',
        'role' => 'RoleController',
        'job_offer' => 'JobOfferController',
        'qualification' => 'QualificationController',
    ]);

    //Page
    Route::get('page', 'PageController@index')->name('page.index');
    Route::get('page/{id}', 'PageController@edit')->name('page.edit');
    Route::patch('page/{id}', 'PageController@update')->name('page.update');
    //Contact Us
    Route::get('contact_us', 'ContactUsController@index')->name('contact_us.index');
    Route::get('contact_us/{id}/show', 'ContactUsController@show')->name('contact_us.show');
    Route::delete('contact_us/{id}', 'ContactUsController@destroy')->name('contact_us.destroy');

});

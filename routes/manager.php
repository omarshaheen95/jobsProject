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
    ]);

    Route::get('page', 'PageController@index')->name('page.index');

});

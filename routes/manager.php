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
        'manager' => 'ManagerController',
    ]);

    Route::get('page', 'PageController@index')->name('page.index');
    Route::get('page/{id}', 'PageController@edit')->name('page.edit');
    Route::patch('page/{id}', 'PageController@update')->name('page.update');

});

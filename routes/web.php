<?php

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


Route::get('/', 'Front\MainController@welcome')->name('welcome');
Route::get('news', 'Front\MainController@allNews')->name('news.all');
Route::get('news/{slug}', 'Front\MainController@showNews')->name('news.show');
Route::get('job_offers', 'Front\JobOfferController@allJobOffers')->name('job_offers.all');
Route::get('job_offers/{slug}', 'Front\JobOfferController@showJobOffer')->name('job_offers.show');
Route::get('page/{key}', 'Front\MainController@showPage')->name('page.show');
Route::get('contact_us', 'Front\MainController@contactUs')->name('contact_us.show');
Route::post('contact_us', 'Front\MainController@contactUsMessage')->name('contact_us.message');


Route::group(['prefix' => 'manager'], function () {
  Route::get('/login', 'ManagerAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'ManagerAuth\LoginController@login');
  Route::post('/logout', 'ManagerAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'ManagerAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'ManagerAuth\RegisterController@register');

  Route::post('/password/email', 'ManagerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'ManagerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'ManagerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'ManagerAuth\ResetPasswordController@showResetForm');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

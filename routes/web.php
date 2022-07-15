<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\JobOfferController;
use App\Http\Controllers\Front\ProfileController;

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

  Route::post('/password/email', 'ManagerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'ManagerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'ManagerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'ManagerAuth\ResetPasswordController@showResetForm');
});

Auth::routes();

Route::get('/home', 'Front\MainController@welcome')->name('home');
Route::group(['middleware' => 'auth', 'namespace' => 'Front'], function (){

    Route::get('subDegreesByDegree/{id}', 'MainController@subDegreesByDegree')->name('subDegreesByDegree');

    Route::get('profile-step/{step}', 'ProfileController@profile')->name('profile.step');
    Route::post('update-profile', 'ProfileController@updateProfile')->name('profile.update');
    //User Qualifications
    Route::post('user_qualification', 'ProfileController@userQualification')->name('user_qualification.store');
    Route::delete('user_qualification/{id}', 'ProfileController@userQualificationDelete')->name('user_qualification.delete');
    //User Experiences
    Route::post('user_experience', 'ProfileController@userExperience')->name('user_experience.store');
    Route::delete('user_experience/{id}', 'ProfileController@userExperienceDelete')->name('user_experience.delete');
    //User Skill
    Route::post('user_skill', 'ProfileController@userSkill')->name('user_skill.store');
    Route::delete('user_skill/{id}', 'ProfileController@userSkillDelete')->name('user_skill.delete');
    //User Course
    Route::post('user_course', 'ProfileController@userCourse')->name('user_course.store');
    Route::delete('user_course/{id}', 'ProfileController@userCourseDelete')->name('user_course.delete');
    //User Language
    Route::post('user_language', 'ProfileController@userLanguage')->name('user_language.store');
    Route::delete('user_language/{id}', 'ProfileController@userLanguageDelete')->name('user_language.delete');
    //User Disability
    Route::post('user_disability', 'ProfileController@userDisability')->name('user_disability.store');
    Route::delete('user_disability/{id}', 'ProfileController@userDisabilityDelete')->name('user_disability.delete');

    Route::post('apply-job-offer/{id}', [JobOfferController::class, 'applyJobOffer'])->name('applyJobOffer');
    Route::get('job_offers/questions/{slug}', [JobOfferController::class, 'questionsJobOffers'])->name('job_offers.questions');
    Route::get('job-offers-archive', [JobOfferController::class, 'archiveJobOffers'])->name('archiveJobOffers');
    Route::get('interviews', [JobOfferController::class, 'interviews'])->name('interviews');
    Route::get('password', [ProfileController::class, 'changePassword'])->name('changePassword');
    Route::post('password', [ProfileController::class, 'password'])->name('password');

});

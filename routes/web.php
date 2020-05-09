<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [
    'as'      => '/',
    'uses'    => 'publics\PageController@index'
]);
Route::redirect('/', '/login');
// Route::get('/', function () {
//     return view('public.landing');
// })->name('/');
// Route::get('/about', function () {
//     return view('public.about');
// })->name('about');

Auth::routes();
Route::redirect('/password/reset', '/login');
Route::redirect('/register', '/login');


Route::group(['middleware' => ['auth']], function() {

    // admin
    Route::redirect('/admin', '/admin/dashboard');
    Route::get('/admin/dashboard', 'admin\DashboardController@index')->name('dashboard');

    Route::resource('admin/preferences','admin\PreferenceController');

    Route::post('admin/preferences/post', 'admin\PreferenceController@ajaxRequestPost');

    Route::resource('admin/profiles','admin\ProfileController');


    // content
    Route::resource('admin/content/websites/pages','admin\content\website\PagesController');
        Route::get('admin/content/websites/pages/{id}/burn','admin\content\website\PagesController@burn')->name('pages.burn');
        Route::get('admin/content/websites/pages/{id}/restore','admin\content\website\PagesController@restore')->name('pages.restore');

    // credentials
    Route::resource('admin/config/credentials/roles','admin\config\credentials\RoleController');

    Route::resource('admin/config/credentials/users','admin\config\credentials\UserController');
        Route::get('admin/config/credentials/users/{id}/burn','admin\config\credentials\UserController@burn')->name('users.burn');
        Route::get('admin/config/credentials/users/{id}/restore','admin\config\credentials\UserController@restore')->name('users.restore');

    Route::resource('admin/config/credentials/permissions','admin\config\credentials\PermissionController');
        Route::get('admin/config/credentials/permissions/{id}/burn','admin\config\credentials\PermissionController@burn')->name('permissions.burn');
        Route::get('admin/config/credentials/permissions/{id}/restore','admin\config\credentials\PermissionController@restore')->name('permissions.restore');

    // applications
    Route::resource('admin/config/applications/paginations','admin\config\applications\PaginationsController');
        Route::get('admin/config/applications/paginations/{id}/burn','admin\config\applications\PaginationsController@burn')->name('paginations.burn');
        Route::get('admin/config/applications/paginations/{id}/restore','admin\config\applications\PaginationsController@restore')->name('paginations.restore');
});

// public dynamic
Route::get('{slug}', [
    'uses' => 'publics\PageController@getPage'
])->where('slug', '([A-Za-z0-9\-\/]+)');

<?php

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

Auth::routes();

Route::get('/sf', 'HomeController@sf')->name('sf');
Route::get('/logout', 'Auth\LoginController@logout');

Route::middleware(['breadcrumbs', 'auth'])->group(function(){

    // Route::view('/', 'index')->name('home');

    Route::get('/', 'HomeController@index')->name('home');
    
    Route::prefix('budget')->group(function(){
        // Route::view('/list-budget', 'pages.budget.list')->name('budget.list');
        Route::view('/archive', 'pages.budget.archive')->name('budget.archive');

        Route::get('list-budget', 'BudgetController@index')->name('budget.list');
    });

    Route::prefix('realization')->group(function(){
        Route::view('/', 'pages.realization.index')->name('realization.index');

        Route::prefix('form-realization')->group(function(){
            Route::view('/', 'pages.realization.create')->name('realization.create');

            Route::prefix('detail-realization')->group(function(){
                Route::view('/', 'pages.realization.detail-realization.index')->name('realization.detail-realization');
                Route::view('/add-realization', 'pages.realization.detail-realization.create')->name('realization.detail-realization.create');
                Route::view('/edit-realization', 'pages.realization.detail-realization.edit')->name('realization.detail-realization.edit');
            });
        });
    });
});
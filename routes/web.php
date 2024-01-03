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
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('budget')->group(function(){
        // Lists
        Route::get('/archive', 'BudgetController@archiveList')->name('budget.archive-list');
        Route::get('/list-budget', 'BudgetController@index')->name('budget.list');

        // Edit & Update
        Route::get('/edit-budget-archived/{voucher}/{archived}', 'BudgetController@edit')->name('budget-archived.edit');
        Route::get('/edit-budget/{voucher}/{archived}', 'BudgetController@edit')->name('budget.edit');
        Route::post('/edit-budget/{voucher}', 'BudgetController@update')->name('budget.update');

        // Propose
        Route::post('/propose-budget/{voucher}', 'BudgetController@propose')->name('budget.propose');

        // Approve
        Route::get('/approve-budget/{voucher}', 'BudgetController@approve')->name('budget.approve');

        // Reject
        Route::get('/reject/{voucher}', 'BudgetController@reject')->name('budget.reject');

        // Archive
        Route::get('/archive/{voucher}', 'BudgetController@archive')->name('budget.archive');

        // !Data Table Budget.
        Route::get('/data-table', 'BudgetController@BudgetDataTable')->name('budget.data-table');
    });

    Route::prefix('realization')->group(function(){
        Route::get('/', 'RealizationController@index')->name('realization.index');

        Route::prefix('form-realization')->group(function(){
            Route::get('/', 'RealizationController@create')->name('realization.create');
            Route::post('/', 'RealizationController@store')->name('realization.store');

            Route::get('/edit/{invoice_no}', 'RealizationController@edit')->name('realization.edit');
            Route::post('/edit/{invoice_no}', 'RealizationController@update')->name('realization.update');

            Route::get('/show/{invoice_no}', 'RealizationController@show')->name('realization.show');

            Route::get('/propose/{invoice_no}', 'RealizationController@propose')->name('realization.propose');
            Route::get('/approve/{invoice_no}', 'RealizationController@approve')->name('realization.approve');
            Route::get('/reject/{invoice_no}', 'RealizationController@reject')->name('realization.reject');

            Route::prefix('detail-realization')->group(function(){
                Route::get('/{invoice_no}', 'DetailRealizationController@index')->name('realization.detail-realization.index');

                Route::get('/create/{invoice_no}', 'DetailRealizationController@create')->name('realization.detail-realization.create');
                Route::post('/create', 'DetailRealizationController@store')->name('realization.detail-realization.store');

                Route::get('/{invoice_no}/show/{id}', 'DetailRealizationController@show')->name('realization.detail-realization.show');

                Route::get('/{invoice_no}/edit/{id}', 'DetailRealizationController@edit')->name('realization.detail-realization.edit');
                Route::post('/{invoice_no}/edit/{id}', 'DetailRealizationController@update')->name('realization.detail-realization.update');
                
                // Route::view('/edit', 'pages.realization.detail-realization.edit')->name('realization.detail-realization.edit');
            });
        });

        // !Data Table Realization.
        Route::get('/data-table', 'Realization@RealizationDataTable')->name('realization.data-table');
    });

    Route::prefix('setting')->middleware('head.access')->group(function(){
        Route::get('/user', 'SettingController@userIndex')->name('setting.user.index');
        Route::get('/user/create', 'SettingController@userCreate')->name('setting.user.create');
        Route::post('/user/store', 'SettingController@userStore')->name('setting.user.store');

        Route::get('/user/edit/{UserID}', 'SettingController@userEdit')->name('setting.user.edit');
        Route::post('user/edit/{UserID}', 'SettingController@userUpdate')->name('setting.user.update');
        
    });


    // Ajax Calls.
    Route::prefix('utils')->as('utils.')->group(function(){
        Route::get('/search_profile', 'UtilsController@SearchProfile')->name('search_profile');
        Route::get('/search_budget_by_policy_no_and_broker_name', 'UtilsController@SearchBudgetByPolicyNoAndBrokerName')->name('search_budget_by_policy_no_and_broker_name');
    });
});

// PDF
Route::get('/generate-attachment-epo/{PID}', 'GenerateAttachmentEpoController@index')->name('generate-pdf-attachment-epo');
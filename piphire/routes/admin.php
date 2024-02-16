<?php

Route::group(['namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'backend'], function () {
        Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {
        
            Route::post('/checkemailexist', 'AdminHomeController@checkemailexist');

            Route::get('/dashboard', 'AdminHomeController@index');
            //admin profile//
            Route::get('/admin/edit', 'AdminHomeController@adminedit');

            Route::post('/admin/edit', 'AdminHomeController@adminupdate');            
            //admin profile//

            // plan Type//
            Route::get('/plantype/list', 'AdminPlantypeController@index');

            Route::post('plantype/list', 'AdminPlantypeController@dataTable');

            Route::get('/plantype/create', 'AdminPlantypeController@create');

            Route::post('/plantype/create', 'AdminPlantypeController@store');

            Route::get('/plantype/{tuid}/edit', 'AdminPlantypeController@edit');

            Route::post('/plantype/{tuid}/edit', 'AdminPlantypeController@update');

            Route::post('/plantype/delete/{id}', 'AdminPlantypeController@destroy');

            Route::post('/plantype/activate/{id}', 'AdminPlantypeController@activate');
            // plan  TYpe//

            // plan //
            Route::get('/plan/list', 'AdminPlanController@index');

            Route::post('plan/list', 'AdminPlanController@dataTable');

            Route::get('/plan/create', 'AdminPlanController@create');

            Route::post('/plan/create', 'AdminPlanController@store');

            Route::get('/plan/{puid}/edit', 'AdminPlanController@edit');

            Route::post('/plan/{puid}/edit', 'AdminPlanController@update');

            Route::post('/plan/delete/{id}', 'AdminPlanController@destroy');

            Route::post('/plan/activate/{id}', 'AdminPlanController@activate');
            // plan //

            // organization //
            Route::get('/organization/list', 'AdminOrganizationController@index');

            Route::post('/organization/list', 'AdminOrganizationController@dataTable');

            Route::get('/organization/create', 'AdminOrganizationController@create');

            Route::post('/organization/create', 'AdminOrganizationController@store');

            Route::get('/organization/{ouid}/edit', 'AdminOrganizationController@edit');

            Route::post('/organization/{ouid}/edit', 'AdminOrganizationController@update');

            Route::post('/organization/delete/{id}', 'AdminOrganizationController@destroy');

            Route::post('/organization/activate/{id}', 'AdminOrganizationController@activate');

            Route::get('/organization-log/{ouid}', 'AdminOrganizationController@gethistory');        
            // organization //

            // organization users //
            Route::get('/organization/users/{ouid}', 'AdminUserController@index');

            Route::post('/organization/users/{ouid}', 'AdminUserController@dataTable');

            Route::get('/organization/users/{ouid}/create', 'AdminUserController@create');

            Route::post('/organization/users/{ouid}/create', 'AdminUserController@store');

            Route::get('/organization/users/{uuid}/edit', 'AdminUserController@edit');

            Route::post('/organization/users/{uuid}/edit', 'AdminUserController@update');

            Route::post('/organization/users/delete/{id}', 'AdminUserController@destroy');

            Route::post('/organization/users/activate/{id}', 'AdminUserController@activate');        
            // organization users//


            // organization jobs //
            Route::get('/organization/jobs/{uuid}', 'AdminJobController@index');

            Route::post('/organization/jobs/{uuid}', 'AdminJobController@dataTable');

            Route::get('/organization/jobs/{uuid}/create', 'AdminJobController@create');

            Route::post('/organization/jobs/{uuid}/create', 'AdminJobController@store');

            Route::get('/organization/jobs/{juid}/edit', 'AdminJobController@edit');

            Route::post('/organization/jobs/{juid}/edit', 'AdminJobController@update');

            Route::post('/organization/jobs/delete/{id}', 'AdminJobController@destroy');

            Route::post('/organization/jobs/activate/{id}', 'AdminJobController@activate');        
            // organization jobs//

            //User activation//

            Route::post('/senduseractivation/{uuid}', 'AdminUserController@senduseractivation');

            //User activation//

        });
    });
});
<?php

Route::group(['prefix' => 'admin', 'middleware' => ['web','admin'], 'as' => 'admin.'],function(){
    Route::group(['prefix' => 'company'], function () {
    Route::get('/','CompanyController@index');
    Route::post('create', 'CompanyController@create');
    Route::post('user/create', 'CompanyController@createUserCompany');
    Route::get('list', 'CompanyController@list');
    Route::get('view/{id}', 'CompanyController@view');
    Route::post('update/{id}', 'CompanyController@update');
    Route::post('user/update/{id}', 'CompanyController@updateUserCompany');
    Route::get('delete/{id}', 'CompanyController@delete');			
  });
});

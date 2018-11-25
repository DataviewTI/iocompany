<?php

Route::group(['prefix' => 'admin', 'middleware' => ['web','admin'], 'as' => 'admin.'],function(){
  Route::group(['prefix' => 'company'], function () {
    Route::get('/','CompanyController@index');
    Route::post('create', 'CompanyController@create');
    Route::get('simplified-list', 'CompanyController@simplifiedList');
    Route::get('list', 'CompanyController@list');
    Route::get('view/{id}', 'CompanyController@view');
    Route::post('update/{id}', 'CompanyController@update');
    Route::get('delete/{id}', 'CompanyController@delete');			
  });

  Route::group(['prefix' => 'candidate'], function () {
    Route::get('/','CandidateController@index');
    Route::post('create', 'CandidateController@create');
    Route::get('list', 'CandidateController@list');
    Route::get('cbo/list/{kw?}', 'CandidateController@cboList');
    Route::get('view/{id}', 'CandidateController@view');
    Route::post('update/{id}', 'CandidateController@update');
    Route::get('delete/{id}', 'CandidateController@delete');			
  });  

  Route::group(['prefix' => 'job'], function () {
    Route::get('/','JobController@index');
    Route::post('create', 'JobController@create');
    Route::get('list', 'JobController@list');
    Route::get('cbo/list/{kw?}', 'JobController@cboList');
    Route::get('view/{id}', 'JobController@view');
    Route::post('update/{id}', 'JobController@update');
    Route::get('delete/{id}', 'JobController@delete');			
  });  
});

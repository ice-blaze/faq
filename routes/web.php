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

Route::get('/', 'FaqController@index');
Route::post('/faqs/create', 'FaqController@store');
Route::get('/qas/{faq_id}/', 'FaqController@qas');
Route::get('/{id}/{admin_code}', 'FaqController@show');
Route::get('/{id}/', 'FaqController@show');
Route::post('/{id}/{admin_code}', 'FaqController@update');
Route::post('/{id}/{admin_code}/qas/create', 'QaController@store');
Route::post('/{id}/{admin_code}/qas/reorder', 'QaController@reorder');
Route::post('/{id}/{admin_code}/qas/{qa_id}/up', 'QaController@up');
Route::post('/{id}/{admin_code}/qas/{qa_id}/down', 'QaController@down');
Route::post('/{id}/{admin_code}/qas/{qa_id}/update', 'QaController@update');
Route::get('/{id}/{admin_code}/qas/{qa_id}', 'QaController@getJson');

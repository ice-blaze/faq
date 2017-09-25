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
Route::post('/faq/create', 'FaqController@store');
Route::get('/faq/{faq_id}/qas', 'FaqController@qas');
Route::get('/faq/{faq_id}/', 'FaqController@show');
Route::post('/faq/{faq_id}', 'FaqController@update');
Route::post('/faq/{faq_id}/qa_create', 'QaController@store');
Route::post('/faq/{faq_id}/qas_reorder', 'QaController@reorder');
Route::post('/qa/{qa_id}/up', 'QaController@up');
Route::post('/qa/{qa_id}/down', 'QaController@down');
Route::post('/qa/{qa_id}/update', 'QaController@update');
Route::post('/qa/{qa_id}/delete', 'QaController@delete');
Route::get('/qa/{qa_id}', 'QaController@getJson');

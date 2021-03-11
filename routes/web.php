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

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/', 'QAController@index')->name('index');


Route::get('/query/{id}', 'QAController@query')->name('query');

Route::get('/ask_query', 'QAController@ask_query')->name('ask query');
Route::get('/get_more_records', 'QAController@get_more_records')->name('get_more_records');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/need_to_login', 'QAController@need_to_login')->name('need_to_login');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::post('/add_new_query', 'QAController@add_new_query')->name('add_new_query');

Route::get('/add_comment', 'QAController@add_comment')->name('add_comment');
Route::get('/search_home', 'QAController@search_home')->name('search_home');

Route::get('/search_index', 'QAController@search_index')->name('search_index');

Route::get('/get_tags', 'QAController@get_tags')->name('get_tags');
Route::get('/get_triggers_ans', 'QAController@get_triggers_ans')->name('get_triggers_ans');

Route::get('/search_with_tag', 'QAController@search_with_tag')->name('search_with_tag');

Route::get('/check_last_vote', 'QAController@check_last_vote')->name('check_last_vote');


Route::get('/get_related_quries_for_ask_query_title', 'QAController@get_related_quries_for_ask_query_title')->name('get_related_quries_for_ask_query_title');


Route::get('/get_custom_topics_qus', 'QAController@get_custom_topics_qus')->name('get_custom_topics_qus');


Route::get('/modal_comment_post_edit_main', 'QAController@modal_comment_post_edit_main')->name('modal_comment_post_edit_main');


Route::get('/edit_replies', 'QAController@edit_replies')->name('edit_replies');

Route::get('/create_docs_excel', 'QAController@create_docs_excel')->name('create_docs_excel');

Route::get('/search_arena', 'QAController@search_arena')->name('search_arena');

Route::get('/check_similar_post', 'QAController@check_similar_post');


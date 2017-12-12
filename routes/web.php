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

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::get('/register/client' , 'RegisterUserTypeController@registerAsClient');
Route::get('/register/chairman' , 'RegisterUserTypeController@registerAsChairman');
Route::get('/register/incharge' , 'RegisterUserTypeController@registerAsIncharge');
Route::get('/register/serviceProvider' , 'RegisterUserTypeController@registerAsServiceProvider');

Route::get('/profile/{username}', 'ClientController@profile')->name('profile');

Route::get('/client/requestForm', 'ClientController@requestForm')->name('C_requestForm');
Route::post('/client/sendRequest' , 'ClientController@processRequest');
Route::get('/client/allRequests', 'ClientController@allRequests')->name('C_allRequests');
Route::post('/client/deleteRequest', 'ClientController@deleteRequest')->name('C_delete');
Route::get('/client/request/{requestID}', 'ClientController@showRequest')->name('C_request');
Route::get('/client/accomplishedRequests', 'ClientController@showAccomplishedRequests')->name('C_accomplishedRequests');
Route::post('/client/confirm', 'ClientController@confirm');


Route::get('/incharge/assignTo/{requestID}', 'InchargeController@assignTo')->name('I_assignTo');
Route::get('/incharge/assignRequests', 'InchargeController@assignRequests')->name('I_assignRequest');
Route::get('/incharge/request/{requestID}', 'InchargeController@showRequest')->name('I_request');
Route::get('/incharge/services', 'InchargeController@showServices')->name('I_services');
Route::get('/incharge/allRequests', 'InchargeController@allRequests')->name('I_allRequest');
Route::post('/incharge/addService', 'InchargeController@addService');
Route::post('/incharge/removeService', 'InchargeController@removeService');
Route::post('/incharge/recommend', 'InchargeController@recommend');
Route::post('/incharge/unrecommend', 'InchargeController@unrecommend');
Route::post('/incharge/assign', 'InchargeController@assign');
Route::get('/incharge/serviceProviders', 'InchargeController@serviceProviders')->name('I_serviceProviders');
Route::get('/incharge/ServiceProviderForm', 'RegisterUserTypeController@registerAsServiceProvider')->name('I_ServiceProviderForm');
Route::post('/incharge/addServiceProvider', 'InchargeController@addServiceProvider')->name('addServiceProvider');
Route::get('/incharge/reports', 'InchargeController@reports')->name('I_reports');
Route::get('/incharge/SPReport/{serviceProviderID}', 'ChairmanController@SPReport')->name('I_SPReport');


Route::post('/serviceProvider/accomplish', 'ServiceProviderController@accomplish');
Route::post('/serviceProvider/addUnavailability', 'ServiceProviderController@addUnavailability');
Route::get('/serviceProvider/request/{requestID}', 'ServiceProviderController@showRequest')->name('S_request');
Route::get('/serviceProvider/allRequests', 'ServiceProviderController@allRequests')->name('S_allRequests');
Route::get('/serviceProvider/unavailability', 'ServiceProviderController@unavailability')->name('S_unavailability');

Route::get('/chairman/serviceProviders', 'ChairmanController@serviceProviders')->name('CH_serviceProviders');
Route::get('/chairman/allRequests', 'ChairmanController@allRequests')->name('CH_allRequests');
Route::get('/chairman/request/{requestID}', 'ChairmanController@showRequest')->name('CH_request');
Route::post('/chairman/approve', 'ChairmanController@approve');
Route::post('/chairman/disapprove', 'ChairmanController@disapprove');
Route::get('/chairman/SPReport/{serviceProviderID}', 'ChairmanController@SPReport')->name('CH_SPReport');
Route::get('/chairman/reports', 'ChairmanController@reports')->name('CH_reports');


Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/')

// Route::get('/register/user', 'HomeControlle')

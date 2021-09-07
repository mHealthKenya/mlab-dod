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
    return view('sessions/signIn');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', ['uses' => 'DashboardController@index', 'as' => 'home']);
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/get_units', ['uses'=>'HomeController@get_units', 'as'=>'get_units']);
    Route::post('/get_subcounties', ['uses'=>'HomeController@get_subcounties', 'as'=>'get_subcounties']);
    Route::post('/get_facilities', ['uses'=>'HomeController@get_facilities', 'as'=>'get_facilities']);
    Route::post('/get_facilities_mlab', ['uses'=>'HomeController@get_facilities_mlab', 'as'=>'get_facilities_mlab']);
    Route::post('/get_service_facilities_mlab', ['uses'=>'HomeController@get_service_facilities_mlab', 'as'=>'get_service_facilities_mlab']);
    Route::post('/get_facilities_data', ['uses'=>'HomeController@get_facilities_data', 'as'=>'get_facilities_data']);
    Route::post('/get_counties', ['uses'=>'HomeController@get_counties', 'as'=>'get_counties']);

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/add/user/form', 'UserController@adduserform')->name('adduserform');
    Route::post('/add/user', 'UserController@adduser')->name('adduser');
    Route::post('/edit/user', 'UserController@edituser')->name('edituser');
    Route::post('/reset/user', 'UserController@resetuser')->name('resetuser');
    Route::post('/delete/user', 'UserController@deleteuser')->name('deleteuser');
    Route::post('/change/password', 'UserController@changepass')->name('changepass');

    Route::get('/get/ushauri/clients', 'UshauriController@index')->name('clients');
    Route::post('/list/ushauri/clients', 'UshauriController@getClients')->name('fetchclients');
    Route::post('/list/ushauri/client', 'UshauriController@getOneClient')->name('fetchOneClient');
    Route::post('/list/more/ushauri/clients', 'UshauriController@getMoreClients')->name('fetchmoreclients');
    Route::post('/get/client/results', 'UshauriController@getClientResults')->name('getResults');


    Route::get('/services', 'serviceController@index')->name('services');
    Route::get('/add/service/form', 'serviceController@addserviceform')->name('addserviceform');
    Route::post('/add/service', 'serviceController@addservice')->name('addservice');
    Route::post('/edit/service', 'serviceController@editservice')->name('editservice');
    Route::post('/delete/service', 'serviceController@deleteservice')->name('deleteservice');

    Route::get('/units', 'UnitController@index')->name('units');
    Route::get('/add/unit/form', 'UnitController@addunitform')->name('addunitform');
    Route::post('/add/unit', 'UnitController@addunit')->name('addunit');
    Route::post('/edit/unit', 'UnitController@editunit')->name('editunit');
    Route::post('/delete/unit', 'UnitController@deleteunit')->name('deleteunit');

    Route::get('/facilities', 'FacilityController@index')->name('facilities');
    Route::get('/add/facility/form', 'FacilityController@addfacilityform')->name('addfacilityform');
    Route::post('/add/facility', 'FacilityController@addfacility')->name('addfacility');
    Route::post('/remove/facility', 'FacilityController@removefacility')->name('removefacility');
    
    Route::post('/edit/facility', 'FacilityController@edit_facility')->name('edit_facility');


    Route::get('/il/facilities', 'ILFacilityController@index')->name('il_facilities');
    Route::get('/add/il/facility/form', 'ILFacilityController@addilfacilityform')->name('addilfacilityform');
    Route::post('/add/il/facility', 'ILFacilityController@addilfacility')->name('addilfacility');
    Route::post('/edit/il/facility', 'ILFacilityController@edit_ilfacility')->name('edit_ilfacility');
    Route::post('/delete/il/facility', 'ILFacilityController@delete_ilfacility')->name('delete_ilfacility');



    Route::get('/all/results', 'DataController@all_results')->name('all_results');
    Route::get('/vl/results', 'DataController@vl_results')->name('vl_results');
    Route::get('/eid/results', 'DataController@eid_results')->name('eid_results');
    Route::get('/hts/allresults', 'DataController@serviceform')->name('hts_all_results');
    Route::get('/hts/results', 'DataController@hts_results')->name('hts_results');
    Route::get('/raw/data', 'DataController@rawdataform')->name('raw_data_form');
    Route::get('/get/raw/data', 'DataController@fetchraw')->name('fetchraw');
    Route::get('/raw/vl/srl/data', 'DataController@vl_srl_form')->name('vl_srl_raw_data');
    Route::get('/remote-login/vl/results', 'DataController@vl_srl_results')->name('vl_srl_results');
    Route::get('/raw/eid/srl/data', 'DataController@eid_srl_form')->name('eid_srl_raw_data');
    Route::get('/remote-login/eid/results', 'DataController@eid_srl_results')->name('eid_srl_results');
    Route::get('/raw/hts/srl/data', 'DataController@hts_srl_form')->name('hts_srl_raw_data');
    Route::get('/remote-login/hts/results', 'DataController@hts_srl_results')->name('hts_srl_results');




    //Dashboard Routes
    Route::get('/printers_dashboard', ['uses' => 'DashboardController@printers_dashboard', 'as' => 'printers_dashboard']);
    Route::get('/dashboard', ['uses' => 'DashboardController@index', 'as' => 'dashboard']);
    Route::get('/get_data', ['uses' => 'DashboardController@get_data', 'as' => 'get_data']);
    Route::get('/get_printers_data', ['uses' => 'DashboardController@get_printers_data', 'as' => 'get_printers_data']);
    Route::post('/get_dashboard_counties', ['uses' => 'DashboardController@get_dashboard_counties', 'as' => 'get_dashboard_counties']);
    Route::post('/get_dashboard_units', ['uses' => 'DashboardController@get_dashboard_units', 'as' => 'get_dashboard_units']);
    Route::post('/get_dashboard_sub_counties', ['uses' => 'DashboardController@get_dashboard_sub_counties', 'as' => 'get_dashboard_sub_counties']);
    Route::post('/get_dashboard_facilities', ['uses' => 'DashboardController@get_dashboard_facilities', 'as' => 'get_dashboard_facilities']);
    Route::post('/filter/dashboard', ['uses' => 'DashboardController@get_filtered_data', 'as' => 'filterDashboard']);
    Route::post('/filter/printers/dashboard', ['uses' => 'DashboardController@get_filtered_printers_data', 'as' => 'filterPrintersDashboard']);
});

Route::get('/send/results', ['uses' => 'SendResultsController@sendVLEID', 'as' => 'sendvleid']);
Route::get('/send/il/results', ['uses' => 'SendResultsController@sendIL', 'as' => 'sendil']);
Route::get('/send/hts/results', ['uses' => 'SendResultsController@sendHTS', 'as' => 'sendhts']);
Route::get('/send/tb/results', ['uses' => 'SendResultsController@sendTB', 'as' => 'sendtb']);
Route::get('/get/results', ['uses' => 'VLResultsController@getResults', 'as' => 'getResults']);
Route::get('/process/inbox/{id}', ['uses' => 'TasksController@read', 'as' => 'read']);
Route::get('/classify/{id}', ['uses' => 'TasksController@classify', 'as' => 'classify']);
Route::get('/classifyone', ['uses' => 'TasksController@classifyOne', 'as' => 'classifyOne']);
Route::get('/get/eid/results', ['uses' => 'VLResultsController@getEIDResults', 'as' => 'getEIDResults']);
Route::get('/notify', 'SendResultsController@notify')->name('notify');
Route::get('/send/vls/to/lab', 'RemoteLoginController@SendVLsLab')->name('SendVLsLab');
Route::get('/send/eid/to/lab', 'RemoteLoginController@SendEIDLab')->name('SendEIDLab');
Route::get('/send/hts/to/lab', 'RemoteLoginController@SendHTSLab')->name('SendHTSLab');
Route::get('/client/notify', 'UshauriController@notifyClients')->name('notifyClients');
Route::get('/terms', 'TermsController@index')->name('terms');


// Auth::routes();

// Route::get('/home', 'DashboardController@index')->name('home');

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::post('/telegram/webhook', 'WebhookController@index');
Route::get('/home', 'HomeController@index');
Route::group(['middleware' => ['auth']], function (){
    Route::get('/', ['as' => 'home', 'uses' => 'TicketController@index']);

    Route::get('get-tickets/{status}', 'TicketController@getTickets')->name('tickets.getTickets');
    Route::patch('tickets/{id}/confirm', 'TicketController@confirm')->name('tickets.confirm')->middleware(['specialist']);
    Route::patch('tickets/{id}/check-complete', 'TicketController@checkComplete')->name('tickets.checkComplete')->middleware(['specialist']);
    Route::patch('tickets/{id}/approve/{approve?}', 'TicketController@approve')->name('tickets.approve');
    Route::patch('tickets/{ticket}/resend', 'TicketController@resend')->name('tickets.resend');

    Route::group(['middleware' => ['header']], function (){
        Route::get('/algolia/reindex', 'TicketController@reindex');

        Route::patch('tickets/{ticket}/change-date', 'TicketController@changeDate')->name('tickets.changeDate');
        Route::patch('tickets/{ticket}/change-employee', 'TicketController@changeEmployee')->name('tickets.changeEmployee');

	    Route::get('/report', 'ReportController@index');
	    Route::post('/get-report', 'ReportController@get')->name('report.get');
    });

    Route::resource('tickets', 'TicketController', ['except' => ['index', 'edit', 'update']]);
    Route::resource('ticket-rows', 'TicketRowController', ['except' => ['index', 'show', 'create']]);

    Route::group(['middleware' => ['specialist']], function (){
        Route::get('users', 'UserController@index')->name('users.index');
        Route::get('users/specialists', 'UserController@getSpecialists')->name('users.specialists')->middleware('header');
        Route::get('users/{id}', 'UserController@show')->name('users.show');
        Route::get('users/{id}/edit', 'UserController@edit')->name('users.edit');
        Route::patch('users/{id}', 'UserController@update')->name('users.update');
        Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');
        Route::get('users/{id}/add-equipment', 'UserController@addEquipment')->name('users.addEquipment');
        Route::post('users/{id}/store-equipment', 'UserController@storeEquipment')->name('users.storeEquipment');
        Route::patch('users/{id}/unpin-equipment/{equipmentId}', 'UserController@unPinEquipment')->name('users.unPinEquipment');
        Route::delete('users/{id}/delete-equipment/{equipmentId}', 'UserController@deleteEquipment')->name('users.deleteEquipment');

        Route::group(['prefix' => 'equipment-types'], function (){
            Route::get('/', 'EquipmentTypeController@index')->name('equipment-types');
            Route::post('/', 'EquipmentTypeController@store')->name('equipment-types.store');
            Route::get('{equipment_types}', 'EquipmentTypeController@show')->name('equipment-types.show');
            Route::get('get-items/{equipment_types}/{deep}', 'EquipmentTypeController@getItems')->name('equipment-types.getItems');
            Route::get('{equipment_types}/edit', 'EquipmentTypeController@edit')->name('equipment-types.edit');
            Route::patch('{equipment_types}', 'EquipmentTypeController@update')->name('equipment-types.update');
            Route::delete('{equipment_types}', 'EquipmentTypeController@destroy')->name('equipment-types.destroy');
        });

        Route::get('equipments/create-for/{id}', 'EquipmentController@createFor')->name('equipments.createFor');
        Route::resource('equipments', 'EquipmentController', [
            'except' => ['index']
        ]);

        Route::get('places/{id}/add-equipments', 'PlaceController@addEquipments')->name('places.addEquipments');
        Route::post('places/{id}/store/equipments', 'PlaceController@storeEquipments')->name('places.storeEquipments');
        Route::patch('places/{id}/unpin-equipment/{equipmentId}', 'PlaceController@unPinEquipment')->name('places.unPinEquipment');
        Route::delete('places/{id}/delete-equipment/{equipmentId}', 'PlaceController@deleteEquipment')->name('places.deleteEquipment');
        Route::get('places/{id}/add-users', 'PlaceController@addUsers')->name('places.addUsers');
        Route::post('places/{id}/store-users', 'PlaceController@storeUsers')->name('places.storeUsers');
        Route::patch('places/{id}/unpin-user/{userId}', 'PlaceController@unPinUser')->name('places.unPinUser');
        Route::delete('places/{id}/delete-user/{userId}', 'PlaceController@deleteUsers')->name('places.deleteUser');
        Route::resource('places', 'PlaceController');

        Route::resource('work-types', 'WorkTypeController', ['except' => ['show']]);

        Route::resource('groups', 'SpecialistGroupController', ['except' => ['show']]);

        Route::get('import/equipments', 'ImportController@equipments')->name('import.equipments');
        Route::post('import/equipments', 'ImportController@storeEquipments')->name('import.storeEquipments');

        Route::resource('organizations', 'OrganizationController');
        Route::resource('buildings', 'BuildingController');
        Route::resource('cabinets', 'CabinetController');
    });
});


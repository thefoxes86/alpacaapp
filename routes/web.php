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

// GET_ROUTES


Auth::routes();



Route::get('/', function () {
    return redirect('/login');
});









Route::group(['middleware' => ['auth']], function () {
   	Route::get('/grimmadmin/alpaca/nuovo', 'AlpacaController@getGeneralData');
   	Route::get('/grimmadmin/alpaca', 'AlpacaController@index');
	Route::get('/grimmadmin/alpaca/get', 'AlpacaController@get');
	Route::get('/grimmadmin/alpaca/nuovo/findAlpaca/{ricerca}', 'AlpacaController@getAlpacaFromName');
	Route::get('/grimmadmin/alpaca/modifica/{id}', 'AlpacaController@modifica');
	Route::get('/grimmadmin/alpaca/count', 'AlpacaController@count');

	Route::get('/grimmadmin/allevamenti', 'AllevamentoController@index');
	Route::get('/grimmadmin/allevamenti/get', 'AllevamentoController@get');
	Route::get('/grimmadmin/allevamento/modifica/{id}', 'AllevamentoController@modifica');
	Route::get('/grimmadmin/allevamento/count', 'AllevamentoController@count');

	Route::get('/grimmadmin/user/get', 'Auth\RegisterController@get');
	Route::get('/grimmadmin/user/getAllevamenti/{$id}', 'Auth\RegisterController@getAllevamenti');
	Route::get('/grimmadmin/user', 'Auth\RegisterController@index');
	Route::get('/grimmadmin/users/getNumber/{numero}', 'Auth\RegisterController@getNumber');


	Route::get('/grimmadmin/allevamento/nuovo', 'AllevamentoController@getGeneralData');
	Route::get('/grimmadmin/alpaca/nuovo/findAllevamento/{ricerca}', 'AllevamentoController@getAllevamentoFromName');

	Route::get('/grimmadmin/colori', 'ColoriController@index');
	Route::get('/grimmadmin/tipologie', 'TipologiaController@index');

	Route::get('/grimmadmin/user/nuovo', function() {
		return view('grimmadmin/page/nuovo-user');
	});
	Route::get('/grimmadmin/user/count', 'Auth\RegisterController@count');

	Route::get('/grimmadmin/articolo/nuovo', function() {
		return view('grimmadmin/page/nuovo-articolo');
	});
	Route::get('/grimmadmin/articoli', 'PostController@index');
	Route::get('/grimmadmin/articoli/get', 'PostController@get');
	Route::get('/grimmadmin/articoli/modifica/{id}', 'PostController@modifica');

	Route::get('/grimmadmin/evento/nuovo', function() {
		return view('grimmadmin/page/nuovo-evento');
	});

	Route::get('/grimmadmin/opzione/nuova', function() {
		return view('grimmadmin/page/nuova-opzione');
	});
	Route::get('/grimmadmin', function() {
		return view('grimmadmin/page/index');
	});

	Route::get('/grimmadmin/categorie/get', 'CategoriaController@get');

	Route::get('/grimmadmin/eventi/get', 'EventoController@get');
	Route::get('/grimmadmin/eventi/getNumber/{numero}', 'EventoController@getNumber');
	Route::get('/grimmadmin/eventi', 'EventoController@index');
	Route::get('/grimmadmin/eventi/modifica/{id}', 'EventoController@modifica');
	Route::get('/grimmadmin/notifiche/getAdminNotifications', 'NotificationController@getAdminNotifications');

	Route::get('/grimmadmin/logout', 'Auth\LoginController@logout');
	Route::get('/grimmadmin/user/modifica/{id}', 'Auth\RegisterController@update');
	//POST_ROUTES

	Route::post('/grimmadmin/alpaca/nuovo', 'AlpacaController@store');
	Route::post('/grimmadmin/uploadAlpacaFoto', 'AlpacaController@uploadAlpacaFoto');
	Route::post('/grimmadmin/alpaca/cancella', 'AlpacaController@cancella');
	Route::post('/grimmadmin/alpaca/update/{id}', 'AlpacaController@update');
	Route::post('/grimmadmin/uploadAlpacaFoto/cancella', 'AlpacaController@resettaFoto');
	Route::post('/grimmadmin/uplaodAlpacaGalleria', 'AlpacaController@uploadMultipleFoto');
	Route::post('/grimmadmin/cancellaAlpacaGalleria', 'AlpacaController@eraseFromMultipleFoto');
	Route::post('/grimmadmin/user/cancella', 'Auth\RegisterController@cancella');


	Route::post('/grimmadmin/allevamento/nuovo', 'AllevamentoController@store');
	Route::post('/grimmadmin/uploadAllevamentoFoto', 'AllevamentoController@uploadAllevamentoFoto');
	Route::post('/grimmadmin/allevamento/cancella', 'AllevamentoController@cancella');
	Route::post('/grimmadmin/allevamento/update/{id}', 'AllevamentoController@update');
	Route::post('/grimmadmin/uploadAllevamentoFoto/cancella', 'AllevamentoController@resettaFoto');
	Route::post('/grimmadmin/uplaodAllevamntoGalleria', 'AllevamentoController@uploadMultipleFoto');
	Route::post('/grimmadmin/cancellaAllevamntoGalleria', 'AllevamentoController@eraseFromMultipleFoto');

	Route::post('/grimmadmin/aggiungiColore', 'ColoriController@store');
	Route::post('/grimmadmin/cancellaColore', 'ColoriController@destroy');
	Route::post('/grimmadmin/modificaColore', 'ColoriController@update');
	Route::post('/grimmadmin/aggiungiTipo', 'TipologiaController@store');
	Route::post('/grimmadmin/cancellaTipo', 'TipologiaController@destroy');
	Route::post('/grimmadmin/modificaTipo', 'TipologiaController@update');


	Route::post('/grimmadmin/newUser', 'Auth\RegisterController@createNew');
	Route::post('/grimmadmin/uploadUserFoto', 'Auth\RegisterController@uploadUserFoto');
	Route::post('/grimmadmin/articoli/nuovo', 'PostController@store');
	Route::post('/grimmadmin/categoria/nuovo', 'CategoriaController@store');
	Route::post('/grimmadmin/uploadPostFoto', 'PostController@uploadPostFoto');
	Route::post('/grimmadmin/uploadPostFoto/cancella', 'PostController@resettaFoto');
	Route::post('/grimmadmin/articoli/cancella', 'PostController@cancella');
	Route::post('/grimmadmin/articoli/update/{id}', 'PostController@update');

	Route::post('/grimmadmin/evento/nuovo', 'EventoController@store');
	Route::post('/grimmadmin/evento/approva', 'EventoController@approva');
	Route::post('/grimmadmin/evento/elimina', 'EventoController@elimina');
	Route::post('/grimmadmin/eventi/cancella', 'EventoController@cancella');
	Route::post('/grimmadmin/evento/update/{id}', 'EventoController@update');
	Route::post('/grimmadmin/uploadFotoEvento', 'EventoController@uploadFoto');
	Route::post('/grimmadmin/uploadFotoEvento/cancella', 'EventoController@resettaFoto');
	Route::post('/grimmadmin/user/approva', 'Auth\RegisterController@approva');
	Route::post('/grimmadmin/user/elimina', 'Auth\RegisterController@elimina');

	Route::post('/grimmadmin/modificaUser', 'Auth\RegisterController@modifica');

});












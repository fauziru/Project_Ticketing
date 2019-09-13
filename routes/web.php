<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/api/start/{n_f}','compress_C@compress');
$router->get('/api/delete/{n_f}','compress_C@delete');
$router->get('/api/operasi/{operasi}','operasi_C@operasi');

$router->get('/api/ticket', 'req_C@ambil');
$router->get('/api/kat', 'req_C@fkat');
$router->get('/api/pic', 'req_C@fpic');
$router->get('/api/pri', 'req_C@fpri');
$router->get('/api/stat', 'req_C@fstat');
$router->get('/api/ticket/{id}', 'req_C@detil');
$router->post('/api/ticket','req_C@tiketmasuk');
$router->put('/api/ticket/editinline/{id}','req_C@editinlinetiket');
$router->put('/api/ticket/edit/{id}','req_C@editalltiket');
$router->put('/api/ticket/{id}','req_C@urustiket');
$router->put('/api/ticket/done/{id}','req_C@tiketselesai');
$router->delete('/api/ticket/{id}','req_C@hapustiket');
$router->post('/api/ticket/tes','req_C@tes');

$router->get('/{route:.*}/', function ()  {
    return view('app');
});


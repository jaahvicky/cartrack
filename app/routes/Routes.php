<?php

Route::set('', function () {
    Dispatch::resource('HomeController');
});
Route::set('404', function () {
    return Response::sendJson(["message" => 'Invalid route.'], 404);
});
Route::set('api/vehicles', function () {
    Dispatch::resource('VehicleController');
});